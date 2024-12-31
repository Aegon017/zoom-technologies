<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageCourseResource\Pages;
use App\Models\ManualOrder;
use App\Models\Package;
use App\Models\Schedule;
use App\Models\Tax;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Student Details')
                        ->schema([
                            TextInput::make('user_name')->required(),
                            TextInput::make('user_email')->required()
                                ->unique(User::class, 'email', ignoreRecord: true)
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
                            TextInput::make('user_phone')->required()
                                ->unique(User::class, 'phone', ignoreRecord: true)
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
                                    'Bank transfer' => 'Bank transfer',
                                    'UPI' => 'UPI',
                                    'POS' => 'POS',
                                    'Cash' => 'Cash',
                                ]),
                            FileUpload::make('proof')->required(),
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
            ])
            ->bulkActions([])
            ->modifyQueryUsing(fn(Builder $query) => $query->whereNotNull('package_id'));
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
