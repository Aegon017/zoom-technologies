<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseCoordinatorResource\Pages;
use App\Filament\Resources\CourseCoordinatorResource\RelationManagers;
use App\Models\Course;
use App\Models\CourseCoordinator;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseCoordinatorResource extends Resource
{
    protected static ?string $model = CourseCoordinator::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Course Certificates';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('course_id')
                    ->options(function ($record) {
                        if ($record) {
                            return Course::pluck('name', 'id');
                        }
                        return Course::whereDoesntHave('courseCoordinator')->pluck('name', 'id');
                    })
                    ->label('Course Name')
                    ->required(),
                TextInput::make('coordinator_name')->required(),
                FileUpload::make('signature_image')->image()->required()->disk('public')->directory('courseCoordinators')->preserveFilenames()->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.name')->label('Course name')->searchable(),
                TextColumn::make('coordinator_name')->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListCourseCoordinators::route('/'),
            'create' => Pages\CreateCourseCoordinator::route('/create'),
            'edit' => Pages\EditCourseCoordinator::route('/{record}/edit'),
        ];
    }
}
