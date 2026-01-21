<?php

namespace App\Filament\Resources\PromoCodes\Schemas;

// Import komponen yang dibutuhkan dari Filament
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

/**
 * Class untuk mengatur form Kode Promo
 * Berisi field-field yang dibutuhkan untuk membuat atau edit kode promo/kupon diskon
 */
class PromoCodeForm
{
    /**
     * Mengatur tampilan form kode promo
     * 
     * @param Schema $schema - Wadah untuk menampung komponen form
     * @return Schema - Form yang sudah siap pakai
     */
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Input untuk kode promo
                // - Tempat menulis kode kupon, misalnya: "DISKON50" atau "HEMAT2024"
                // - Wajib diisi
                // - Tidak ada label, jadi akan tampil default sebagai "Code"
                TextInput::make('code')
                    ->required(),
                
                // Input untuk jumlah diskon
                // - Tempat menulis berapa besar diskonnya
                // - Wajib diisi
                // - Hanya bisa input angka (tidak bisa huruf)
                // - Tidak ada label, jadi akan tampil default sebagai "Discount Amount"
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric(),
            ]);
    }
}