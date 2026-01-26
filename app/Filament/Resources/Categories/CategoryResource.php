<?php

namespace App\Filament\Resources\Categories;

// Import halaman-halaman yang digunakan untuk operasi CRUD Category
use App\Filament\Resources\Categories\Pages\CreateCategory;
use App\Filament\Resources\Categories\Pages\EditCategory;
use App\Filament\Resources\Categories\Pages\ListCategories;
use App\Filament\Resources\Categories\Pages\ViewCategory;

// Import schema untuk form dan infolist
use App\Filament\Resources\Categories\Schemas\CategoryForm;
use App\Filament\Resources\Categories\Schemas\CategoryInfolist;

// Import konfigurasi tabel
use App\Filament\Resources\Categories\Tables\CategoriesTable;

// Import model Category
use App\Models\Category;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Resource Filament untuk mengelola Category
 * Mengatur CRUD operations, form, table, dan routing untuk entity Category
 */
class CategoryResource extends Resource
{
    /**
     * Model Eloquent yang dikelola oleh resource ini
     * Menghubungkan resource dengan model Category
     */
    protected static ?string $model = Category::class;

    /**
     * Icon yang ditampilkan di sidebar navigasi
     * Menggunakan icon 'tag' dari Heroicons outline
     * Icon ini cocok untuk merepresentasikan kategori/label
     */
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-tag';

    /**
     * Atribut dari model yang digunakan sebagai judul record
     * Digunakan untuk menampilkan nama category di breadcrumb dan page title
     * ⚠️ Sebaiknya diubah ke 'name' agar menampilkan nama kategori yang sebenarnya
     */
    protected static ?string $recordTitleAttribute = 'Category';

    /**
     * Mendefinisikan form yang digunakan untuk create dan edit
     * Memanggil konfigurasi form dari class CategoryForm
     * 
     * @param Schema $schema - Schema builder dari Filament
     * @return Schema - Schema yang sudah dikonfigurasi dengan komponen form
     */
    public static function form(Schema $schema): Schema
    {
        // Menggunakan konfigurasi form dari class terpisah (CategoryForm)
        // untuk menjaga separation of concerns dan kemudahan maintenance
        return CategoryForm::configure($schema);
    }

    /**
     * Mendefinisikan infolist yang digunakan untuk view/detail record
     * Memanggil konfigurasi infolist dari class CategoryInfolist
     * 
     * @param Schema $schema - Schema builder dari Filament
     * @return Schema - Schema yang sudah dikonfigurasi dengan komponen infolist
     */
    public static function infolist(Schema $schema): Schema
    {
        // Menggunakan konfigurasi infolist dari class terpisah (CategoryInfolist)
        // untuk menampilkan detail category dalam format read-only
        return CategoryInfolist::configure($schema);
    }

    /**
     * Mendefinisikan tabel yang digunakan untuk list/index page
     * Memanggil konfigurasi table dari class CategoriesTable
     * 
     * @param Table $table - Table builder dari Filament
     * @return Table - Table yang sudah dikonfigurasi dengan kolom, filter, dan actions
     */
    public static function table(Table $table): Table
    {
        // Menggunakan konfigurasi table dari class terpisah (CategoriesTable)
        // untuk menampilkan daftar category dengan kolom, filter, dan bulk actions
        return CategoriesTable::configure($table);
    }

    /**
     * Mendefinisikan relationship managers yang tersedia
     * Digunakan untuk mengelola relasi seperti products yang ada dalam category
     * 
     * @return array - Array kosong karena belum ada relationship yang dikelola
     */
    public static function getRelations(): array
    {
        return [
            // Tempat untuk mendefinisikan RelationManager
            // Contoh: ProductsRelationManager::class,
            // untuk mengelola produk-produk dalam kategori ini
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
            'index' => ListCategories::route('/'),           // Halaman list/index di route '/'
            'create' => CreateCategory::route('/create'),     // Halaman create di route '/create'
            'edit' => EditCategory::route('/{record}/edit'),  // Halaman edit di route '/{record}/edit'
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
            // Ini memungkinkan untuk mengakses dan melihat category yang sudah di-soft delete
            // Berguna untuk fitur restore atau audit trail
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}