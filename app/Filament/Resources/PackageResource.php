<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Filament\Resources\PackageResource\RelationManagers\FaqRelationManager;
use App\Filament\Resources\PackageResource\RelationManagers\GuidelineRelationManager;
use App\Filament\Resources\PackageResource\RelationManagers\MetaDetailRelationManager;
use App\Filament\Resources\PackageResource\RelationManagers\OverviewRelationManager;
use App\Filament\Resources\PackageResource\RelationManagers\StudyMaterialRelationManager;
use App\Models\Course;
use App\Models\Package;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationLabel = 'Courses package';
    protected static ?int $navigationSort = 4;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Courses package details')->schema([
                        TextInput::make('name')->live(onBlur: true)
                            ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state)))->required(),
                        TextInput::make('slug')->prefix('training/india/')->required(),
                        RichEditor::make('short_description')->columnSpanFull()->required(),
                        TextInput::make('duration')->required(),
                        Select::make('duration_type')->options(['Month' => 'Month', 'Week' => 'Week', 'Day' => 'Day'])->required(),
                        Select::make('training_mode')->multiple()->options(['Online' => 'Online', 'Classroom' => 'Classroom'])->columnSpanFull()->required(),
                        TextInput::make('price')->label('Regular price')->prefix('Rs.')->required(),
                        TextInput::make('original_price')->label('Offer price')->prefix('Rs.')
                    ])->columns(2),
                    Section::make('Placement & Certification')->schema([
                        Radio::make('placement')->boolean()->label('Placement assistance')->inline()->required(),
                        Radio::make('certificate')->boolean()->inline()->required()
                    ])
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('Courses package media')->schema([
                        FileUpload::make('thumbnail')->disk('public')->directory('thumbnails/packages')->preserveFilenames()->columnSpanFull()->required(),
                        TextInput::make('thumbnail_alt')->columnSpanFull()->required(),
                        FileUpload::make('image')->disk('public')->directory('images/packages')->preserveFilenames()->columnSpanFull()->required(),
                        TextInput::make('image_alt')->columnSpanFull()->required(),
                        TextInput::make('video_link')->required()
                    ]),
                    Section::make('Courses')->schema([
                        Select::make('courses')->label('Select courses')->multiple()->options(Course::all()->pluck('name', 'id'))->searchable()
                    ])
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
                TextColumn::make('price'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
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
            MetaDetailRelationManager::class,
            OverviewRelationManager::class,
            GuidelineRelationManager::class,
            FaqRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
