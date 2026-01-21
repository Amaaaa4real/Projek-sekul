<?php

namespace App\Filament\Resources\Produks;

// Import halaman-halaman yang dibutuhkan untuk mengelola produk
// Ini seperti mengimpor form-form yang berbeda: form tambah, form edit, daftar produk, dll
use App\Filament\Resources\Produks\Pages\CreateProduk;
use App\Filament\Resources\Produks\Pages\EditProduk;
use App\Filament\Resources\Produks\Pages\ListProduks;
use App\Filament\Resources\Produks\Pages\ViewProduk;

// Import pengaturan form dan tampilan detail
use App\Filament\Resources\Produks\Schemas\ProdukForm;
use App\Filament\Resources\Produks\Schemas\ProdukInfolist;

// Import pengaturan tabel (untuk menampilkan daftar produk)
use App\Filament\Resources\Produks\Tables\ProduksTable;

// Import model Produk (representasi tabel produk di database)
use App\Models\Produk;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Resource Filament untuk mengelola Produk
 * Ini seperti "pusat kontrol" untuk semua yang berhubungan dengan produk
 * di admin panel (tambah, edit, hapus, lihat produk)
 */
class ProdukResource extends Resource
{
    /**
     * Model database yang digunakan
     * Memberitahu Filament bahwa resource ini mengelola data dari model Produk
     */
    protected static ?string $model = Produk::class;

    /**
     * Icon yang muncul di menu samping
     * Menggunakan icon tas belanja (shopping bag) yang cocok untuk produk
     */
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    /**
     * Field yang digunakan sebagai judul halaman
     * ⚠️ Sebaiknya diganti ke 'name' agar menampilkan nama produk yang sebenarnya
     * Contoh: "iPhone 14" bukan cuma kata "Produk"
     */
    protected static ?string $recordTitleAttribute = 'Produk';

    /**
     * Mengatur form untuk tambah dan edit produk
     * Seperti membuat template form isian
     * 
     * @param Schema $schema - Wadah untuk form
     * @return Schema - Form yang sudah jadi
     */
    public static function form(Schema $schema): Schema
    {
        // Ambil pengaturan form dari file terpisah (ProdukForm)
        // Ini biar kode lebih rapi dan mudah diubah
        return ProdukForm::configure($schema);
    }

    /**
     * Mengatur tampilan detail produk (read-only)
     * Seperti halaman "lihat detail" tanpa bisa edit
     * 
     * @param Schema $schema - Wadah untuk tampilan detail
     * @return Schema - Tampilan detail yang sudah jadi
     */
    public static function infolist(Schema $schema): Schema
    {
        // Ambil pengaturan tampilan detail dari file terpisah (ProdukInfolist)
        // Menampilkan info produk dalam format yang rapi dan tidak bisa diedit
        return ProdukInfolist::configure($schema);
    }

    /**
     * Mengatur tabel untuk menampilkan daftar produk
     * Seperti membuat tabel Excel yang bisa diklik, filter, dll
     * 
     * @param Table $table - Wadah untuk tabel
     * @return Table - Tabel yang sudah jadi dengan kolom-kolom
     */
    public static function table(Table $table): Table
    {
        // Ambil pengaturan tabel dari file terpisah (ProduksTable)
        // Menampilkan daftar produk dengan kolom nama, harga, stock, dll
        return ProduksTable::configure($table);
    }

    /**
     * Mengatur relasi dengan data lain
     * Misalnya bisa untuk menampilkan daftar foto produk, review, dll
     * 
     * @return array - Daftar relasi (masih kosong)
     */
    public static function getRelations(): array
    {
        return [
            // Tempat untuk menambahkan relasi
            // Contoh: PhotosRelationManager::class, (untuk kelola foto produk)
            // Contoh: ReviewsRelationManager::class, (untuk kelola review produk)
        ];
    }

    /**
     * Mengatur halaman-halaman yang tersedia
     * Seperti daftar menu: Daftar Produk, Tambah Produk, Edit Produk, dll
     * 
     * @return array - Daftar halaman dengan URL-nya
     */
    public static function getPages(): array
    {
        return [
            'index' => ListProduks::route('/'),              // Halaman daftar produk (URL: /)
            'create' => CreateProduk::route('/create'),       // Halaman tambah produk (URL: /create)
            'view' => ViewProduk::route('/{record}'),         // Halaman lihat detail (URL: /123)
            'edit' => EditProduk::route('/{record}/edit'),    // Halaman edit produk (URL: /123/edit)
        ];
    }

    /**
     * Mengatur cara mengambil data produk dari database
     * Ini penting untuk menampilkan produk yang sudah dihapus (soft delete)
     * 
     * @return Builder - Query untuk mengambil data
     */
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            // Matikan filter otomatis untuk soft delete
            // Jadi produk yang sudah "dihapus" masih bisa dilihat dan di-restore
            // Soft delete = data tidak benar-benar hilang, hanya ditandai sebagai terhapus
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}