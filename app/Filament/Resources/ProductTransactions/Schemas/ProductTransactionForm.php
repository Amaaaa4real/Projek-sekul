<?php

namespace App\Filament\Resources\ProductTransactions\Schemas;

use App\Models\Produk;
use App\Models\PromoCode;
use Filament\Schemas\Schema;
use App\Models\ProductTransaction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;

class ProductTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Customer Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('phone')
                            ->required()
                            ->numeric()
                            ->maxLength(20),

                        TextInput::make('email')
                            ->email()
                            ->required(),

                        TextInput::make('booking_trx_id')
                            ->label('Booking Transaction ID')
                            ->disabled()
                            ->dehydrated()
                            ->default(fn() => \App\Models\ProductTransaction::generateUniqueTrxId()),
                    ])
                    ->columns(2),

                Section::make('Shipping Information')
                    ->schema([
                        TextInput::make('city')
                            ->required(),

                        TextInput::make('post_code')
                            ->numeric()
                            ->required(),

                        Textarea::make('address')
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Product & Payment')
                    ->schema([
                        Select::make('produk_id')
                            ->label('Product')
                            ->relationship('produk', 'name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $produk = Produk::find($state);
                                $qty = $get('guantity') ?? 1;

                                if ($produk) {
                                    $subTotal = $produk->price * $qty;
                                    $set('sub_total_amount', $subTotal);

                                    $discount = 0;
                                    if ($get('promo_code_id')) {
                                        $promo = PromoCode::find($get('promo_code_id'));
                                        $discount = $promo?->discount_amount ?? 0;
                                    }

                                    $set('grand_total_amount', max($subTotal - $discount, 0));
                                }
                            }),

                        TextInput::make('produk_size')
                            ->label('Product Size')
                            ->numeric()
                            ->required(),

                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $produk = Produk::find($get('produk_id'));

                                if ($produk) {
                                    $subTotal = $produk->price * $state;
                                    $set('sub_total_amount', $subTotal);

                                    $discount = 0;
                                    if ($get('promo_code_id')) {
                                        $promo = PromoCode::find($get('promo_code_id'));
                                        $discount = $promo?->discount_amount ?? 0;
                                    }

                                    $set('grand_total_amount', max($subTotal - $discount, 0));
                                }
                            }),

                        Select::make('promo_code_id')
                            ->label('Promo Code')
                            ->relationship('promoCode', 'code')
                            ->nullable()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                $subTotal = $get('sub_total_amount') ?? 0;
                                $discount = 0;

                                if ($state) {
                                    $promo = PromoCode::find($state);
                                    $discount = $promo?->discount_amount ?? 0;
                                }

                                $set('grand_total_amount', max($subTotal - $discount, 0));
                            }),

                        TextInput::make('sub_total_amount')
                            ->label('Sub Total')
                            ->numeric()
                            ->prefix('IDR')
                            ->disabled()
                            ->dehydrated(),

                        TextInput::make('grand_total_amount')
                            ->label('Grand Total')
                            ->numeric()
                            ->prefix('IDR')
                            ->disabled()
                            ->dehydrated(),

                        Toggle::make('is_paid')
                            ->label('Is Paid')
                            ->reactive()
                            ->required(),

                        FileUpload::make('proof')
                            ->label('Payment Proof')
                            ->image()
                            ->directory('transactions/proofs')
                            ->maxSize(2048)
                            ->required(fn(callable $get) => $get('is_paid') === true)
                            ->visible(fn(callable $get) => $get('is_paid') === true),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
