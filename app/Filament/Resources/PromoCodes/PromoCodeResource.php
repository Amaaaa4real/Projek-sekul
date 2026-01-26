<?php

namespace App\Filament\Resources\PromoCodes;

// Import halaman-halaman yang dibutuhkan untuk mengelola kode promo
// Ini seperti mengimpor berbagai form: form tambah, form edit, daftar kode promo, dll
use App\Filament\Resources\PromoCodes\Pages\CreatePromoCode;
use App\Filament\Resources\PromoCodes\Pages\EditPromoCode;
use App\Filament\Resources\PromoCodes\Pages\ListPromoCodes;
use App\Filament\Resources\PromoCodes\Pages\ViewPromoCode;

// Import pengaturan form dan tampilan detail
use App\Filament\Resources\PromoCodes\Schemas\PromoCodeForm;
use App\Filament\Resources\PromoCodes\Schemas\PromoCodeInfolist;

// Import pengaturan tabel (untuk menampilkan daftar kode promo)
use App\Filament\Resources\PromoCodes\Tables\PromoCodesTable;

// Import model PromoCode (representasi tabel promo_codes di database)
use App\Models\PromoCode;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

/**
 * Resource Filament untuk mengelola Kode Promo
 * Ini seperti "pusat kontrol" untuk semua yang berhubungan dengan kode promo/kupon diskon
 * di admin panel (tambah, edit, hapus, lihat kode promo)
 */
class PromoCodeResource extends Resource
{
    /**
     * Model database yang digunakan
     * Memberitahu Filament bahwa resource ini mengelola data dari model PromoCode
     */
    protected static ?string $model = PromoCode::class;

    /**
     * Icon yang muncul di menu samping admin
     * Menggunakan icon badge persen (%) yang cocok untuk kode promo/diskon
     */
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-percent-badge';

    /**
     * Field yang digunakan sebagai judul halaman
     * ⚠️ Sebaiknya diganti ke 'code' agar menampilkan kode promonya langsung
     * Contoh: "DISKON50" atau "LEBARAN2024" bukan cuma kata "PromoCode"
     */
    protected static ?string $recordTitleAttribute = 'PromoCode';

    /**
     * Mengatur form untuk tambah dan edit kode promo
     * Seperti membuat template form isian untuk bikin kupon baru
     * 
     * @param Schema $schema - Wadah untuk form
     * @return Schema - Form yang sudah jadi
     */
    public static function form(Schema $schema): Schema
    {
        // Ambil pengaturan form dari file terpisah (PromoCodeForm)
        // Ini biar kode lebih rapi dan mudah diubah
        return PromoCodeForm::configure($schema);
    }

    /**
     * Mengatur tampilan detail kode promo (read-only)
     * Seperti halaman "lihat detail kupon" tanpa bisa edit
     * 
     * @param Schema $schema - Wadah untuk tampilan detail
     * @return Schema - Tampilan detail yang sudah jadi
     */
    public static function infolist(Schema $schema): Schema
    {
        // Ambil pengaturan tampilan detail dari file terpisah (PromoCodeInfolist)
        // Menampilkan info kode promo dalam format yang rapi dan tidak bisa diedit
        return PromoCodeInfolist::configure($schema);
    }

    /**
     * Mengatur tabel untuk menampilkan daftar kode promo
     * Seperti membuat tabel Excel yang bisa diklik, filter, cari, dll
     * 
     * @param Table $table - Wadah untuk tabel
     * @return Table - Tabel yang sudah jadi dengan kolom-kolom
     */
    public static function table(Table $table): Table
    {
        // Ambil pengaturan tabel dari file terpisah (PromoCodesTable)
        // Menampilkan daftar kode promo dengan kolom kode, diskon, status aktif, dll
        return PromoCodesTable::configure($table);
    }

    /**
     * Mengatur relasi dengan data lain
     * Misalnya untuk menampilkan daftar transaksi yang pakai kode promo ini
     * 
     * @return array - Daftar relasi (masih kosong)
     */
    public static function getRelations(): array
    {
        return [
            // Tempat untuk menambahkan relasi
            // Contoh: TransactionsRelationManager::class, (untuk lihat transaksi yang pakai promo ini)
            // Contoh: UsageHistoryRelationManager::class, (untuk lihat riwayat pemakaian)
        ];
    }

    /**
     * Mengatur halaman-halaman yang tersedia
     * Seperti daftar menu: Daftar Promo, Tambah Promo, Edit Promo, dll
     * 
     * @return array - Daftar halaman dengan URL-nya
     */
    public static function getPages(): array
    {
        return [
            'index' => ListPromoCodes::route('/'),            // Halaman daftar kode promo (URL: /)
            'create' => CreatePromoCode::route('/create'),     // Halaman tambah kode promo (URL: /create)
            'edit' => EditPromoCode::route('/{record}/edit'),  // Halaman edit kode promo (URL: /DISKON50/edit)
        ];
    }

    /**
     * Mengatur cara mengambil data kode promo dari database
     * Ini penting untuk menampilkan kode promo yang sudah dihapus (soft delete)
     * 
     * @return Builder - Query untuk mengambil data
     */
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            // Matikan filter otomatis untuk soft delete
            // Jadi kode promo yang sudah "dihapus" masih bisa dilihat dan di-restore
            // Soft delete = data tidak benar-benar hilang dari database, hanya ditandai sebagai terhapus
            // Berguna untuk audit trail (siapa hapus kupon kapan, bisa di-restore kalau perlu)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}