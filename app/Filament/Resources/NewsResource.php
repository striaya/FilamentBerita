<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Konten Berita';

    protected static ?string $navigationLabel = 'Berita';

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        return $form->schema([
            Select::make('author_id')
                ->relationship('author', 'username')
                ->searchable()
                ->preload()
                ->required()
                // Jika login sebagai author: auto-select id author sendiri & kunci field-nya
                ->default(fn () => $user?->isAuthor() ? $user->author?->id : null)
                ->disabled(fn () => $user?->isAuthor())
                ->dehydrated(),

            Select::make('news_category_id')
                ->label('Kategori')
                ->relationship('category', 'title')
                ->searchable()
                ->preload()
                ->required(),

            TextInput::make('title')
                ->label('Judul')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(fn (string $context, $state, callable $set) =>
                    $context === 'create' ? $set('slug', Str::slug($state)) : null)
                ->maxLength(255),

            TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(255),

            FileUpload::make('thumbnail')
                ->image()
                ->directory('news/thumbnails')
                ->imageEditor()
                ->columnSpanFull(),

            RichEditor::make('content')
                ->required()
                ->columnSpanFull(),

            Toggle::make('is_featured')
                ->label('Berita Unggulan'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')->disk('public'),
                TextColumn::make('author.username')->label('Author')->searchable()->sortable(),
                TextColumn::make('category.title')->label('Kategori')->searchable()->sortable(),
                TextColumn::make('title')->searchable()->limit(40),
                TextColumn::make('slug')->searchable()->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_featured')->label('Unggulan'),
                TextColumn::make('created_at')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('author_id')
                    ->label('Author')
                    ->relationship('author', 'username'),

                SelectFilter::make('news_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'title'),
            ])
            ->actions([
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Scoped query: author hanya melihat berita miliknya sendiri,
     * admin melihat semua berita.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();

        if ($user?->isAuthor()) {
            $query->where('author_id', $user->author?->id);
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }

    // Admin & Author boleh mengakses resource ini (query sudah discope di atas)
    public static function canViewAny(): bool
    {
        return auth()->check();
    }
}
