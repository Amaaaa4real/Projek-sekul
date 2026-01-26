<?php

// Namespace tabel Produk
namespace App\Filament\Resources\Produks\Tables;

// Import class utama Table
use Filament\Tables\Table;
use Filament\Support\Enums\Size;

use Filament\Actions\ActionGroup;


// Import action per record
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;

// Import bulk actions
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ForceDeleteBulkAction;

// Import kolom tabel
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

// Import filter
use Filament\Tables\Filters\TrashedFilter;

class ProduksTable
{
    /**
     * Konfigurasi tabel Produk
     */
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // Nama produk
                TextColumn::make('name')
                    ->searchable(),          // Bisa dicari

                // Foto produk (relasi photos)
                ImageColumn::make('photos.photo')
                    ->circular()             // Tampil bulat
                    ->stacked()              // Jika lebih dari satu, ditumpuk
                    ->limit(1)               // Tampilkan 1 foto saja
                    ->limitedRemainingText(), // Indikator jumlah sisa foto

                // Thumbnail utama produk
                ImageColumn::make('thumbnail')
                    ->square(),              // Bentuk kotak

                // Harga produk
                TextColumn::make('price')
                    ->money('IDR')                // Format mata uang
                    ->sortable(),

                // Ukuran produk (relasi sizes)
                TextColumn::make('sizes.size')
                    ->searchable()
                    ->sortable(),

                // Stok produk
                TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),

                // Brand produk (relasi brand)
                ImageColumn::make('brand.logo')
                    ->label('Brand')
                    ->circular()
                    ->height(40)
                    ->width(40),

                // Kategori produk (relasi category)
                TextColumn::make('category.name')
                    ->searchable(),

                // Waktu soft delete (default disembunyikan)
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Waktu dibuat
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Waktu terakhir update
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Status produk populer
                IconColumn::make('is_popular')
                    ->boolean(),              // Tampilkan ikon true / false
            ])

            // Filter data soft delete
            ->filters([
                TrashedFilter::make(),
            ])

            // Action per baris
            ->recordActions([
                ActionGroup::make([
                    // Array of actions
                    ViewAction::make(),          // Lihat detail
                    EditAction::make(),          // Edit data
                    DeleteAction::make(),        // Soft delete
                ])
                     ->dropdownPlacement('top-start')


            ])

            // Bulk actions
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),        // Soft delete massal
                    ForceDeleteBulkAction::make(),   // Hapus permanen
                    RestoreBulkAction::make(),       // Restore data
                ]),
            ]);
    }
}
