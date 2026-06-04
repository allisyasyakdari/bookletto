<?php

namespace Database\Seeders;

use App\Models\Promo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $samples = [
            [
                'title' => 'Gratis ongkir ke seluruh Indonesia',
                'subtitle' => 'Promo Utama — Aktif sekarang',
                'description' => 'Min. pembelian Rp 99.000. Berlaku untuk semua kurir. S&K berlaku.',
                'category' => 'Umum',
                'code' => 'FREEONGKIR',
                'discount_type' => 'fixed',
                'discount' => 0,
                'discount_amount' => 0,
                'min_purchase' => 99000,
                'expired_at' => $now->copy()->addDays(30)->endOfDay(),
            ],
            [
                'title' => 'Diskon 20% Self-help',
                'subtitle' => 'Diskon Kategori',
                'description' => 'Diskon 20% khusus kategori Self-help & Motivasi. Tidak perlu kode voucher.',
                'category' => 'Self-help',
                'code' => 'SELFHELP20',
                'discount_type' => 'percent',
                'discount' => 20,
                'discount_amount' => 0,
                'min_purchase' => 0,
                'expired_at' => $now->copy()->addDays(45)->endOfDay(),
            ],
            [
                'title' => 'Member baru: Diskon Rp 25.000',
                'subtitle' => 'Member Baru',
                'description' => 'Diskon khusus untuk akun baru pada pembelian pertama.',
                'category' => 'Member',
                'code' => 'BOOKNEW25',
                'discount_type' => 'fixed',
                'discount' => 0,
                'discount_amount' => 25000,
                'min_purchase' => 0,
                'expired_at' => $now->copy()->addDays(60)->endOfDay(),
            ],
        ];

        foreach ($samples as $promo) {
            Promo::updateOrCreate([
                'code' => $promo['code'],
            ], $promo);
        }
    }
}
