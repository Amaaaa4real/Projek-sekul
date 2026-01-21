<?php

namespace App\Filament\Resources\Produks\Schemas;

// Import class-class yang diperlukan dari Filament
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

/**
 * Class untuk mengatur form Produk
 * Berisi semua field yang dibutuhkan untuk menambah atau edit produk
 */
class ProdukForm
{
    /**
     * Mengatur tampilan form produk
     * 
     * @param Schema $schema - Wadah untuk menampung komponen form
     * @return Schema - Form yang sudah siap pakai
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Input untuk nama produk
                // - Label tampil sebagai "Nama"
                // - Wajib diisi
                TextInput::make('name')
                    ->label('Nama')
                    ->required(),
                
                // Upload gambar thumbnail produk
                // - Hanya bisa upload file gambar
                // - Label tampil sebagai "Thumbnail"
                // - Wajib diisi
                FileUpload::make('thumbnail')
                    ->image()
                    ->label('Thumbnail')
                    ->required(),
                
                // Input untuk deskripsi produk (teks panjang)
                // - Menggunakan textarea karena untuk teks yang lebih panjang
                // - Label tampil sebagai "Deskripsi"
                // - Wajib diisi
                // - Mengambil lebar penuh kolom (tidak dibagi dengan field lain)
                Textarea::make('about')
                    ->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                
                // Input untuk harga produk
                // - Label tampil sebagai "Harga"
                // - Wajib diisi
                // - Hanya bisa input angka
                // - Ada prefix "Rp" di depan angka (tampil sebagai: Rp 100000)
                TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                
                // Input untuk jumlah stok produk
                // - Label tampil sebagai "Stock"
                // - Wajib diisi
                // - Hanya bisa input angka
                TextInput::make('stock')
                    ->label('Stock')
                    ->required()
                    ->numeric(),
                
                // Toggle (tombol on/off) untuk menandai produk populer
                // - Label tampil sebagai "Produk Populer"
                // - Nilai default adalah false (off/tidak aktif)
                // - Berguna untuk menampilkan produk di bagian "Produk Populer"
                Toggle::make('is_popular')
                    ->label('Produk Populer')
                    ->default(false),
                
                // Dropdown untuk memilih kategori produk
                // - Label tampil sebagai "Kategori"
                // - Terhubung dengan tabel category melalui relasi 'category'
                // - Menampilkan field 'name' dari tabel category sebagai pilihan
                // - Wajib dipilih
                Select::make('category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->required(),
                
                // Dropdown untuk memilih brand produk
                // - Label tampil sebagai "Brand"
                // - Terhubung dengan tabel brand melalui relasi 'brand'
                // - Menampilkan field 'name' dari tabel brand sebagai pilihan
                // - Wajib dipilih
                Select::make('brand_id')
                    ->label('Brand')
                    ->relationship('brand', 'name')
                    ->required(),
            ]);
    }
}