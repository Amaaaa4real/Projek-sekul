<?php

namespace App\Filament\Resources\Categories\Schemas;

use Livewire\Form;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required()->maxLength(255),
                FileUpload::make('icon')->image()->directory('categories')->maxSize(1024)->required()->nullable(),
            ]);
    }
}
