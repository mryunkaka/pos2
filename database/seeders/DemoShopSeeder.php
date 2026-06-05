<?php

namespace Database\Seeders;

use App\Models\Tenants\About;
use App\Models\Tenants\Barcode;
use App\Models\Tenants\Category;
use App\Models\Tenants\Member;
use App\Models\Tenants\PaymentMethod;
use App\Models\Tenants\Product;
use App\Models\Tenants\Setting;
use App\Models\Tenants\Stock;
use App\Models\Tenants\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DemoShopSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            $this->seedStoreProfile();
            $this->seedSettings();
            $this->seedPaymentMethods();
            $this->seedSuppliers();
            $this->seedMembers();
            $this->seedProducts();
        });
    }

    private function seedStoreProfile(): void
    {
        About::query()->updateOrCreate(
            ['id' => 1],
            [
                'shop_name' => 'Fotocopy Jaya Mandiri',
                'shop_location' => 'Jl. Pendidikan No. 12, dekat sekolah dan kantor kelurahan',
                'currency' => 'IDR',
                'business_type' => 'other',
                'other_business_type' => 'ATK, Percetakan, Sembako, dan F&B',
            ],
        );
    }

    private function seedSettings(): void
    {
        foreach ([
            'currency' => 'IDR',
            'selling_method' => 'normal',
            'minimum_stock_nofication' => '10',
            'minimum_stock_notification' => '10',
        ] as $key => $value) {
            Setting::set($key, $value);
        }
    }

    private function seedPaymentMethods(): void
    {
        $methods = [
            ['name' => 'Cash', 'is_cash' => true, 'is_debit' => false, 'is_credit' => false, 'is_wallet' => false, 'icon' => 'assets/images/payment-methods/cash.png'],
            ['name' => 'Transfer Bank', 'is_cash' => false, 'is_debit' => true, 'is_credit' => false, 'is_wallet' => false, 'icon' => 'assets/images/payment-methods/bank.png'],
            ['name' => 'QRIS', 'is_cash' => false, 'is_debit' => false, 'is_credit' => false, 'is_wallet' => true, 'icon' => 'assets/images/payment-methods/qris.png'],
            ['name' => 'Debit Card', 'is_cash' => false, 'is_debit' => true, 'is_credit' => false, 'is_wallet' => false, 'icon' => 'assets/images/payment-methods/debit.png'],
        ];

        foreach ($methods as $method) {
            PaymentMethod::withTrashed()->updateOrCreate(['name' => $method['name']], array_merge($method, ['deleted_at' => null]));
        }
    }

    private function seedSuppliers(): void
    {
        $suppliers = [
            ['name' => 'Grosir ATK Nusantara', 'phone_number' => '0812-1000-2001', 'contact_name' => 'Pak Dimas', 'email' => 'atk@example.test', 'address' => 'Pasar Pagi Blok A', 'city' => 'Jakarta', 'country' => 'Indonesia', 'postal_code' => '10110'],
            ['name' => 'Kertas & Tinta Prima', 'phone_number' => '0812-1000-2002', 'contact_name' => 'Bu Rani', 'email' => 'print@example.test', 'address' => 'Sentra Percetakan No. 8', 'city' => 'Bandung', 'country' => 'Indonesia', 'postal_code' => '40111'],
            ['name' => 'Sembako Makmur', 'phone_number' => '0812-1000-2003', 'contact_name' => 'Pak Agus', 'email' => 'sembako@example.test', 'address' => 'Gudang Sembako Raya', 'city' => 'Bekasi', 'country' => 'Indonesia', 'postal_code' => '17111'],
            ['name' => 'Distributor Minuman Segar', 'phone_number' => '0812-1000-2004', 'contact_name' => 'Bu Lina', 'email' => 'fnb@example.test', 'address' => 'Kawasan Niaga Timur', 'city' => 'Tangerang', 'country' => 'Indonesia', 'postal_code' => '15111'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::withTrashed()->updateOrCreate(['name' => $supplier['name']], array_merge($supplier, ['deleted_at' => null]));
        }
    }

    private function seedMembers(): void
    {
        $members = [
            ['name' => 'SMA Harapan Bangsa', 'identity_type' => 'NISN', 'identity_number' => 'SCH-001', 'joined_date' => now()->subMonths(8), 'code' => 'MBR-SCH-001', 'address' => 'Jl. Sekolah No. 1', 'email' => 'sma@example.test'],
            ['name' => 'Kantor Desa Sukamaju', 'identity_type' => 'NIK', 'identity_number' => 'GOV-002', 'joined_date' => now()->subMonths(5), 'code' => 'MBR-GOV-002', 'address' => 'Jl. Raya Desa No. 2', 'email' => 'desa@example.test'],
            ['name' => 'Budi Santoso', 'identity_type' => 'NIK', 'identity_number' => '317100000001', 'joined_date' => now()->subMonths(2), 'code' => 'MBR-0003', 'address' => 'Perum Melati Blok C3', 'email' => 'budi@example.test'],
            ['name' => 'Rina Fotografi', 'identity_type' => 'NIK', 'identity_number' => '317100000002', 'joined_date' => now()->subWeeks(3), 'code' => 'MBR-0004', 'address' => 'Jl. Kamera No. 4', 'email' => 'rina@example.test'],
            ['name' => 'Warung Bu Sari', 'identity_type' => 'NIK', 'identity_number' => '317100000003', 'joined_date' => now()->subWeeks(1), 'code' => 'MBR-0005', 'address' => 'Pasar Lama Kios 12', 'email' => 'sari@example.test'],
        ];

        foreach ($members as $member) {
            Member::query()->updateOrCreate(['code' => $member['code']], $member);
        }
    }

    private function seedProducts(): void
    {
        $categories = [];
        foreach (['ATK', 'Fotocopy & Print', 'Cetak Foto', 'Sablon', 'Poster & Banner', 'Jilid & Laminating', 'Sembako', 'Minuman', 'Makanan Ringan', 'Makanan Siap Saji'] as $name) {
            $categories[$name] = Category::query()->firstOrCreate(['name' => $name])->id;
        }

        $items = [
            ['ATK', 'Pulpen Standard Hitam', 'ATK-PLP-HITAM', 'pcs', 'product', 1500, 3000, 120],
            ['ATK', 'Pulpen Standard Biru', 'ATK-PLP-BIRU', 'pcs', 'product', 1500, 3000, 120],
            ['ATK', 'Pensil 2B Faber', 'ATK-PNS-2B', 'pcs', 'product', 2500, 5000, 80],
            ['ATK', 'Penghapus Putih', 'ATK-HPS-PUTIH', 'pcs', 'product', 1200, 3000, 70],
            ['ATK', 'Penggaris 30 cm', 'ATK-PGR-30', 'pcs', 'product', 2500, 6000, 45],
            ['ATK', 'Spidol Board Marker Hitam', 'ATK-SPD-BM-H', 'pcs', 'product', 5000, 10000, 35],
            ['ATK', 'Spidol Board Marker Biru', 'ATK-SPD-BM-B', 'pcs', 'product', 5000, 10000, 35],
            ['ATK', 'Stabilo Kuning', 'ATK-STB-KNG', 'pcs', 'product', 4500, 9000, 40],
            ['ATK', 'Buku Tulis 38 Lembar', 'ATK-BKT-38', 'pcs', 'product', 2500, 5000, 150],
            ['ATK', 'Buku Tulis 58 Lembar', 'ATK-BKT-58', 'pcs', 'product', 3500, 7000, 120],
            ['ATK', 'Map Kertas Buffalo', 'ATK-MAP-BUF', 'pcs', 'product', 800, 2000, 200],
            ['ATK', 'Map Plastik Kancing', 'ATK-MAP-PLS', 'pcs', 'product', 1500, 4000, 100],
            ['ATK', 'Amplop Coklat A4', 'ATK-AMP-A4', 'pcs', 'product', 1000, 2500, 100],
            ['ATK', 'Kertas HVS A4 70gsm', 'ATK-HVS-A4-70', 'rim', 'product', 43000, 55000, 30],
            ['ATK', 'Kertas HVS A4 80gsm', 'ATK-HVS-A4-80', 'rim', 'product', 49000, 62000, 25],
            ['ATK', 'Kertas HVS F4 70gsm', 'ATK-HVS-F4-70', 'rim', 'product', 47000, 60000, 25],
            ['ATK', 'Lakban Bening Besar', 'ATK-LKB-BEN', 'roll', 'product', 7000, 12000, 25],
            ['ATK', 'Double Tape 1 inch', 'ATK-DBT-1', 'roll', 'product', 5000, 10000, 30],
            ['Fotocopy & Print', 'Fotocopy Hitam Putih A4', 'PRN-FC-A4-BW', 'lembar', 'service', 150, 300, 0],
            ['Fotocopy & Print', 'Fotocopy Hitam Putih F4', 'PRN-FC-F4-BW', 'lembar', 'service', 180, 400, 0],
            ['Fotocopy & Print', 'Print Hitam Putih A4', 'PRN-A4-BW', 'lembar', 'service', 300, 800, 0],
            ['Fotocopy & Print', 'Print Warna A4', 'PRN-A4-COLOR', 'lembar', 'service', 1500, 3000, 0],
            ['Fotocopy & Print', 'Print CV 1 Lembar Warna', 'PRN-CV-WARNA', 'lembar', 'service', 2500, 5000, 0],
            ['Fotocopy & Print', 'Print Sertifikat A4 Art Carton', 'PRN-SERTIF-A4', 'lembar', 'service', 4000, 8000, 0],
            ['Jilid & Laminating', 'Jilid Mika Spiral Tipis', 'JLD-SPR-TIPIS', 'buku', 'service', 5000, 10000, 0],
            ['Jilid & Laminating', 'Jilid Mika Spiral Tebal', 'JLD-SPR-TEBAL', 'buku', 'service', 8000, 15000, 0],
            ['Jilid & Laminating', 'Jilid Lakban', 'JLD-LAKBAN', 'buku', 'service', 3000, 7000, 0],
            ['Jilid & Laminating', 'Laminating KTP', 'LAM-KTP', 'pcs', 'service', 1000, 3000, 0],
            ['Jilid & Laminating', 'Laminating A4', 'LAM-A4', 'lembar', 'service', 3000, 7000, 0],
            ['Cetak Foto', 'Cetak Foto 2x3', 'FOTO-2X3', 'lembar', 'service', 1000, 3000, 0],
            ['Cetak Foto', 'Cetak Foto 3x4', 'FOTO-3X4', 'lembar', 'service', 1200, 4000, 0],
            ['Cetak Foto', 'Cetak Foto 4x6', 'FOTO-4X6', 'lembar', 'service', 1500, 5000, 0],
            ['Cetak Foto', 'Cetak Foto 3R', 'FOTO-3R', 'lembar', 'service', 2500, 7000, 0],
            ['Cetak Foto', 'Cetak Foto 4R', 'FOTO-4R', 'lembar', 'service', 3500, 10000, 0],
            ['Cetak Foto', 'Pas Foto Paket 4x6 6 Lembar', 'FOTO-PAKET-46', 'paket', 'service', 8000, 20000, 0],
            ['Sablon', 'Sablon Kaos Satuan A4', 'SBL-KAOS-A4', 'pcs', 'service', 25000, 45000, 0],
            ['Sablon', 'Sablon Kaos Satuan A3', 'SBL-KAOS-A3', 'pcs', 'service', 35000, 60000, 0],
            ['Sablon', 'Sablon Tote Bag', 'SBL-TOTE', 'pcs', 'service', 18000, 35000, 0],
            ['Sablon', 'Sablon Mug Custom', 'SBL-MUG', 'pcs', 'service', 22000, 45000, 0],
            ['Poster & Banner', 'Cetak Poster A3 Art Paper', 'PST-A3-AP', 'lembar', 'service', 8000, 15000, 0],
            ['Poster & Banner', 'Cetak Poster A2 Art Paper', 'PST-A2-AP', 'lembar', 'service', 18000, 30000, 0],
            ['Poster & Banner', 'Cetak Stiker A3 Vinyl', 'STK-A3-VINYL', 'lembar', 'service', 12000, 25000, 0],
            ['Poster & Banner', 'Cetak Banner 1x1 Meter', 'BNR-1X1', 'meter', 'service', 12000, 25000, 0],
            ['Poster & Banner', 'Cetak Spanduk 2x1 Meter', 'BNR-2X1', 'pcs', 'service', 25000, 50000, 0],
            ['Poster & Banner', 'Cetak Spanduk 3x6 Meter', 'BNR-3X6', 'pcs', 'service', 180000, 360000, 0],
            ['Poster & Banner', 'Desain Banner Sederhana', 'DSN-BANNER', 'desain', 'service', 15000, 35000, 0],
            ['Sembako', 'Beras Premium 5 kg', 'SMB-BERAS-5KG', 'pack', 'product', 61000, 72000, 24],
            ['Sembako', 'Gula Pasir 1 kg', 'SMB-GULA-1KG', 'kg', 'product', 15000, 18000, 40],
            ['Sembako', 'Minyak Goreng 1 Liter', 'SMB-MINYAK-1L', 'botol', 'product', 16000, 20000, 36],
            ['Sembako', 'Tepung Terigu 1 kg', 'SMB-TEPUNG-1KG', 'kg', 'product', 10000, 14000, 30],
            ['Sembako', 'Telur Ayam 1 kg', 'SMB-TELUR-1KG', 'kg', 'product', 25000, 31000, 20],
            ['Sembako', 'Mie Instan Goreng', 'SMB-MIE-GORENG', 'pcs', 'product', 2600, 3500, 120],
            ['Sembako', 'Susu Kental Manis Sachet', 'SMB-SKM-SCT', 'pcs', 'product', 1200, 2000, 100],
            ['Minuman', 'Air Mineral 600 ml', 'MNM-AIR-600', 'botol', 'product', 2500, 4000, 96],
            ['Minuman', 'Air Mineral 1.5 Liter', 'MNM-AIR-1500', 'botol', 'product', 4500, 7000, 48],
            ['Minuman', 'Teh Kotak 300 ml', 'MNM-TEH-KOTAK', 'kotak', 'product', 3500, 6000, 60],
            ['Minuman', 'Kopi Susu Botol', 'MNM-KOPI-SUSU', 'botol', 'product', 7000, 12000, 40],
            ['Minuman', 'Es Teh Manis', 'FNB-ESTEH', 'gelas', 'service', 2000, 5000, 0],
            ['Minuman', 'Es Jeruk', 'FNB-ESJERUK', 'gelas', 'service', 3000, 8000, 0],
            ['Minuman', 'Kopi Hitam Panas', 'FNB-KOPI-HITAM', 'gelas', 'service', 2500, 6000, 0],
            ['Makanan Ringan', 'Keripik Singkong Pedas', 'SNK-KRP-SINGKONG', 'pcs', 'product', 5000, 9000, 45],
            ['Makanan Ringan', 'Biskuit Coklat', 'SNK-BISKUIT-COK', 'pcs', 'product', 4500, 8000, 50],
            ['Makanan Ringan', 'Roti Sobek Coklat', 'SNK-ROTI-COK', 'pcs', 'product', 6500, 10000, 25],
            ['Makanan Ringan', 'Permen Mint', 'SNK-PERMEN-MINT', 'pcs', 'product', 500, 1000, 200],
            ['Makanan Siap Saji', 'Nasi Goreng Telur', 'FNB-NASGOR-TELUR', 'porsi', 'service', 10000, 18000, 0],
            ['Makanan Siap Saji', 'Mie Goreng Telur', 'FNB-MIEGOR-TELUR', 'porsi', 'service', 9000, 16000, 0],
            ['Makanan Siap Saji', 'Paket Nasi Ayam Geprek', 'FNB-AYAM-GEPREK', 'porsi', 'service', 13000, 22000, 0],
            ['Makanan Siap Saji', 'Roti Bakar Coklat Keju', 'FNB-ROTI-BAKAR', 'porsi', 'service', 8000, 15000, 0],
        ];

        foreach ($items as $index => [$category, $name, $sku, $unit, $type, $initialPrice, $sellingPrice, $stock]) {
            $product = Product::withTrashed()->updateOrCreate(
                ['sku' => $sku],
                [
                    'category_id' => $categories[$category],
                    'name' => $name,
                    'stock' => $stock,
                    'is_non_stock' => $type === 'service',
                    'initial_price' => $initialPrice,
                    'selling_price' => $sellingPrice,
                    'unit' => $unit,
                    'type' => $type,
                    'show' => true,
                    'deleted_at' => null,
                ],
            );

            Barcode::query()->updateOrCreate(
                ['code' => '899POS'.str_pad((string) ($index + 1), 6, '0', STR_PAD_LEFT)],
                [
                    'product_id' => $product->id,
                    'type' => 'primary',
                    'description' => 'Demo barcode',
                    'is_active' => true,
                ],
            );

            if ($type === 'product') {
                Stock::query()->where('product_id', $product->id)->where('type', 'in')->delete();
                Stock::query()->create([
                    'product_id' => $product->id,
                    'is_ready' => true,
                    'stock' => $stock,
                    'init_stock' => $stock,
                    'initial_price' => $initialPrice,
                    'selling_price' => $sellingPrice,
                    'type' => 'in',
                    'date' => now(),
                ]);
            }
        }
    }
}
