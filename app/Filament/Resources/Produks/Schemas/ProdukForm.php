<?php

// Namespace schema form Produk
namespace App\Filament\Resources\Produks\Schemas;

// Import Schema utama Filament
use Filament\Schemas\Schema;

// Import komponen form
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

// Import Grid untuk layout
use Filament\Schemas\Components\Grid;

class ProdukForm
{
    /**
     * Konfigurasi form Produk
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                /**
                 * =========================
                 * TOP SECTION (2 kolom)
                 * =========================
                 */
                Grid::make(2)->schema([

                    /**
                     * LEFT COLUMN
                     */
                    Grid::make(1)->schema([

                        // Input nama produk
                        TextInput::make('name')
                            ->label('Name')
                            ->required(),

                        // Upload thumbnail utama produk
                        FileUpload::make('thumbnail')
                            ->label('Thumbnail')
                            ->image()                            // Hanya gambar
                            ->directory('products/thumbnails')  // Folder penyimpanan
                            ->required(),

                        // Repeater untuk ukuran produk (relasi sizes)
                        Repeater::make('sizes')
                            ->relationship()     // Menggunakan relasi Eloquent
                            ->schema([

                                // Input ukuran produk
                                TextInput::make('size')
                                    ->label('Size')
                                    ->required(),
                            ])
                            ->addActionLabel('Add to sizes') // Label tombol tambah
                            ->columnSpanFull(),              // Lebar penuh
                    ]),

                    /**
                     * RIGHT COLUMN
                     */
                    Grid::make(1)->schema([

                        // Input harga produk
                        TextInput::make('price')
                            ->label('Price')
                            ->prefix('Rp')     // Prefix mata uang
                            ->numeric()        // Hanya angka
                            ->required(),

                        // Repeater untuk foto produk (relasi photos)
                        Repeater::make('photos')
                            ->relationship()
                            ->schema([

                                // Upload foto produk
                                FileUpload::make('photo')
                                    ->image()
                                    ->directory('Produk-photos')
                                    ->required(),
                            ])
                            ->addActionLabel('Add to photos'),
                    ]),
                ]),

                /**
                 * =========================
                 * BOTTOM SECTION
                 * =========================
                 */
                Grid::make(2)->schema([

                    // Deskripsi / penjelasan produk
                    Textarea::make('about')
                        ->label('About')
                        ->rows(4),

                    // Penanda apakah produk populer
                    Select::make('is_popular')
                        ->label('Is popular')
                        ->options([
                            true => 'Yes',
                            false => 'No',
                        ]),
                ]),

                /**
                 * =========================
                 * RELATION SECTION
                 * =========================
                 */
                Grid::make(2)->schema([

                    // Relasi ke kategori
                    Select::make('category_id')
                        ->label('Category')
                        ->relationship('category', 'name')
                        ->required(),

                    // Relasi ke brand
                    Select::make('brand_id')
                        ->label('Brand')
                        ->relationship('brand', 'name')
                        ->required(),
                ]),

                /**
                 * =========================
                 * STOCK
                 * =========================
                 */
                TextInput::make('stock')
                    ->label('Stock')
                    ->numeric()     // Hanya angka
                    ->suffix('pcs'), // Satuan
            ]);
    }
}