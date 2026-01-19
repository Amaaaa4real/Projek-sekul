<?php

namespace App\Filament\Resources\PromoCodes\Schemas;

use App\Models\PromoCode;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PromoCodeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code'),
                TextEntry::make('discount_amount')
                    ->numeric(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (PromoCode $record): bool => $record->trashed()),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
