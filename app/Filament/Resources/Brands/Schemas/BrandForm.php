<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class BrandForm
{
    /**
     * Mengkonfigurasi schema form untuk Brand
     * 
     * @param Schema $schema - Instance schema yang akan dikonfigurasi
     * @return Schema - Schema yang sudah dikonfigurasi dengan komponen form
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Input text untuk nama brand
                // - Label ditampilkan sebagai "Brand name"
                // - Field ini wajib diisi (required)
                // - Maksimal panjang karakter adalah 255
                TextInput::make('name')
                    ->label('Brand name')
                    ->required()
                    ->maxLength(255),
                
                // Upload file untuk logo brand
                // - Hanya menerima file gambar (image)
                // - File akan disimpan di direktori 'categories'
                // - Ukuran maksimal file 1024 KB (1 MB)
                // - Field ini required tapi juga nullable (kontradiktif, sebaiknya pilih salah satu)
                FileUpload::make('logo')
                    ->image()
                    ->directory('categories')
                    ->maxSize(1024)
                    ->required()
                    ->nullable(), // ⚠️ Perhatian: required() dan nullable() bersamaan dapat menyebabkan konflik
            ]);
    }
}