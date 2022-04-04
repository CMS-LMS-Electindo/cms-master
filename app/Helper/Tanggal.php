<?php

namespace App\Helpers;

use App\Models\MataKuliah;

/**
 * Format response.
 */
class Tanggal
{
    public static function TanggalIndo($date = null)
    {
        $bulan = array(
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $date);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }
    public static function TanggalDB($date = null)
    {
        $exp = explode("-",$date);
        $tgl = $exp[0]; $bln = $exp[1];$thn = $exp[2];
        $tanggal = $thn."-".$bln."-".$tgl;
        return $tanggal;
    }
    public static function getTahun($date = null)
    {
        $exp = explode("-",$date);
        $thn = '2000';
        for ($i=0; $i < count($exp); $i++) { 
            if (strlen($exp[$i]) == 4){
                $thn = $exp[$i];
                break;
            }
        }
        return $thn;
    }
    public static function getHari($date = null)
    {
        $daftar_hari = array(
            'Sunday' => 'Ahad',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        );
        // $date="2012/05/03";
        $namahari = date('l', strtotime($date));

        return $daftar_hari[$namahari];
    }
}
