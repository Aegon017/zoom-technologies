<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers\CurriculumRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\FaqRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\GuidelineRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\MetaDetailRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\OverviewRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\SampleCertificateRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\ScheduleRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\StudyMaterialRelationManager;
use App\Filament\Resources\CourseResource\RelationManagers\SubCurriculumRelationManager;
use App\Models\Course;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationGroup = 'Courses & Packages';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Single Courses';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Course Details')->schema([
                        TextInput::make('position')->numeric()->required()->helperText('Position of the course in the list'),
                        TextInput::make('name')->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->required(),
                        TextInput::make('slug')->prefix('training/india/')->columnSpanFull()->required(),
                        RichEditor::make('short_description')->columnSpanFull()->required(),
                        TextInput::make('duration')->required(),
                        Select::make('duration_type')->options(['Month' => 'Month', 'Week' => 'Week', 'Day' => 'Day'])->required(),
                        Select::make('training_mode')->multiple()->options(['Online' => 'Online', 'Classroom' => 'Classroom'])->columnSpanFull()->required(),
                        TextInput::make('sale_price')->label('Sale price')->prefix('Rs.'),
                        TextInput::make('actual_price')->label('Actual price')->prefix('Rs.')->required(),
                    ])->columns(2),
                    Section::make('Placement & Certification')->schema([
                        Radio::make('placement')->boolean()->label('Placement assistance')->inline()->required(),
                        Radio::make('certificate')->boolean()->inline()->required(),
                    ]),
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('Course Media')->schema([
                        FileUpload::make('thumbnail')->disk('public')->directory('thumbnails/courses')->preserveFilenames()->columnSpanFull()->required(),
                        TextInput::make('thumbnail_alt')->columnSpanFull()->required(),
                        FileUpload::make('image')->disk('public')->directory('images/courses')->preserveFilenames()->columnSpanFull()->required(),
                        TextInput::make('image_alt')->columnSpanFull()->required(),
                        FileUpload::make('outline_pdf')->label('Outline Pdf')->disk('public')->directory('outline_PDFs')->preserveFilenames(),
                        TextInput::make('video_link')->required(),
                    ]),
                    Section::make('Statistics')->schema([
                        TextInput::make('rating')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(5)
                            ->step(0.1)
                            ->label('Rating (0-5)'),

                        TextInput::make('number_of_ratings')
                            ->required()
                            ->numeric()
                            ->label('Number of Ratings'),

                        TextInput::make('number_of_students')
                            ->required()
                            ->numeric()
                            ->label('Number of Students'),
                    ]),
                ]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')->rowIndex(),
                ImageColumn::make('thumbnail')->height(120)->width(204),
                TextColumn::make('name')->searchable(),
                TextColumn::make('training_mode'),
                TextColumn::make('sale_price'),
                TextColumn::make('actual_price'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
                Tables\Actions\Action::make('replicate')
                    ->label('Duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->action(function (Course $record) {
                        $newCourse = self::replicateCourse($record);
                    })
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('position', 'asc');
    }

    public static function replicateCourse(Course $course)
    {
        $baseName = 'Copy of '.$course->name;
        $uniqueName = self::generateUniqueName($baseName);
        $uniqueSlug = self::generateUniqueSlug(Str::slug($uniqueName));
        $newCourse = $course->replicate([
            'id',
            'created_at',
            'updated_at',
        ]);
        $newCourse->name = $uniqueName;
        $newCourse->slug = $uniqueSlug;
        $newCourse->save();
        self::replicateRelatedModels($course, $newCourse);
        Notification::make()
            ->title('Course Duplicated')
            ->body("'{$newCourse->name}' has been created")
            ->success()
            ->send();

        return $newCourse;
    }

    protected static function generateUniqueName(string $baseName): string
    {
        $newName = $baseName;
        $counter = 1;

        while (Course::where('name', $newName)->exists()) {
            $newName = $baseName.' ('.$counter.')';
            $counter++;
        }

        return $newName;
    }

    protected static function generateUniqueSlug(string $baseSlug): string
    {
        $newSlug = $baseSlug;
        $counter = 1;

        while (Course::where('slug', $newSlug)->exists()) {
            $newSlug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $newSlug;
    }

    protected static function replicateRelatedModels(Course $originalCourse, Course $newCourse)
    {
        $relationsToReplicate = [
            'metaDetail',
            'overview',
            'curriculum',
            'schedule',
            'guideline',
            'sampleCertificate',
            'studyMaterial',
            'faq',
        ];

        foreach ($relationsToReplicate as $relation) {
            if (method_exists($originalCourse, $relation) && $originalCourse->$relation()->exists()) {
                $originalCourse->$relation->each(function ($relatedModel) use ($newCourse) {
                    $newRelatedModel = $relatedModel->replicate([
                        'id',
                        'created_at',
                        'updated_at',
                        'course_id',
                    ]);
                    $newRelatedModel->course_id = $newCourse->id;
                    $newRelatedModel->save();
                });
            }
        }
    }

    public static function getRelations(): array
    {
        return [
            MetaDetailRelationManager::class,
            OverviewRelationManager::class,
            CurriculumRelationManager::class,
            SubCurriculumRelationManager::class,
            ScheduleRelationManager::class,
            GuidelineRelationManager::class,
            SampleCertificateRelationManager::class,
            StudyMaterialRelationManager::class,
            FaqRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
