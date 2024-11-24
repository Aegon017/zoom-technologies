<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ManualOrderResource\Pages;
use App\Filament\Resources\ManualOrderResource\RelationManagers;
use App\Models\Course;
use App\Models\ManualOrder;
use App\Models\Package;
use App\Models\Schedule;
use App\Models\Tax;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ManualOrderResource extends Resource
{
    protected static ?string $model = ManualOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')->options(User::all()->pluck('email', 'id'))->label('Student email')->searchable()->required(),
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

                                $tax = Tax::first();

                                if ($tax) {
                                    $cgst = $course->actual_price * ($tax->cgst / 100);
                                    $sgst = $course->actual_price * ($tax->sgst / 100);

                                    $set('cgst', $cgst);
                                    $set('sgst', $sgst);

                                    $amount = $course->actual_price + $cgst + $sgst;

                                    $set('amount', $amount);

                                    $set('cgst_percentage', $tax->cgst);
                                    $set('sgst_percentage', $tax->sgst);
                                }
                            }
                        }
                    }),

                Select::make('schedule_id')
                    ->label('Schedule')
                    ->options(function ($get) {
                        $courseId = $get('course_id');

                        if ($courseId) {
                            return Schedule::where('course_id', $courseId)
                                ->get()
                                ->pluck('formatted_schedule', 'id');
                        }

                        return [];
                    })
                    ->searchable()
                    ->disabled(function ($get) {
                        return !$get('course_id');
                    }),

                TextInput::make('course_price')
                    ->label('Course price')
                    ->numeric()
                    ->required()
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
                TextInput::make('payment_mode')->required()


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User name'),
                TextColumn::make('user.email')->label('User email'),
                TextColumn::make('user.phone')->label('User phone'),
                TextColumn::make('course.name'),
                TextColumn::make('schedule.start_date')->label('Batch date'),
                TextColumn::make('schedule.time')->label('Batch time'),
                TextColumn::make('schedule.training_mode')->label('Training mode'),
                TextColumn::make('payment_mode'),
                TextColumn::make('amount'),
            ])
            ->filters([
                //
            ])
            ->actions([])
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
