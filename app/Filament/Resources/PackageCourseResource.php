<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageCourseResource\Pages;
use App\Models\ManualOrder;
use App\Models\Package;
use App\Models\Schedule;
use App\Models\Tax;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
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
use Ysfkaya\FilamentPhoneInput\Forms\PhoneInput;

class PackageCourseResource extends Resource
{
    protected static ?string $model = ManualOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Package Course Enroll';

    protected static ?string $label = 'Package Course Enroll';

    protected static ?string $slug = 'package-course-enroll';

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
                    TextEntry::make('user_name')->label('Student Name'),
                    TextEntry::make('user_email')->label('Email'),
                    TextEntry::make('user_phone')->label('Phone'),
                    ComponentsSection::make()->schema([
                        ImageEntry::make('user_image')->label('Student Image'),
                        ImageEntry::make('user_id_card')->label('Student Id '),
                    ])->columns(2),
                ]),
                Fieldset::make('Course Details')->schema([
                    TextEntry::make('package.name'),
                    TextEntry::make('course_price')->label('Price')
                        ->formatStateUsing(fn ($state, $record) => 'Rs.'.' '.$state),
                ]),
                Fieldset::make('Batches')->schema([
                    TextEntry::make('schedule')
                        ->label('')
                        ->listWithLineBreaks()
                        ->getStateUsing(
                            fn ($record) => ! $record->packageSchedule_id
                                ? ['🚫 No Schedules Available']
                                : collect($record->packageSchedule_id)
                                    ->map(function ($os) {
                                        $s = Schedule::find($os);

                                        return $s ? [
                                            '📚 Course: '.($s->course?->name ?? 'N/A'),
                                            '📅 Date: '.(
                                                $s->start_date
                                                ? \Carbon\Carbon::parse($s->start_date)->format('d M Y')
                                                : 'Unscheduled'
                                            ),
                                            '⏰ Time: '.(
                                                $s->time
                                                ? \Carbon\Carbon::parse($s->time)->format('h:i A')
                                                : 'TBD'
                                            ),
                                            '🌐 Mode: '.($s->training_mode ?? 'Unspecified'),
                                        ] : ['⚠️ Invalid Schedule'];
                                    })
                                    ->flatten()
                                    ->filter()
                                    ->toArray()
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
                            TextInput::make('user_name')->required()->label('Student Name'),
                            TextInput::make('user_email')->required()
                                ->unique('users', 'email')
                                ->label('Email'),
                            PhoneInput::make('user_phone')->required()
                                ->unique('users', 'phone')
                                ->label('Phone Number'),
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
                    Step::make('Package Course Details')
                        ->schema([
                            Select::make('package_id')
                                ->required()
                                ->label('Package')
                                ->options(Package::all()->pluck('name', 'id'))
                                ->searchable()
                                ->reactive()
                                ->afterStateUpdated(function ($state, $set) {
                                    $set('course_price', null);
                                    $set('cgst', null);
                                    $set('sgst', null);
                                    $set('amount', null);
                                    $set('packageCourses', null);
                                    if ($state) {
                                        $package = Package::find($state);
                                        if ($package) {
                                            $set('course_price', $package->actual_price);
                                            $cgstPercentage = Tax::where('name', 'CGST')->first()->value;
                                            $sgstPercentage = Tax::where('name', 'SGST')->first()->value;
                                            $cgst = $package->actual_price * ($cgstPercentage / 100);
                                            $sgst = $package->actual_price * ($sgstPercentage / 100);
                                            $set('cgst', $cgst);
                                            $set('sgst', $sgst);
                                            $amount = $package->actual_price + $cgst + $sgst;
                                            $set('amount', $amount);
                                            $set('cgst_percentage', $cgstPercentage);
                                            $set('sgst_percentage', $sgstPercentage);
                                        }
                                    }
                                }),
                            Select::make('training_mode')
                                ->required()
                                ->options([
                                    'Online' => 'Online',
                                    'Classroom' => 'Classroom',
                                ])
                                ->afterStateUpdated(function ($state, $set) {
                                    $set('training_mode', $state);
                                })
                                ->disabled(function ($get) {
                                    return ! $get('package_id');
                                }),
                            Select::make('packageSchedule_id')
                                ->required()
                                ->label('Schedule')
                                ->options(function ($get) {
                                    if ($get('package_id')) {
                                        $trainingMode = $get('training_mode');
                                        $courseIds = Package::find($get('package_id'))->courses;
                                        $schedules = Schedule::whereIn('course_id', $courseIds)->where('training_mode', $trainingMode)->get()->pluck('formatted_package_schedule', 'id');

                                        return $schedules;
                                    }

                                    return [];
                                })
                                ->searchable()
                                ->multiple()
                                ->disabled(function ($get) {
                                    return ! $get('package_id');
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
                            Select::make('payment_mode')
                                ->required()
                                ->options([
                                    'UPI' => 'UPI',
                                    'Card' => 'Card',
                                    'QR Code' => 'QR Code',
                                    'Bank transfer' => 'Bank transfer',
                                    'POS' => 'POS',
                                    'Cash' => 'Cash',
                                ]),
                            FileUpload::make('proof')->image()->required(),
                        ]),
                ])->columns(2)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_name')->label('Student name'),
                TextColumn::make('user_email')->label('Student email')->searchable(),
                TextColumn::make('user_phone')->label('Student phone'),
                TextColumn::make('package.name'),
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
            ->modifyQueryUsing(fn (Builder $query) => $query->whereNotNull('package_id'));
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
            'index' => Pages\ListPackageCourses::route('/'),
            'create' => Pages\CreatePackageCourse::route('/create'),
            'edit' => Pages\EditPackageCourse::route('/{record}/edit'),
        ];
    }
}
