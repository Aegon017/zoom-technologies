<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManualOrderResource\Pages;
use App\Models\Course;
use App\Models\ManualOrder;
use App\Models\Package;
use App\Models\Schedule;
use App\Models\Tax;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ManualOrderResource extends Resource
{
    protected static ?string $model = ManualOrder::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Manual Enroll';
    protected static ?string $label = 'Manual Enroll';
    protected static ?string $slug = 'manual-enroll';
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
                                TextInput::make('user_email'),
                                TextInput::make('user_phone'),
                            ]),
                        Tab::make('Course Details')
                            ->schema([
                                Select::make('course_id')
                                    ->label('Course')
                                    ->options(Course::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $set('schedule_id', null);
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
                                Select::make('schedule_id')
                                    ->label('Schedule')
                                    ->options(function ($get) {
                                        if ($get('course_id')) {
                                            $courseId = $get('course_id');
                                            if ($courseId) {
                                                return Schedule::where('course_id', $courseId)
                                                    ->get()
                                                    ->pluck('formatted_schedule', 'id');
                                            }
                                        }
                                        return [];
                                    })
                                    ->searchable()
                                    ->disabled(function ($get) {
                                        return !$get('course_id');
                                    })
                            ]),
                        Tab::make('Package Details')
                            ->schema([
                                Select::make('package_id')
                                    ->label('Package')
                                    ->options(Package::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $set) {
                                        $set('schedule_id', null);
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
                                                $packageCourses = Course::findMany($package->courses);
                                                $set('packageCourses', $packageCourses);
                                            }
                                        }
                                    }),
                                Select::make('packageSchedule_id')
                                    ->label('Schedule')
                                    ->options(function ($get) {
                                        if ($get('package_id')) {
                                            // Get the package
                                            $package = Package::find($get('package_id'));

                                            if ($package) {
                                                // Get all course IDs in the package
                                                $courseIds = $package->courses;

                                                // Retrieve schedules for all courses in the package
                                                $schedules = Schedule::whereIn('course_id', $courseIds)
                                                    ->get()
                                                    ->pluck('formatted_schedule', 'id');

                                                return $schedules;
                                            }
                                        }

                                        return [];
                                    })
                                    ->searchable()
                                    ->multiple()
                                    ->disabled(function ($get) {
                                        return !$get('package_id');
                                    })
                            ]),
                        Tab::make('Price Details')
                            ->schema([
                                TextInput::make('course_price')
                                    ->label('Course price')
                                    ->numeric()
                                    ->required()
                                    ->readOnly()
                                    ->default(function ($get) {
                                        return $get('course_price');
                                    })->required(),

                                TextInput::make('cgst')
                                    ->helperText(function ($get) {
                                        $cgstPercentage = $get('cgst_percentage');
                                        return "CGST - {$cgstPercentage}%";
                                    })
                                    ->label('CGST')
                                    ->readOnly()
                                    ->required(),

                                TextInput::make('sgst')
                                    ->helperText(function ($get) {
                                        $sgstPercentage = $get('sgst_percentage');
                                        return "SGST - {$sgstPercentage}%";
                                    })
                                    ->label('SGST')
                                    ->readOnly()
                                    ->required(),

                                TextInput::make('amount')
                                    ->label('Total Amount')
                                    ->readOnly()
                                    ->required(),
                                Select::make('payment_mode')->options([
                                    'Cash' => 'Cash',
                                    'UPI' => 'UPI',
                                    'Cheque' => 'Cheque'
                                ])->required(),
                                FileUpload::make('proof')->required()
                            ])
                    ])->columns(2)->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_name')->label('User name'),
                TextColumn::make('user_email')->label('User email'),
                TextColumn::make('user_phone')->label('User phone'),
                TextColumn::make('combined')
                    ->label('Course and Package Name')
                    ->getStateUsing(function ($record) {
                        $course =  $record->course->name ?? $record->package->name;
                        return $course;
                    }),
                TextColumn::make('payment_mode'),
                TextColumn::make('amount'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('proof')
                    ->label('download proof')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return response()->download(storage_path("app/public/{$record->proof}"));
                    }),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListManualOrders::route('/'),
            'create' => Pages\CreateManualOrder::route('/create'),
            'edit' => Pages\EditManualOrder::route('/{record}/edit'),
        ];
    }
}
