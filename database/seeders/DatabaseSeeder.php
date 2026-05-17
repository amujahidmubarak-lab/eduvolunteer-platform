<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\LearningHome;
use App\Models\ScheduleVolunteer;
use App\Models\TeachingReport;
use App\Models\TeachingSchedule;
use App\Models\User;
use App\Models\VolunteerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin
        $admin = User::create([
            'name' => 'Admin Sosma BEM',
            'email' => 'admin@malangmengajar.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'approved',
        ]);

        // 2. Create Volunteers
        $vol1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'volunteer1@malangmengajar.com',
            'password' => Hash::make('password'),
            'role' => 'volunteer',
            'status' => 'approved',
        ]);
        VolunteerProfile::create([
            'user_id' => $vol1->id,
            'whatsapp' => '081234567891',
            'campus_major' => 'Universitas Brawijaya / Pendidikan Matematika',
            'domicile' => 'Lowokwaru, Malang',
            'interested_subjects' => 'Matematika',
            'availability' => 'Senin, Rabu, Jumat (Sore)',
            'motivation' => 'Ingin berbagi ilmu matematika kepada adik-adik di Malang agar mereka menyukai angka dan logika.',
            'ktm_photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&auto=format&fit=crop&q=80',
        ]);

        $vol2 = User::create([
            'name' => 'Siti Rahma',
            'email' => 'volunteer2@malangmengajar.com',
            'password' => Hash::make('password'),
            'role' => 'volunteer',
            'status' => 'approved',
        ]);
        VolunteerProfile::create([
            'user_id' => $vol2->id,
            'whatsapp' => '081987654322',
            'campus_major' => 'Universitas Negeri Malang / Sastra Inggris',
            'domicile' => 'Klojen, Malang',
            'interested_subjects' => 'Bahasa Inggris',
            'availability' => 'Selasa, Kamis, Sabtu (Pagi & Siang)',
            'motivation' => 'Membantu anak-anak SD mengenal bahasa Inggris sejak dini dengan metode fun learning.',
            'ktm_photo' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=400&auto=format&fit=crop&q=80',
        ]);

        $vol3 = User::create([
            'name' => 'Ahmad Faizal',
            'email' => 'volunteer3@malangmengajar.com',
            'password' => Hash::make('password'),
            'role' => 'volunteer',
            'status' => 'pending',
        ]);
        VolunteerProfile::create([
            'user_id' => $vol3->id,
            'whatsapp' => '081555666778',
            'campus_major' => 'Politeknik Negeri Malang / Teknik Informatika',
            'domicile' => 'Blimbing, Malang',
            'interested_subjects' => 'Matematika & Bahasa Inggris',
            'availability' => 'Sabtu & Minggu (Pagi)',
            'motivation' => 'Mengisi waktu luang akhir pekan dengan kegiatan sosial yang bermanfaat bagi pendidikan dasar.',
            'ktm_photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&auto=format&fit=crop&q=80',
        ]);

        $vol4 = User::create([
            'name' => 'Rina Melati',
            'email' => 'volunteer4@malangmengajar.com',
            'password' => Hash::make('password'),
            'role' => 'volunteer',
            'status' => 'approved',
        ]);
        VolunteerProfile::create([
            'user_id' => $vol4->id,
            'whatsapp' => '082233445566',
            'campus_major' => 'Universitas Muhammadiyah Malang / PGSD',
            'domicile' => 'Dau, Kabupaten Malang',
            'interested_subjects' => 'Matematika & Bahasa Inggris',
            'availability' => 'Senin - Kamis (Sore)',
            'motivation' => 'Mempraktikkan ilmu pedagogik dan berkontribusi langsung pada kemajuan literasi dan numerasi anak-anak.',
            'ktm_photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=400&auto=format&fit=crop&q=80',
        ]);

        // 3. Create Learning Homes
        $home1 = LearningHome::create([
            'name' => 'Rumah Belajar Merjosari',
            'address' => 'Jl. Joyo Utomo No. 12, Kelurahan Merjosari, Kec. Lowokwaru, Kota Malang',
            'pic_name' => 'Pak RT Harun',
            'contact_number' => '081234567001',
            'student_count' => 28,
        ]);

        $home2 = LearningHome::create([
            'name' => 'Rumah Belajar Kedungkandang',
            'address' => 'Jl. Ki Ageng Gribig No. 45, Kelurahan Madyopuro, Kec. Kedungkandang, Kota Malang',
            'pic_name' => 'Bu Ningsih',
            'contact_number' => '081987654002',
            'student_count' => 35,
        ]);

        $home3 = LearningHome::create([
            'name' => 'Rumah Belajar Sukun',
            'address' => 'Jl. S. Supriadi No. 88, Kelurahan Sukun, Kec. Sukun, Kota Malang',
            'pic_name' => 'Pak Darmawan',
            'contact_number' => '081555666003',
            'student_count' => 22,
        ]);

        // 4. Create Teaching Schedules
        // Completed Schedule 1
        $sched1 = TeachingSchedule::create([
            'learning_home_id' => $home1->id,
            'subject' => 'Matematika',
            'schedule_date' => now()->subDays(5)->format('Y-m-d'),
            'start_time' => '15:00',
            'end_time' => '17:00',
            'status' => 'completed',
            'notes' => 'Fokus materi operasi hitung campuran (penjumlahan, pengurangan, perkalian) untuk kelas 3 dan 4 SD.',
        ]);
        ScheduleVolunteer::create(['teaching_schedule_id' => $sched1->id, 'user_id' => $vol1->id, 'attendance_status' => 'present']);
        ScheduleVolunteer::create(['teaching_schedule_id' => $sched1->id, 'user_id' => $vol4->id, 'attendance_status' => 'present']);
        TeachingReport::create([
            'teaching_schedule_id' => $sched1->id,
            'user_id' => $vol1->id,
            'material_taught' => 'Operasi hitung campuran dasar dan latihan soal cerita matematika.',
            'student_count' => 25,
            'obstacles' => 'Beberapa siswa masih bingung membedakan prioritas perkalian dibandingkan penjumlahan.',
            'evaluation' => 'Perlu diperbanyak alat peraga atau games interaktif agar konsep perkalian lebih mudah dipahami.',
            'photo_path' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80',
        ]);

        // Completed Schedule 2
        $sched2 = TeachingSchedule::create([
            'learning_home_id' => $home2->id,
            'subject' => 'Bahasa Inggris',
            'schedule_date' => now()->subDays(3)->format('Y-m-d'),
            'start_time' => '14:00',
            'end_time' => '16:00',
            'status' => 'completed',
            'notes' => 'Materi pengenalan kosakata benda di sekitar rumah dan sekolah (Things around us).',
        ]);
        ScheduleVolunteer::create(['teaching_schedule_id' => $sched2->id, 'user_id' => $vol2->id, 'attendance_status' => 'present']);
        TeachingReport::create([
            'teaching_schedule_id' => $sched2->id,
            'user_id' => $vol2->id,
            'material_taught' => 'Vocabulary: Things in the classroom & Parts of the house beserta spelling dasar.',
            'student_count' => 30,
            'obstacles' => 'Suasana kelas agak ramai di awal karena antusiasme siswa yang tinggi.',
            'evaluation' => 'Metode flashcard sangat efektif, siswa menjadi lebih cepat menghafal kata baru.',
            'photo_path' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&auto=format&fit=crop&q=80',
        ]);

        // Upcoming Schedule 1
        $sched3 = TeachingSchedule::create([
            'learning_home_id' => $home1->id,
            'subject' => 'Matematika',
            'schedule_date' => now()->addDays(2)->format('Y-m-d'),
            'start_time' => '15:00',
            'end_time' => '17:00',
            'status' => 'scheduled',
            'notes' => 'Lanjutan materi pecahan sederhana dan pengenalan konsep pembagian.',
        ]);
        ScheduleVolunteer::create(['teaching_schedule_id' => $sched3->id, 'user_id' => $vol1->id, 'attendance_status' => null]);
        ScheduleVolunteer::create(['teaching_schedule_id' => $sched3->id, 'user_id' => $vol4->id, 'attendance_status' => null]);

        // Upcoming Schedule 2
        $sched4 = TeachingSchedule::create([
            'learning_home_id' => $home3->id,
            'subject' => 'Bahasa Inggris',
            'schedule_date' => now()->addDays(4)->format('Y-m-d'),
            'start_time' => '15:30',
            'end_time' => '17:00',
            'status' => 'scheduled',
            'notes' => 'Daily conversation dasar: Greetings, Introduction, dan Asking how are you.',
        ]);
        ScheduleVolunteer::create(['teaching_schedule_id' => $sched4->id, 'user_id' => $vol2->id, 'attendance_status' => null]);

        // 5. Create Announcements
        Announcement::create([
            'title' => 'Open Recruitment Volunteer Batch 5 Telah Dibuka!',
            'content' => 'Halo sobat pengabdi! Malang Mengajar kembali membuka kesempatan bagi mahasiswa se-Malang Raya untuk bergabung menjadi pengajar sukarela periode ajaran baru. Mari berkontribusi nyata bagi literasi dan numerasi anak-anak di rumah belajar binaan kami.',
            'is_active' => true,
        ]);

        Announcement::create([
            'title' => 'Panduan Kurikulum Pengajaran Matematika & Bahasa Inggris SD',
            'content' => 'Bagi seluruh volunteer aktif, modul panduan mengajar edisi terbaru telah diunggah oleh tim Kurikulum Sosma. Silakan sesuaikan materi ajar di setiap pertemuan dengan panduan silabus agar capaian belajar siswa tetap terukur dan konsisten.',
            'is_active' => true,
        ]);

        Announcement::create([
            'title' => 'Jadwal Briefing & Upgrading Relawan Mengajar',
            'content' => 'Diberitahukan kepada seluruh volunteer terverifikasi untuk menghadiri sesi Upgrading & Micro-teaching yang akan diselenggarakan pada akhir pekan ini di Gedung Student Center. Kehadiran bersifat wajib untuk koordinasi pembagian rumah belajar.',
            'is_active' => true,
        ]);

        // 6. Create Galleries
        Gallery::create([
            'title' => 'Kegiatan Belajar Matematika Seru di RB Merjosari',
            'image_path' => 'https://images.unsplash.com/photo-1577896851231-70ef18881754?w=600&auto=format&fit=crop&q=80',
            'description' => 'Antusiasme adik-adik Rumah Belajar Merjosari saat memecahkan games teka-teki perkalian bersama Kak Budi.',
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Flashcard Fun Learning Bahasa Inggris',
            'image_path' => 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=600&auto=format&fit=crop&q=80',
            'description' => 'Mengenal kosakata bahasa Inggris melalui media flashcard bergambar di Rumah Belajar Kedungkandang.',
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Membaca Bersama di Sudut Baca RB Sukun',
            'image_path' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=600&auto=format&fit=crop&q=80',
            'description' => 'Meningkatkan minat baca dan literasi cerita pendek berbahasa Inggris bersama relawan pengajar.',
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Diskusi Kelompok Kecil dan Pendampingan PR',
            'image_path' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=600&auto=format&fit=crop&q=80',
            'description' => 'Pendampingan intensif mengerjakan pekerjaan rumah (PR) sekolah dasar agar siswa lebih percaya diri.',
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Belajar Luar Ruangan (Outdoor Learning)',
            'image_path' => 'https://images.unsplash.com/photo-1511556532299-8f662fc26c06?w=600&auto=format&fit=crop&q=80',
            'description' => 'Suasana belajar santai di halaman rumah belajar untuk memicu kreativitas dan keaktifan anak-anak.',
            'is_active' => true,
        ]);

        Gallery::create([
            'title' => 'Pemberian Reward & Apresiasi Siswa Aktif',
            'image_path' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=600&auto=format&fit=crop&q=80',
            'description' => 'Apresiasi berupa buku tulis dan alat tulis bagi siswa dengan perkembangan belajar terbaik bulan ini.',
            'is_active' => true,
        ]);
    }
}
