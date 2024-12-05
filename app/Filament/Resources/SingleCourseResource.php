<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SingleCourseResource\Pages;
use App\Models\Course;
use App\Models\ManualOrder;
use App\Models\Schedule;
use App\Models\Tax;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('User Details')
                            ->schema([
                                TextInput::make('user_name'),
                                TextInput::make('user_email')
                                    ->live()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $get) {
                                        if (User::where('email', $state)->exists()) {
                                            Notification::make()
                                                ->title('Email already exists')
                                                ->body('The email you entered is already registered. Please use a different email.')
                                                ->danger()
                                                ->send();
                                        }
                                    }),
                                TextInput::make('user_phone')
                                    ->live()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $get) {
                                        if (User::where('phone', $state)->exists()) {
                                            Notification::make()
                                                ->title('Phone number already exists')
                                                ->body('The phone number you entered is already registered. Please use a different phone number.')
                                                ->danger()
                                                ->send();
                                        }
                                    }),
                            ]),
                        Tab::make('Address Details')
                            ->schema([
                                TextInput::make('address'),
                                TextInput::make('city'),
                                TextInput::make('state'),
                                TextInput::make('zip_code'),
                                TextInput::make('country'),
                            ]),
                        Tab::make('Course Details')
                            ->schema([
                                Select::make('course_id')

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
                                Select::make('training_mode')

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
                                Select::make('schedule_id')

                                    ->label('Schedule')
                                    ->options(function ($get) {
                                        if ($get('course_id')) {
                                            $courseId = $get('course_id');
                                            $trainingMode = $get('training_mode');
                                            if ($courseId) {
                                                return Schedule::where('course_id', $courseId)->where('training_mode', $trainingMode)->get()->pluck('formatted_schedule', 'id');
                                            }
                                        }

                                        return [];
                                    })
                                    ->searchable()
                                    ->disabled(function ($get) {
                                        return ! $get('course_id');
                                    }),
                            ]),
                        Tab::make('Price Details')
                            ->schema([
                                TextInput::make('course_price')
                                    ->label('Course price')
                                    ->numeric()

                                    ->readOnly()
                                    ->default(function ($get) {
                                        return $get('course_price');
                                    }),

                                TextInput::make('cgst')
                                    ->helperText(function ($get) {
                                        $cgstPercentage = $get('cgst_percentage');

                                        return "CGST - {$cgstPercentage}%";
                                    })
                                    ->label('CGST')
                                    ->readOnly(),

                                TextInput::make('sgst')
                                    ->helperText(function ($get) {
                                        $sgstPercentage = $get('sgst_percentage');

                                        return "SGST - {$sgstPercentage}%";
                                    })
                                    ->label('SGST')
                                    ->readOnly(),

                                TextInput::make('amount')
                                    ->label('Total Amount')
                                    ->readOnly(),
                                Select::make('payment_mode')->options([
                                    'Bank transfer' => 'Bank transfer',
                                    'UPI' => 'UPI',
                                    'POS' => 'POS',
                                    'Cash' => 'Cash',
                                ]),
                                FileUpload::make('proof'),
                            ]),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_name')->label('User name'),
                TextColumn::make('user_email')->label('User email')->searchable(),
                TextColumn::make('user_phone')->label('User phone'),
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
