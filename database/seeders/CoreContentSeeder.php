<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Booking;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CoreContentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@mesketch.test'],
            ['name' => 'Admin MeSketch', 'phone' => '0812-0000-0001', 'role' => 'admin', 'password' => Hash::make('password123')]
        );

        $writer = User::updateOrCreate(
            ['email' => 'writer@mesketch.test'],
            ['name' => 'Writer MeSketch', 'phone' => '0812-0000-0002', 'role' => 'writer', 'password' => Hash::make('password123')]
        );

        $client = User::updateOrCreate(
            ['email' => 'client@mesketch.test'],
            ['name' => 'Klien Demo', 'phone' => '0812-0000-0003', 'role' => 'user', 'password' => Hash::make('password123')]
        );

        Article::updateOrCreate(
            ['slug' => 'minimalis-vs-japandi'],
            [
                'author_id' => $writer->id,
                'title' => 'Minimalis vs Japandi: Mana yang Cocok untuk Anda?',
                'excerpt' => 'Menemukan keseimbangan antara kesederhanaan modern dan kehangatan tradisional Jepang.',
                'body' => 'Dua gaya populer ini sering kali membingungkan. Minimalis berfokus pada fungsi dan garis bersih, sementara Japandi menambahkan elemen alami dan konsep "wabi-sabi". Memahami perbedaan keduanya membantu Anda menentukan karakter hunian yang benar-benar mewakili kepribadian Anda.',
                'cover_path' => null,
                'published_at' => now()->subDays(12),
            ]
        );

        Article::updateOrCreate(
            ['slug' => 'tren-warna-bumi-2026'],
            [
                'author_id' => $admin->id,
                'title' => 'Warna-warna Bumi: Tren Interior 2026',
                'excerpt' => 'Kembali ke alam dengan palet warna terracotta, sage, dan sand yang menenangkan.',
                'body' => 'Tahun 2026 adalah tentang ketenangan. Warna-warna bumi memberikan efek grounding yang luar biasa setelah seharian beraktivitas di dunia digital yang serba cepat. Pelajari cara mengaplikasikan palet ini tanpa membuat ruangan terasa gelap atau sempit.',
                'cover_path' => null,
                'published_at' => now()->subDays(5),
            ]
        );

        Article::updateOrCreate(
            ['slug' => 'apartemen-kecil-solusi-cerdas'],
            [
                'author_id' => $writer->id,
                'title' => 'Memaksimalkan Ruang di Apartemen Kecil',
                'excerpt' => 'Trik cerdas menggunakan furnitur multifungsi dan cermin untuk menciptakan ilusi ruang.',
                'body' => 'Tinggal di apartemen studio bukan berarti harus merasa sesak. Dengan penataan yang tepat, furnitur yang bisa dilipat, dan permainan warna yang konsisten, Anda bisa memiliki ruang kerja, ruang tidur, dan area santai yang nyaman dalam satu lantai yang terbatas.',
                'cover_path' => null,
                'published_at' => now()->subDays(1),
            ]
        );

        foreach ([
            ['name' => 'Fina Ramadhani', 'role_label' => 'Klien Residential', 'message' => 'Komunikasinya jelas, prosesnya terarah, dan hasil desainnya terasa personal.', 'rating' => 5],
            ['name' => 'Rayhan Rangga', 'role_label' => 'Pemilik Rumah', 'message' => 'Rekomendasi material dan layout-nya praktis dipakai saat eksekusi di lapangan.', 'rating' => 5],
            ['name' => 'Anvy', 'role_label' => 'Klien Konsultasi', 'message' => 'Timnya membantu menerjemahkan kebutuhan ruang menjadi konsep yang rapi dan realistis.', 'rating' => 5],
            ['name' => 'Dodi Prasetyo', 'role_label' => 'CEO Start-up', 'message' => 'MeSketch membantu kami mendesain kantor yang memicu kreativitas tim kami secara luar biasa.', 'rating' => 5],
            ['name' => 'Siska Amelia', 'role_label' => 'Lifestyle Influencer', 'message' => 'Sangat suka dengan cara mereka menangani pencahayaan. Studio saya jadi punya banyak spot estetik!', 'rating' => 4],
        ] as $testimonial) {
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name']],
                [...$testimonial, 'is_featured' => true]
            );
        }

        Booking::updateOrCreate(
            ['user_id' => $client->id, 'project_name' => 'Renovasi Ruang Keluarga'],
            [
                'booking_date' => now()->addDays(7)->toDateString(),
                'phone' => '0812-0000-0003',
                'address' => 'Jakarta Selatan',
                'notes' => 'Butuh konsep ruang keluarga yang lebih lega dan terang.',
                'status' => 'pending',
            ]
        );
    }
}
