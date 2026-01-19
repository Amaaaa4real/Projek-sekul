<?php

namespace App\Filament\Resources\Produks\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class ProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nama')
                    ->required(),
                FileUpload::make('thumbnail')->image()->label('Thumbnail')
                    ->required(),
                Textarea::make('about')->label('Deskripsi')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('price')->label('Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('stock')->label('Stock')
                    ->required()
                    ->numeric(),
                Toggle::make('is_popular')
                    ->label('Produk Populer')->default(false),
                Select::make('category_id')->label('Kategori')
                    ->relationship('category', 'name')
                    ->required(),
                Select::make('brand_id')->label('Brand')
                    ->relationship('brand', 'name')
                    ->required(),
            ]);
    }
}
