<?php

namespace App\Filament\Resources\ProductTransactions\Tables;

use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\ForceDeleteBulkAction;

class ProductTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama')
                    ->searchable(),
                TextColumn::make('phone')->label('No Telp')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Alamat Email')
                    ->searchable(),
                TextColumn::make('booking_trx_id')->label('ID')
                    ->searchable(),
                TextColumn::make('city')->label('Kota')
                    ->searchable(),
                TextColumn::make('post_code')->label('Kode Pos')
                    ->searchable(),
                ImageColumn::make('proof')->label('Bukti')
                    ->searchable(),
                TextColumn::make('shoe_size')->label('Ukuran Sepatu')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('sub_total_amount')->label('Sub Total')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('grand_total_amount')->label('Grand Total')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_paid')->label('Terbayar')
                    ->boolean(),
                TextColumn::make('produk.name')->label('Nama Produk')
                    ->searchable(),
                TextColumn::make('promoCode.id')->label('Kode Promo')
                    ->searchable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
