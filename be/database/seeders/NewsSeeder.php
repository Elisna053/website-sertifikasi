<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $news = [
            [
                'title' => 'LSP API Gelar Asesmen Kompetensi di Graha Kadin Kota Bandung 1',
                'slug' => 'lsp-api-gelar-asesmen-kompetensi-di-graha-kadin-kota-bandung',
                'description' => 'Lembaga Sertifikasi Profesi (LSP) API sukses melaksanakan asesmen kompetensi yang berlangsung di Graha Kadin Kota Bandung pada 28-29 November 2024. Kegiatan ini diikuti oleh sembilan peserta yang berasal dari Politeknik Negeri Pontianak dan Kadin Bandung. Asesmen ini bertujuan untuk mengukur dan memastikan kompetensi para peserta sesuai dengan standar nasional dan kebutuhan industri. Peserta diberikan berbagai tantangan praktik dan teori untuk membuktikan kemampuan mereka di bidang masing-masing. "Kegiatan ini merupakan upaya kami dalam mendukung peningkatan kualitas sumber daya manusia yang bersertifikasi, sehingga mampu bersaing di dunia kerja," ujar perwakilan dari LSP API. Kadin Bandung, sebagai tuan rumah, menyambut baik pelaksanaan asesmen ini. "Kami bangga menjadi bagian dari proses pengembangan tenaga kerja yang kompeten dan bersertifikasi, terutama bagi anggota kami dan mitra dari institusi pendidikan," kata perwakilan Kadin Bandung. Para peserta diharapkan dapat menyelesaikan asesmen ini dengan hasil yang memuaskan, sehingga dapat memperoleh sertifikasi profesi yang menjadi bukti keahlian dan kompetensi mereka. Dengan terselenggaranya kegiatan ini, LSP API kembali menegaskan komitmennya dalam mendorong peningkatan standar kompetensi nasional di berbagai sektor. Kegiatan serupa direncanakan akan terus dilaksanakan di berbagai daerah lainnya untuk menjangkau lebih banyak tenaga kerja dan pelaku industri.',
                'image_url' => null,
                'author' => 'Admin'
            ],
            [
                'title' => 'LSP API Gelar Asesmen Kompetensi di Graha Kadin Kota Bandung 2',
                'slug' => 'lsp-api-gelar-asesmen-kompetensi-di-graha-kadin-kota-bandung-2',
                'description' => 'Lembaga Sertifikasi Profesi (LSP) API sukses melaksanakan asesmen kompetensi yang berlangsung di Graha Kadin Kota Bandung pada 28-29 November 2024. Kegiatan ini diikuti oleh sembilan peserta yang berasal dari Politeknik Negeri Pontianak dan Kadin Bandung. Asesmen ini bertujuan untuk mengukur dan memastikan kompetensi para peserta sesuai dengan standar nasional dan kebutuhan industri. Peserta diberikan berbagai tantangan praktik dan teori untuk membuktikan kemampuan mereka di bidang masing-masing. "Kegiatan ini merupakan upaya kami dalam mendukung peningkatan kualitas sumber daya manusia yang bersertifikasi, sehingga mampu bersaing di dunia kerja," ujar perwakilan dari LSP API. Kadin Bandung, sebagai tuan rumah, menyambut baik pelaksanaan asesmen ini. "Kami bangga menjadi bagian dari proses pengembangan tenaga kerja yang kompeten dan bersertifikasi, terutama bagi anggota kami dan mitra dari institusi pendidikan," kata perwakilan Kadin Bandung. Para peserta diharapkan dapat menyelesaikan asesmen ini dengan hasil yang memuaskan, sehingga dapat memperoleh sertifikasi profesi yang menjadi bukti keahlian dan kompetensi mereka. Dengan terselenggaranya kegiatan ini, LSP API kembali menegaskan komitmennya dalam mendorong peningkatan standar kompetensi nasional di berbagai sektor. Kegiatan serupa direncanakan akan terus dilaksanakan di berbagai daerah lainnya untuk menjangkau lebih banyak tenaga kerja dan pelaku industri.',
                'image_url' => null,
                'author' => 'Admin'
            ],
            [
                'title' => 'LSP API Gelar Asesmen Kompetensi di Graha Kadin Kota Bandung 3',
                'slug' => 'lsp-api-gelar-asesmen-kompetensi-di-graha-kadin-kota-bandung-3',
                'description' => 'Lembaga Sertifikasi Profesi (LSP) API sukses melaksanakan asesmen kompetensi yang berlangsung di Graha Kadin Kota Bandung pada 28-29 November 2024. Kegiatan ini diikuti oleh sembilan peserta yang berasal dari Politeknik Negeri Pontianak dan Kadin Bandung. Asesmen ini bertujuan untuk mengukur dan memastikan kompetensi para peserta sesuai dengan standar nasional dan kebutuhan industri. Peserta diberikan berbagai tantangan praktik dan teori untuk membuktikan kemampuan mereka di bidang masing-masing. "Kegiatan ini merupakan upaya kami dalam mendukung peningkatan kualitas sumber daya manusia yang bersertifikasi, sehingga mampu bersaing di dunia kerja," ujar perwakilan dari LSP API. Kadin Bandung, sebagai tuan rumah, menyambut baik pelaksanaan asesmen ini. "Kami bangga menjadi bagian dari proses pengembangan tenaga kerja yang kompeten dan bersertifikasi, terutama bagi anggota kami dan mitra dari institusi pendidikan," kata perwakilan Kadin Bandung. Para peserta diharapkan dapat menyelesaikan asesmen ini dengan hasil yang memuaskan, sehingga dapat memperoleh sertifikasi profesi yang menjadi bukti keahlian dan kompetensi mereka. Dengan terselenggaranya kegiatan ini, LSP API kembali menegaskan komitmennya dalam mendorong peningkatan standar kompetensi nasional di berbagai sektor. Kegiatan serupa direncanakan akan terus dilaksanakan di berbagai daerah lainnya untuk menjangkau lebih banyak tenaga kerja dan pelaku industri.',
                'image_url' => null,
                'author' => 'Admin'
            ],
        ];

        // Insert the news data
        foreach ($news as $item) {
            News::create($item);
        }
    }
}
