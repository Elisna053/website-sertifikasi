<?php
namespace App\Helpers;

use DateTime;
use Carbon\Carbon;
use App\Models\ActivityLog;
use Modules\Settings\Models\Menu;
use Illuminate\Support\Facades\Auth;

class Fungsi
{
    public static function usiaHari($tgl_lahir)
    {
        $tanggal_lahir = new DateTime($tgl_lahir);
        $hari_ini = new DateTime();
        $usia = $tanggal_lahir->diff($hari_ini);

        return "{$usia->y} tahun {$usia->m} bulan {$usia->d} hari";
    }
    public static function usiaTahun($tgl_lahir)
    {
        $tanggal_lahir = new DateTime($tgl_lahir);
        $hari_ini = new DateTime();
        $usia = $tanggal_lahir->diff($hari_ini);

        return "{$usia->y} thn";
    }

    public static function rupiah($angka)
    {
        $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
        return $hasil_rupiah;
    }

    // Fungsi untuk mendapatkan nama hari dalam seminggu
    public static function format_tgl($tgl)
    {
        $hari = Carbon::parse($tgl)->locale('id')->isoFormat('dddd');
        $tanggal = Carbon::parse($tgl)->locale('id')->isoFormat('D');
        $bulan = Carbon::parse($tgl)->locale('id')->isoFormat('MMMM');
        $tahun = Carbon::parse($tgl)->locale('id')->isoFormat('YYYY');

        return $hari . ', ' . $tanggal . ' ' . $bulan . ' ' . $tahun;
    }
    public static function format_tgl_jam_menit($tgl)
    {
        $dt = Carbon::parse($tgl)->locale('id');

        $hari = $dt->isoFormat('dddd');
        $tanggal = $dt->isoFormat('D');
        $bulan = $dt->isoFormat('MMMM');
        $tahun = $dt->isoFormat('YYYY');
        $jamMenit = $dt->format('H:i');

        return $hari . ', ' . $tanggal . ' ' . $bulan . ' ' . $tahun . ' Jam ' . $jamMenit . ' WIB';
    }

}
