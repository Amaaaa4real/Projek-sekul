<?php

namespace App\Filament\Resources\ProductTransactions\Schemas;

use Illuminate\Support\Str;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class ProductTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama')
                    ->required(),
                TextInput::make('phone')->label('No Telp')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required(),
                TextInput::make('booking_trx_id')
                    ->label('Booking ID')
                    ->default(fn() => 'TRX-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)))
                    ->disabled()
                    ->dehydrated()
                    ->unique(ignoreRecord: true),
                TextInput::make('city')->label('Kota')
                    ->required(),
                TextInput::make('post_code')->label('Kode Pos')
                    ->required(),
                FileUpload::make('proof')
                    ->label('Bukti Pembayaran')
                    ->image()
                    ->imagePreviewHeight(150)
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->maxSize(2048) // 2MB
                    ->required(),
                Select::make('shoe_size')
                    ->label('Ukuran Sepatu')
                    ->options([
                        38 => '38',
                        39 => '39',
                        40 => '40',
                        41 => '41',
                        42 => '42',
                        43 => '43',
                        44 => '44',
                    ])
                    ->required(),
                Textarea::make('address')->label('Alamat')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),
                // TextInput::make('sub_total_amount')
                //     ->label('Sub Total')
                //     ->numeric()
                //     ->disabled()
                //     ->dehydrated(), // ⬅️ PENTING agar tetap masuk DB
                // TextInput::make('grand_total_amount')
                //     ->label('Grand Total')
                //     ->numeric()
                //     ->disabled()
                //     ->dehydrated(),
                TextInput::make('sub_total_amount')->required()->numeric(),
                TextInput::make('grand_total_amount')->required()->numeric(),
                Toggle::make('is_paid')
                    ->label('Sudah Dibayar')
                    ->default(false),
                Select::make('produk_id')
                    ->label('Produk')
                    ->relationship('produk', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('promo_code_id')
                    ->label('Kode Promo')
                    ->relationship('promoCode', 'code')
                    ->searchable()
                    ->nullable(),
            ]);
    }
}
