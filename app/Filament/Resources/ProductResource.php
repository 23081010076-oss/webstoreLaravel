<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieTagsInput;
use App\Filament\Resources\ProductResource\Pages;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Produk';

    protected static ?string $navigationGroup = 'Toko';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Kolom Kiri - Informasi Utama
                Group::make()->schema([
                    Section::make('Informasi Produk')
                        ->description('Detail dasar produk yang dijual di toko.')
                        ->icon('heroicon-o-information-circle')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Produk')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) =>
                                    $operation === 'create'
                                        ? $set('slug', \Illuminate\Support\Str::slug($state))
                                        : null
                                ),

                            Grid::make(2)->schema([
                                TextInput::make('sku')
                                    ->label('SKU')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Kode unik produk, contoh: BAG-001'),

                                TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Otomatis terisi saat mengetik nama produk'),
                            ]),

                            SpatieTagsInput::make('tags')
                                ->type('collection')
                                ->label('Koleksi / Kategori')
                                ->helperText('Tambahkan kategori produk, contoh: Bags, Wallets'),

                            MarkdownEditor::make('description')
                                ->label('Deskripsi Produk')
                                ->fileAttachmentsDirectory('product-attachments')
                                ->columnSpanFull(),
                        ]),

                    Section::make('Stok, Harga & Berat')
                        ->description('Atur harga, stok, dan berat produk.')
                        ->icon('heroicon-o-currency-dollar')
                        ->schema([
                            Grid::make(3)->schema([
                                TextInput::make('price')
                                    ->label('Harga Jual')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->minValue(0),

                                TextInput::make('stock')
                                    ->label('Stok')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0),

                                TextInput::make('weight')
                                    ->label('Berat')
                                    ->required()
                                    ->numeric()
                                    ->suffix('gram')
                                    ->minValue(0),
                            ]),
                        ]),
                ])->columnSpan(['lg' => 2]),

                // Kolom Kanan - Media
                Group::make()->schema([
                    Section::make('Foto Cover')
                        ->description('Foto utama produk yang ditampilkan di katalog.')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('cover')
                                ->label('')
                                ->collection('cover')
                                ->image()
                                ->imagePreviewHeight('200')
                                ->imageEditor()
                                ->helperText('Disarankan rasio 1:1 (Square)'),
                        ]),

                    Section::make('Galeri Foto')
                        ->description('Foto tambahan produk (opsional).')
                        ->icon('heroicon-o-rectangle-group')
                        ->schema([
                            SpatieMediaLibraryFileUpload::make('gallery')
                                ->label('')
                                ->collection('gallery')
                                ->multiple()
                                ->image()
                                ->reorderable()
                                ->imageEditor()
                                ->helperText('Upload hingga 8 foto tambahan'),
                        ])
                        ->collapsible(),
                ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->label('Foto')
                    ->collection('cover')
                    ->conversion('cover')
                    ->square()
                    ->width(60)
                    ->height(60),

                TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('tags.name')
                    ->label('Koleksi')
                    ->badge()
                    ->color('info')
                    ->separator(','),

                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                TextColumn::make('stock')
                    ->label('Stok')
                    ->sortable()
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state === 0 => 'danger',
                        $state <= 10 => 'warning',
                        default => 'success',
                    }),

                TextColumn::make('weight')
                    ->label('Berat')
                    ->suffix(' gr')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('collection')
                    ->label('Koleksi')
                    ->relationship('tags', 'name', fn (Builder $query) => $query->where('type', 'collection')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['media', 'tags']);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
