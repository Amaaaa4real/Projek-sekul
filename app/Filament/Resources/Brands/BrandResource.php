<?php

namespace App\Filament\Resources\Brands;

// Import halaman-halaman yang digunakan untuk CRUD Brand
use App\Filament\Resources\Brands\Pages\CreateBrand;
use App\Filament\Resources\Brands\Pages\EditBrand;
use App\Filament\Resources\Brands\Pages\ListBrands;
use App\Filament\Resources\Brands\Pages\ViewBrand;

// Import schema untuk form dan infolist
use App\Filament\Resources\Brands\Schemas\BrandForm;
use App\Filament\Resources\Brands\Schemas\BrandInfolist;

// Import konfigurasi tabel
use App\Filament\Resources\Brands\Tables\BrandsTable;

// Import model Brand
use App\Models\Brand;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Resource Filament untuk mengelola Brand
 * Mengatur CRUD operations, form, table, dan routing untuk entity Brand
 */
class BrandResource extends Resource
{
    /**
     * Model Eloquent yang dikelola oleh resource ini
     * Menghubungkan resource dengan model Brand
     */
    protected static ?string $model = Brand::class;

    /**
     * Icon yang ditampilkan di sidebar navigasi
     * Menggunakan icon 'building-storefront' dari Heroicons
     */
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-storefront';

    /**
     * Atribut dari model yang digunakan sebagai judul record
     * Digunakan untuk menampilkan nama brand di breadcrumb dan title
     */
    protected static ?string $recordTitleAttribute = 'Brand';

    /**
     * Mendefinisikan form yang digunakan untuk create dan edit
     * 
     * @param Schema $schema - Schema builder dari Filament
     * @return Schema - Schema yang sudah dikonfigurasi dengan komponen form
     */
    public static function form(Schema $schema): Schema
    {
        // Menggunakan konfigurasi form dari class terpisah (BrandForm)
        // untuk menjaga kode tetap modular dan mudah di-maintain
        return BrandForm::configure($schema);
    }

    /**
     * Mendefinisikan infolist yang digunakan untuk view/detail record
     * 
     * @param Schema $schema - Schema builder dari Filament
     * @return Schema - Schema yang sudah dikonfigurasi dengan komponen infolist
     */
    public static function infolist(Schema $schema): Schema
    {
        // Menggunakan konfigurasi infolist dari class terpisah (BrandInfolist)
        // untuk menampilkan detail brand dalam format read-only
        return BrandInfolist::configure($schema);
    }

    /**
     * Mendefinisikan tabel yang digunakan untuk list/index page
     * 
     * @param Table $table - Table builder dari Filament
     * @return Table - Table yang sudah dikonfigurasi dengan kolom dan actions
     */
    public static function table(Table $table): Table
    {
        // Menggunakan konfigurasi table dari class terpisah (BrandsTable)
        // untuk menampilkan daftar brand dengan kolom, filter, dan actions
        return BrandsTable::configure($table);
    }

    /**
     * Mendefinisikan relationship managers yang tersedia
     * 
     * @return array - Array kosong karena belum ada relationship yang dikelola
     */
    public static function getRelations(): array
    {
        return [
            // Tempat untuk mendefinisikan RelationManager
            // Contoh: ProductsRelationManager::class,
        ];
    }

    /**
     * Mendefinisikan halaman-halaman yang tersedia dalam resource
     * Mengatur routing untuk setiap operasi CRUD
     * 
     * @return array - Array berisi mapping nama page ke route dan class page
     */
    public static function getPages(): array
    {
        return [
            'index' => ListBrands::route('/'),              // Halaman list/index di route '/'
            'create' => CreateBrand::route('/create'),       // Halaman create di route '/create'
            'view' => ViewBrand::route('/{record}'),         // Halaman view detail di route '/{record}'
            'edit' => EditBrand::route('/{record}/edit'),    // Halaman edit di route '/{record}/edit'
        ];
    }

    /**
     * Mengatur query builder untuk route model binding
     * Override method parent untuk menginclude record yang di-soft delete
     * 
     * @return Builder - Eloquent query builder dengan scope yang sudah disesuaikan
     */
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            // Menonaktifkan global scope SoftDeletingScope
            // Ini memungkinkan untuk mengakses record yang sudah di-soft delete
            // Berguna jika ingin menampilkan/restore record yang sudah dihapus
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}