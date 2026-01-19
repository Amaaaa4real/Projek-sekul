<?php

namespace App\Filament\Resources\ProductTransactions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('booking_trx_id')
                    ->required(),
                TextInput::make('city')
                    ->required(),
                TextInput::make('post_code')
                    ->required(),
                TextInput::make('proof')
                    ->required(),
                TextInput::make('shoe_size')
                    ->required()
                    ->numeric(),
                Textarea::make('address')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('sub_total_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('grand_total_amount')
                    ->required()
                    ->numeric(),
                Toggle::make('is_paid')
                    ->required(),
                Select::make('produk_id')
                    ->relationship('produk', 'name')
                    ->required(),
                Select::make('promo_code_id')
                    ->relationship('promoCode', 'id'),
            ]);
    }
}
