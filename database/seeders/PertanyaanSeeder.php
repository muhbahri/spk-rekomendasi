<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pertanyaan;
use App\Models\JawabanUser;
use App\Models\Kriteria;

class PertanyaanSeeder extends Seeder
{
    public function run()
    {

        JawabanUser::query()->delete();
        Pertanyaan::query()->delete();



        $data = [
            'Gaji' => [
                "Seberapa penting bagi Anda bahwa gaji negara tujuan minimal setara atau lebih tinggi dibanding gaji di Indonesia?",
                "Seberapa besar Anda bersedia menunda keberangkatan jika tahu gaji di negara tujuan lebih tinggi daripada yang ditawarkan saat ini?",
                "Seberapa kuat preferensi Anda untuk memilih pekerjaan dengan gaji yang stabil (tetap setiap bulan), meski fasilitas/ tunjangan lain mungkin lebih sedikit?"
            ],
            'Biaya Hidup' => [
                "Seberapa penting Anda mengetahui estimasi total biaya hidup (makan, kontrakan/kost, transportasi) di negara tujuan sebelum memutuskan berangkat?",
                "Seberapa nyaman Anda dengan fakta bahwa biaya hidup di negara tujuan bisa lebih tinggi daripada di Indonesia, jika gaji juga lebih tinggi?",
                "Seberapa kuat keinginan Anda untuk tinggal di negara dengan biaya hidup relatif rendah (meski gaji sedikit lebih kecil) daripada tinggal di negara dengan biaya hidup sangat tinggi?"
            ],
            'Budaya' => [
                "Seberapa besar Anda merasa nyaman bekerja di negara dengan budaya masyarakat yang mirip dengan budaya Indonesia (misalnya adanya komunitas Muslim, kearifan lokal yang ramah tamah)?",
                "Seberapa mampu Anda menyesuaikan diri dengan kebiasaan lokal (misalnya jam kerja, ritual harian, etika sosial) meski berbeda dengan Indonesia?",
                "Seberapa penting dukungan komunitas (seperti masjid, fasilitas halal, kelompok diaspora) dalam membantu Anda beradaptasi secara budaya?"
            ],
            'Bahasa' => [
                "Seberapa percaya diri Anda jika harus bekerja di negara yang menggunakan bahasa Inggris/ Melayu sebagai bahasa utama (mudah bagi Anda)?",
                "Seberapa bersedia Anda mengikuti kursus bahasa intensif (misalnya Mandarin, Jepang, atau Korea) sebelum berangkat?",
                "Seberapa penting kemampuan berkomunikasi dasar (misalnya menanyakan arah, instruksi kerja) dalam bahasa setempat untuk kenyamanan Anda sehari-hari?"
            ],
            'Keamanan' => [
                "Seberapa penting bagi Anda bahwa negara tujuan memiliki tingkat kriminalitas yang sangat rendah?",
                "Seberapa besar kepercayaan Anda terhadap perlindungan hukum formal (misalnya kontrak kerja yang kuat, kemudahan akses pengaduan) di negara tujuan?",
                "Seberapa nyaman Anda bekerja di negara dengan kebijakan pemerintah dan lembaga lokal yang aktif melindungi hak pekerja migran?"
            ],
            'Proses Migrasi' => [
                "Seberapa penting bagi Anda bahwa proses perizinan (visa, dokumen kontrak) di negara tujuan mudah dan cepat?",
                "Seberapa bersedia Anda mengikuti pelatihan pra-keberangkatan (bahasa, keahlian) yang durasinya cukup lama (misalnya 3–6 bulan) demi jaminan kontrak kerja resmi?",
                "Seberapa penting bagi Anda bahwa biaya penempatan (agen, visa, pelatihan) minimal sesuai ketentuan BP2MI (tidak ada biaya tersembunyi)?"
            ],
        ];

        foreach ($data as $namaKriteria => $pertanyaans) {
            $kriteria = Kriteria::where('nama', $namaKriteria)->first();
            if (!$kriteria) continue;

            foreach ($pertanyaans as $index => $text) {
                Pertanyaan::create([
                    'kriteria_id' => $kriteria->id,
                    'pertanyaan' => $text,
                    'urutan' => $index + 1
                ]);
            }
        }
    }
}