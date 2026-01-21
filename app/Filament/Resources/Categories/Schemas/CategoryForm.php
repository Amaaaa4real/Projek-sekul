<?php

namespace App\Filament\Resources\Categories\Schemas;

// Import Livewire\Form - tidak digunakan, sebaiknya dihapus
use Livewire\Form;

// Import class yang diperlukan dari Filament
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

/**
 * Class untuk mengkonfigurasi form Category
 * Mendefinisikan field-field yang digunakan untuk create dan edit category
 */
class CategoryForm
{
    /**
     * Mengkonfigurasi schema form untuk Category
     * 
     * @param Schema $schema - Instance schema yang akan dikonfigurasi
     * @return Schema - Schema yang sudah dikonfigurasi dengan komponen form
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Input text untuk nama category
                // - Field ini wajib diisi (required)
                // - Maksimal panjang karakter adalah 255
                // - Tidak ada label() yang didefinisikan, akan menggunakan default dari field name
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                
                // Upload file untuk icon category
                // - Hanya menerima file gambar (image)
                // - File akan disimpan di direktori 'categories'
                // - Ukuran maksimal file 1024 KB (1 MB)
                // - ⚠️ Konflik: menggunakan required() dan nullable() bersamaan
                FileUpload::make('icon')
                    ->image()
                    ->directory('categories')
                    ->maxSize(1024)
                    ->required()
                    ->nullable(), // ⚠️ Perhatian: required() dan nullable() kontradiktif
            ]);
    }
}