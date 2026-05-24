<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Infolists\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use App\Filament\Resources\OrderResource\Pages;
use Filament\Infolists\Components\Grid;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Pesanan';

    protected static ?string $navigationGroup = 'Toko';

    protected static ?int $navigationSort = 2;

    // --- Tabel Daftar Pesanan ---
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('invoice_number')
                    ->label('No. Invoice')
                    ->searchable()
                    ->weight(\Filament\Support\Enums\FontWeight::Bold)
                    ->copyable()
                    ->copyMessage('Invoice number copied!'),

                TextColumn::make('customer_name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('customer_phone')
                    ->label('Telepon')
                    ->searchable(),

                TextColumn::make('payment_method')
                    ->label('Pembayaran')
                    ->badge()
                    ->color('info'),

                TextColumn::make('total')
                    ->label('Total')
                    ->money('IDR')
                    ->sortable()
                    ->weight(\Filament\Support\Enums\FontWeight::SemiBold),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending'   => 'warning',
                        'progressed' => 'info',
                        'delivery'  => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default     => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status Pesanan')
                    ->options([
                        'pending'    => 'Pending',
                        'progressed' => 'Diproses',
                        'delivery'   => 'Dikirim',
                        'completed'  => 'Selesai',
                        'cancelled'  => 'Dibatalkan',
                    ]),

                SelectFilter::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->options([
                        'Bank Transfer - BCA' => 'Bank Transfer BCA',
                        'Bank Transfer - BNI' => 'Bank Transfer BNI',
                        'Virtual Account BCA' => 'Virtual Account BCA',
                        'QRIS'               => 'QRIS',
                        'Dana'               => 'Dana',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('updateStatus')
                    ->label('Update Status')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->form([
                        Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'pending'    => 'Pending',
                                'progressed' => 'Diproses',
                                'delivery'   => 'Dikirim',
                                'completed'  => 'Selesai',
                                'cancelled'  => 'Dibatalkan',
                            ])
                            ->required(),
                    ])
                    ->action(function (Order $record, array $data): void {
                        $record->update(['status' => $data['status']]);
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    // --- Detail Pesanan (View) ---
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Informasi Pesanan')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('invoice_number')
                                ->label('No. Invoice')
                                ->weight(\Filament\Support\Enums\FontWeight::Bold)
                                ->copyable(),

                            TextEntry::make('status')
                                ->label('Status')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'pending'    => 'warning',
                                    'progressed' => 'info',
                                    'delivery'   => 'primary',
                                    'completed'  => 'success',
                                    'cancelled'  => 'danger',
                                    default      => 'gray',
                                }),

                            TextEntry::make('created_at')
                                ->label('Tanggal Pesanan')
                                ->dateTime('d M Y, H:i'),
                        ]),
                    ]),

                Section::make('Informasi Pelanggan')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('customer_name')->label('Nama Pelanggan'),
                            TextEntry::make('customer_email')->label('Email'),
                            TextEntry::make('customer_phone')->label('Telepon'),
                            TextEntry::make('shipping_address')->label('Alamat Pengiriman'),
                        ]),
                    ]),

                Section::make('Pembayaran & Pengiriman')
                    ->icon('heroicon-o-credit-card')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('payment_method')
                                ->label('Metode Pembayaran')
                                ->badge()->color('info'),

                            TextEntry::make('shipping_method')
                                ->label('Metode Pengiriman')
                                ->badge()->color('primary'),

                            TextEntry::make('subtotal')
                                ->label('Sub Total')
                                ->money('IDR'),

                            TextEntry::make('shipping_cost')
                                ->label('Ongkos Kirim')
                                ->money('IDR'),
                        ]),

                        TextEntry::make('total')
                            ->label('Total Pembayaran')
                            ->money('IDR')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight(\Filament\Support\Enums\FontWeight::Bold)
                            ->color('success'),
                    ]),

                Section::make('Detail Produk yang Dibeli')
                    ->icon('heroicon-o-shopping-bag')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                Grid::make(4)->schema([
                                    TextEntry::make('product_name')
                                        ->label('Produk')
                                        ->weight(\Filament\Support\Enums\FontWeight::SemiBold),

                                    TextEntry::make('product_sku')
                                        ->label('SKU')
                                        ->badge()->color('gray'),

                                    TextEntry::make('price')
                                        ->label('Harga Satuan')
                                        ->money('IDR'),

                                    TextEntry::make('quantity')
                                        ->label('Jumlah')
                                        ->badge()->color('primary'),
                                ]),
                            ]),
                    ]),
            ]);
    }

    // --- Tidak ada form edit langsung (update via action) ---
    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view'  => Pages\ViewOrder::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['items']);
    }

    public static function canCreate(): bool
    {
        return false; // Pesanan dibuat oleh pelanggan, bukan admin
    }
}
