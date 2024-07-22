<?php

// app/Filament/Resources/BlogResource.php
namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Blog Details')
                    ->schema([
                        Forms\Components\Grid::make(2) // 2 columns grid
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->maxLength(255)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' || $operation === 'edit' ? $set('slug', Str::slug($state)) : null)
                                    ->columnSpan(1), // Full width
                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Blog::class, 'slug', ignoreRecord: true)
                                    ->columnSpan(1), // Full width
                                Forms\Components\TextInput::make('author')
                                    ->label('Penulis')
                                    ->required()
                                    ->default(fn () => Auth::user()->name)
                                    ->maxLength(255)
                                    ->columnSpan(1), // Half width
                                Forms\Components\DateTimePicker::make('published_date')
                                    ->label('Tanggal Publikasi')
                                    ->required()
                                    ->default(Carbon::now()) // Set default to current date
                                    ->columnSpan(1), // Half width
                                Forms\Components\TagsInput::make('tags')
                                    ->label('Tags')
                                    ->columnSpan(2), // Full width
                            ]),
                    ]),
                Forms\Components\Section::make('Content')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->label('Konten')
                            ->required()
                            ->columnSpan('full'), // Full width
                    ]),
                Forms\Components\Section::make('Image')
                    ->schema([
                        Forms\Components\Grid::make(2) // 2 columns grid
                            ->schema([
                                Forms\Components\FileUpload::make('banner_image')
                                    ->label('Gambar')
                                    ->image()
                                    ->required()
                                    ->directory('blog-images')
                                    ->preserveFilenames()
                                    ->getUploadedFileNameForStorageUsing(function ($file) {
                                        $timestamp = now()->format('YmdHis');
                                        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                                        $extension = $file->getClientOriginalExtension();
                                        return "{$filename}-{$timestamp}.{$extension}";
                                    })
                                    ->columnSpan(2), // Full width
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->limit(30), // Limit the text to 30 characters
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->limit(30), // Limit the text to 30 characters
                Tables\Columns\TextColumn::make('author')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_date')
                    ->label('Tanggal Publikasi')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('banner_image')
                    ->label('Gambar'),
                Tables\Columns\TextColumn::make('tags')
                    ->label('Tags')
                    ->limit(30), // Limit the text to 30 characters
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
