<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SingleCourseResource\Pages;
use App\Models\Course;
use App\Models\ManualOrder;
use App\Models\Schedule;
use App\Models\Tax;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section as ComponentsSection;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class SingleCourseResource extends Resource
{
    protected static ?string $model = ManualOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Single Course Enroll';

    protected static ?string $label = 'Single Course Enroll';

    protected static ?string $slug = 'single-course-enroll';

    protected static ?string $navigationGroup = 'Offline Enrolls';

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Fieldset::make('Student Details')->schema([
                    TextEntry::make('user_name')
                        ->label('Student Name')
                        ->getStateUsing(fn ($record) => $record->is_registered ? $record->user->name : $record->user_name),
                    TextEntry::make('user_email')
                        ->label('Email')
                        ->getStateUsing(fn ($record) => $record->is_registered ? $record->user->email : $record->user_email),
                    TextEntry::make('user_phone')
                        ->label('Phone')
                        ->getStateUsing(fn ($record) => $record->is_registered ? $record->user->phone : $record->user_email),
                    ComponentsSection::make()->schema([
                        ImageEntry::make('user_image')->label('Student Image'),
                        ImageEntry::make('user_id_card')->label('Student Id '),
                    ])->columns(2),
                ]),
                Fieldset::make('Course Details')->schema([
                    TextEntry::make('course.name'),
                    TextEntry::make('course_price')->label('Price')
                        ->formatStateUsing(fn ($state, $record) => 'Rs.'.' '.$state),
                ]),
                Fieldset::make('Batches')->schema([
                    TextEntry::make('schedule')
                        ->label('')
                        ->listWithLineBreaks()
                        ->getStateUsing(
                            fn ($record) => ! $record->schedule
                                ? ['🚫 No Schedules Available']
                                : [
                                    '📚 Course: '.($record->schedule->first()->course?->name ?? 'N/A'),
                                    '📅 Date: '.(
                                        $record->schedule->first()->start_date
                                        ? \Carbon\Carbon::parse($record->schedule->first()->start_date)->format('d M Y')
                                        : 'Unscheduled'
                                    ),
                                    '⏰ Time: '.(
                                        $record->schedule->first()->time
                                        ? \Carbon\Carbon::parse($record->schedule->first()->time)->format('h:i A')
                                        : 'TBD'
                                    ),
                                    '🌐 Mode: '.($record->schedule->first()->training_mode ?? 'Unspecified'),
                                ]

                        )
                        ->placeholder('No schedule information'),
                ]),
                Fieldset::make('Payment Details')->schema([
                    TextEntry::make('payment_mode'),
                    TextEntry::make('cgst')
                        ->formatStateUsing(fn ($state, $record) => 'Rs.'.' '.$state),
                    TextEntry::make('sgst')
                        ->formatStateUsing(fn ($state, $record) => 'Rs.'.' '.$state),
                    TextEntry::make('amount')
                        ->formatStateUsing(fn ($state, $record) => 'Rs.'.' '.$state),
                ]),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Student Details')
                        ->schema([
                            TextInput::make('enrolled_by')->readOnly()->default(Auth::user()->name),
                            Radio::make('is_registered')
                                ->label('Already Registered Student')
                                ->reactive()
                                ->boolean()
                                ->default(false),
                            Group::make()->schema([
                                Select::make('user_id')->label('Select Student Email')->options(User::pluck('email', 'id'))->hidden(fn (Get $get): bool => ! $get('is_registered'))->searchable()->required(),
                                TextInput::make('user_name')->visible(fn (Get $get): bool => ! $get('is_registered'))->required()->label('Student Name'),
                                TextInput::make('user_email')->visible(fn (Get $get): bool => ! $get('is_registered'))->required()
                                    ->unique('users', 'email')
                                    ->label('Email'),
                                PhoneInput::make('user_phone')->visible(fn (Get $get): bool => ! $get('is_registered'))->required()
                                    ->unique('users', 'phone')
                                    ->label('Phone Number'),
                            ]),
                            Section::make()->schema([
                                FileUpload::make('user_image')->image()->label('Student photo')->disk('public')->directory('users/profile-images')->required(),
                                FileUpload::make('user_id_card')->image()->label('Student ID Card')->disk('public')->directory('users/id_cards')->required(),
                            ])->columns(2),
                        ]),
                    Step::make('Address Details')
                        ->schema([
                            TextInput::make('address')->required(),
                            TextInput::make('city')->required(),
                            TextInput::make('state')->required(),
                            TextInput::make('zip_code')->required(),
                            TextInput::make('country')->required(),
                        ]),
                    Step::make('Course Details')
                        ->schema([
                            Select::make('course_id')->required()
                                ->label('Course')
                                ->options(Course::all()->pluck('name', 'id'))
                                ->searchable()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set) {
                                    $set('course_price', null);
                                    $set('cgst', null);
                                    $set('sgst', null);
                                    $set('amount', null);
                                    if ($state) {
                                        $course = Course::find($state);
                                        if ($course) {
                                            $set('course_price', $course->actual_price);
                                            $cgstPercentage = Tax::where('name', 'CGST')->first()->value;
                                            $sgstPercentage = Tax::where('name', 'SGST')->first()->value;
                                            if ($cgstPercentage && $sgstPercentage) {
                                                $cgst = $course->actual_price * ($cgstPercentage / 100);
                                                $sgst = $course->actual_price * ($sgstPercentage / 100);
                                                $set('cgst', $cgst);
                                                $set('sgst', $sgst);
                                                $amount = $course->actual_price + $cgst + $sgst;
                                                $set('amount', $amount);
                                                $set('cgst_percentage', $cgstPercentage);
                                                $set('sgst_percentage', $sgstPercentage);
                                            }
                                        }
                                    }
                                }),
                            Select::make('training_mode')->required()
                                ->options([
                                    'Online' => 'Online',
                                    'Classroom' => 'Classroom',
                                ])
                                ->afterStateUpdated(function ($state, $set) {
                                    $set('training_mode', $state);
                                })
                                ->disabled(function ($get) {
                                    return ! $get('course_id');
                                }),
                            Select::make('schedule_id')->required()
                                ->label('Schedule')
                                ->options(function ($get) {
                                    if ($get('course_id')) {
                                        $courseId = $get('course_id');
                                        $trainingMode = $get('training_mode');
                                        if ($courseId) {
                                            return Schedule::where('status', true)->where('course_id', $courseId)->where('training_mode', $trainingMode)->orderBy('start_date', 'asc')->orderBy('time', 'asc')->get()->pluck('formatted_schedule', 'id');
                                        }
                                    }

                                    return [];
                                })
                                ->preload()
                                ->searchable()
                                ->disabled(function ($get) {
                                    return ! $get('course_id');
                                }),
                        ]),
                    Step::make('Payment Details')
                        ->schema([
                            TextInput::make('course_price')
                                ->label('Course price')
                                ->numeric()
                                ->required()
                                ->readOnly()
                                ->default(function ($get) {
                                    return $get('course_price');
                                }),

                            TextInput::make('cgst')
                                ->required()
                                ->helperText(function ($get) {
                                    $cgstPercentage = $get('cgst_percentage');

                                    return "CGST - {$cgstPercentage}%";
                                })
                                ->label('CGST')
                                ->readOnly(),

                            TextInput::make('sgst')
                                ->required()
                                ->helperText(function ($get) {
                                    $sgstPercentage = $get('sgst_percentage');

                                    return "SGST - {$sgstPercentage}%";
                                })
                                ->label('SGST')
                                ->readOnly(),

                            TextInput::make('amount')
                                ->required()
                                ->label('Total Amount')
                                ->readOnly(),
                            Select::make('payment_mode')->options([
                                'UPI' => 'UPI',
                                'Card' => 'Card',
                                'QR Code' => 'QR Code',
                                'Bank transfer' => 'Bank transfer',
                                'POS' => 'POS',
                                'Cash' => 'Cash',
                            ])->required(),
                            FileUpload::make('proof')->image()->required(),
                        ]),
                ])->columns(2)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('enrolled_by'),
                TextColumn::make('user_name')
                    ->label('Student name')
                    ->getStateUsing(fn ($record) => $record->is_registered ? $record->user->name : $record->user_name)
                    ->searchable(),

                TextColumn::make('user_email')
                    ->label('Student email')
                    ->getStateUsing(fn ($record) => $record->is_registered ? $record->user->email : $record->user_email)
                    ->searchable(),

                TextColumn::make('user_phone')
                    ->label('Student phone')
                    ->getStateUsing(fn ($record) => $record->is_registered ? $record->user->phone : $record->user_phone)
                    ->searchable(),
                TextColumn::make('course.name')->label('Course name')->searchable(),
                TextColumn::make('payment_mode'),
                TextColumn::make('amount'),
            ])
            ->filters([])
            ->actions([
                Action::make('proof')
                    ->label('download proof')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return response()->download(storage_path("app/public/{$record->proof}"));
                    }),
                ViewAction::make(),
            ])
            ->bulkActions([])
            ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('course_id'));
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSingleCourses::route('/'),
            'create' => Pages\CreateSingleCourse::route('/create'),
            'edit' => Pages\EditSingleCourse::route('/{record}/edit'),
        ];
    }
}
