<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // === Tas (Bag) Collection ===
            [
                'name' => 'Leather Crossbody Bag',
                'sku' => 'BAG-001',
                'slug' => 'leather-crossbody-bag',
                'description' => "Tas selempang kulit premium dengan jahitan tangan yang rapi dan kokoh. Dilengkapi dengan tali adjustable sehingga nyaman digunakan dalam berbagai kesempatan.\n\n**Spesifikasi:**\n- Bahan: Genuine Leather\n- Dimensi: 25 x 18 x 7 cm\n- Warna: Coklat Tua\n- Dilengkapi 3 kantong tambahan\n- Gesper kuningan anti-karat",
                'stock' => 45,
                'price' => 350000,
                'weight' => 500,
                'collection' => 'Bags',
                'cover_url' => 'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80',
                    'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?w=600&q=80',
                ],
            ],
            [
                'name' => 'Canvas Tote Bag',
                'sku' => 'BAG-002',
                'slug' => 'canvas-tote-bag',
                'description' => "Tote bag kanvas kasual dengan daya tampung besar, cocok untuk belanja, kampus, maupun kerja sehari-hari. Dibuat dari kanvas tebal berkualitas tinggi yang tahan lama.\n\n**Spesifikasi:**\n- Bahan: 100% Canvas\n- Dimensi: 38 x 42 x 12 cm\n- Warna: Cream Natural\n- Kapasitas: 15L\n- Tersedia kantong dalam",
                'stock' => 80,
                'price' => 125000,
                'weight' => 350,
                'collection' => 'Bags',
                'cover_url' => 'https://images.unsplash.com/photo-1583623025817-d180a2221d0a?w=600&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1597484661643-2f5fef640dd1?w=600&q=80',
                ],
            ],
            [
                'name' => 'Mini Backpack Premium',
                'sku' => 'BAG-003',
                'slug' => 'mini-backpack-premium',
                'description' => "Backpack mini stylish yang cocok untuk aktivitas sehari-hari, travelling, maupun hang-out. Desain compact namun tetap fungsional dengan banyak ruang penyimpanan.\n\n**Spesifikasi:**\n- Bahan: PU Leather Premium\n- Dimensi: 22 x 28 x 10 cm\n- Warna: Hitam Matte\n- Slot laptop 11 inci\n- Garansi 1 tahun",
                'stock' => 30,
                'price' => 275000,
                'weight' => 450,
                'collection' => 'Bags',
                'cover_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?w=600&q=80',
                ],
            ],
            [
                'name' => 'Classic Clutch Bag',
                'sku' => 'BAG-004',
                'slug' => 'classic-clutch-bag',
                'description' => "Clutch bag klasik elegan yang sempurna untuk acara formal, pesta, maupun makan malam. Terbuat dari bahan satin berkualitas tinggi dengan detail payet yang memukau.\n\n**Spesifikasi:**\n- Bahan: Satin Premium + Payet\n- Dimensi: 20 x 12 x 4 cm\n- Warna: Emas / Gold\n- Dilengkapi rantai panjang\n- Bisa digunakan sebagai clutch atau sling",
                'stock' => 25,
                'price' => 195000,
                'weight' => 250,
                'collection' => 'Bags',
                'cover_url' => 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=600&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1566150905458-1bf1fc113f0d?w=600&q=80',
                ],
            ],

            // === Dompet (Wallets) Collection ===
            [
                'name' => 'Slim Bifold Wallet',
                'sku' => 'WLT-001',
                'slug' => 'slim-bifold-wallet',
                'description' => "Dompet kulit slim bifold yang ramping, elegan, dan muat banyak kartu. Terbuat dari genuine leather asli dengan lapisan yang kuat dan awet.\n\n**Spesifikasi:**\n- Bahan: Genuine Leather\n- Dimensi: 11 x 9 x 1 cm\n- Kapasitas: 8 slot kartu + uang\n- Warna: Coklat Cognac\n- RFID Blocking Protection",
                'stock' => 60,
                'price' => 185000,
                'weight' => 120,
                'collection' => 'Wallets',
                'cover_url' => 'https://images.unsplash.com/photo-1627123424574-724758594e93?w=600&q=80',
                'gallery' => [
                    'https://images.unsplash.com/photo-1612810806546-0b18b0d7b0a0?w=600&q=80',
                ],
            ],
            [
                'name' => 'Long Wallet Women',
                'sku' => 'WLT-002',
                'slug' => 'long-wallet-women',
                'description' => "Dompet panjang wanita dengan banyak kompartemen untuk kartu, uang kertas, dan koin. Desain feminin yang elegan dengan warna-warna pastel yang cantik.\n\n**Spesifikasi:**\n- Bahan: PU Leather\n- Dimensi: 19 x 10 x 2 cm\n- Kapasitas: 12 slot kartu + koin\n- Warna: Pink Blush\n- Ritsleting YKK berkualitas",
                'stock' => 55,
                'price' => 155000,
                'weight' => 180,
                'collection' => 'Wallets',
                'cover_url' => 'https://images.unsplash.com/photo-1601924921557-45e6dea0a157?w=600&q=80',
                'gallery' => [],
            ],
            [
                'name' => 'Card Holder Minimalist',
                'sku' => 'WLT-003',
                'slug' => 'card-holder-minimalist',
                'description' => "Card holder super tipis untuk menyimpan kartu penting dalam desain yang sangat minimalis. Cocok untuk profesional modern yang tidak ingin dompet yang tebal di saku.\n\n**Spesifikasi:**\n- Bahan: Kulit Sintetis Premium\n- Kapasitas: 4-6 kartu\n- Dimensi: 9 x 6 x 0.5 cm\n- Warna: Hitam & Abu Abu\n- Anti Gores",
                'stock' => 90,
                'price' => 75000,
                'weight' => 50,
                'collection' => 'Wallets',
                'cover_url' => 'https://images.unsplash.com/photo-1559003876-f52b57cf95c6?w=600&q=80',
                'gallery' => [],
            ],

            // === Ikat Pinggang (Belts) Collection ===
            [
                'name' => 'Genuine Leather Belt Classic',
                'sku' => 'BLT-001',
                'slug' => 'genuine-leather-belt-classic',
                'description' => "Ikat pinggang kulit asli klasik yang cocok dipadukan dengan celana formal maupun kasual. Buckle logam berwarna perak menambah kesan mewah dan elegan.\n\n**Spesifikasi:**\n- Bahan: Full Grain Leather\n- Lebar: 3.5 cm\n- Panjang: 120 cm (adjustable)\n- Buckle: Stainless Steel Silver\n- Warna: Hitam Klasik",
                'stock' => 40,
                'price' => 225000,
                'weight' => 300,
                'collection' => 'Belts',
                'cover_url' => 'https://images.unsplash.com/photo-1624222247344-550fb60583dc?w=600&q=80',
                'gallery' => [],
            ],
            [
                'name' => 'Woven Canvas Belt',
                'sku' => 'BLT-002',
                'slug' => 'woven-canvas-belt',
                'description' => "Ikat pinggang kanvas anyaman dengan gaya sporty yang stylish. Cocok dipadukan dengan celana jeans, chino, maupun celana pendek kasual.\n\n**Spesifikasi:**\n- Bahan: Canvas Anyaman Tebal\n- Lebar: 3 cm\n- Panjang: bisa dipotong sesuai ukuran\n- Buckle: Plastik Heavy-Duty\n- Warna: Army Green",
                'stock' => 65,
                'price' => 85000,
                'weight' => 200,
                'collection' => 'Belts',
                'cover_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80',
                'gallery' => [],
            ],

            // === Aksesoris (Accessories) Collection ===
            [
                'name' => 'Wool Scarf Premium',
                'sku' => 'ACC-001',
                'slug' => 'wool-scarf-premium',
                'description' => "Syal wol lembut premium dengan motif kotak-kotak yang timeless. Bisa digunakan sebagai syal, selimut tipis, atau aksesori fashion.\n\n**Spesifikasi:**\n- Bahan: 70% Wool + 30% Cashmere\n- Dimensi: 180 x 70 cm\n- Warna: Navy Blue & Caramel\n- Motif: Plaid Classic\n- Cuci tangan atau dry clean",
                'stock' => 35,
                'price' => 320000,
                'weight' => 400,
                'collection' => 'Accessories',
                'cover_url' => 'https://images.unsplash.com/photo-1520903920243-00d872a2d1c9?w=600&q=80',
                'gallery' => [],
            ],
            [
                'name' => 'Leather Watch Strap',
                'sku' => 'ACC-002',
                'slug' => 'leather-watch-strap',
                'description' => "Tali jam tangan kulit asli dengan finishing premium yang bisa digunakan untuk hampir semua merek jam tangan. Tersedia dalam berbagai ukuran.\n\n**Spesifikasi:**\n- Bahan: Genuine Leather Italy\n- Lebar: 18mm / 20mm / 22mm\n- Warna: Coklat Vintage\n- Cepuk: Silver\n- Dijamin tidak luntur",
                'stock' => 70,
                'price' => 145000,
                'weight' => 80,
                'collection' => 'Accessories',
                'cover_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=600&q=80',
                'gallery' => [],
            ],
            [
                'name' => 'Sunglasses Retro Aviator',
                'sku' => 'ACC-003',
                'slug' => 'sunglasses-retro-aviator',
                'description' => "Kacamata hitam retro aviator dengan lensa polarized yang melindungi mata dari sinar UV. Desain timeless yang tidak pernah ketinggalan mode.\n\n**Spesifikasi:**\n- Frame: Stainless Steel\n- Lensa: Polarized UV400\n- Ukuran: Medium - Large\n- Warna Frame: Gold\n- Dilengkapi case kulit",
                'stock' => 50,
                'price' => 275000,
                'weight' => 150,
                'collection' => 'Accessories',
                'cover_url' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=600&q=80',
                'gallery' => [],
            ],
        ];

        foreach ($products as $data) {
            // Skip if already exists
            if (Product::where('sku', $data['sku'])->exists()) {
                $this->command->info("Skipping {$data['sku']} - already exists.");
                continue;
            }

            // Create the product
            $product = Product::create([
                'name' => $data['name'],
                'sku' => $data['sku'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'stock' => $data['stock'],
                'price' => $data['price'],
                'weight' => $data['weight'],
            ]);

            // Attach collection tag
            $product->attachTag($data['collection'], 'collection');

            // Add cover image from URL
            try {
                $product->addMediaFromUrl($data['cover_url'])
                    ->usingFileName($data['sku'] . '-cover.jpg')
                    ->toMediaCollection('cover');
                $this->command->info("✓ Added cover image for {$data['name']}");
            } catch (\Exception $e) {
                $this->command->warn("⚠ Could not download cover image for {$data['name']}: " . $e->getMessage());
            }

            // Add gallery images from URL
            foreach ($data['gallery'] as $index => $galleryUrl) {
                try {
                    $product->addMediaFromUrl($galleryUrl)
                        ->usingFileName($data['sku'] . '-gallery-' . ($index + 1) . '.jpg')
                        ->toMediaCollection('gallery');
                    $this->command->info("  ✓ Added gallery image " . ($index + 1) . " for {$data['name']}");
                } catch (\Exception $e) {
                    $this->command->warn("  ⚠ Could not download gallery image for {$data['name']}: " . $e->getMessage());
                }
            }

            $this->command->info("✅ Seeded: {$data['name']} ({$data['sku']})");
        }

        $this->command->newLine();
        $this->command->info('🎉 ProductSeeder selesai! ' . count($products) . ' produk telah dibuat.');
    }
}
