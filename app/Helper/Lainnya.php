<?php

namespace App\Helpers;

use App\Anggota;
use App\LapAkhir;
use App\LapKemajuan;
use App\MasterDekan;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Notifikasi;
use App\Pengesahan;
use App\Profil;
use App\Proposal;
use App\UserGroup;
use FPDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

/**
 * Format response.
 */
class Lainnya
{
    public static function GetHuruf($index = 0)
    {
       $dataHuruf = ['','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA'];

        return $dataHuruf[$index];
    }
   
	// public static function RoleTambahan($nidn)
	// {
	// 	$ketuaLP2M = 0 ; $reviewer = 0;
	// 	$roles = UserGroup::where('nidn', $nidn)->get();
	// 	foreach ($roles as $list ) {
	// 		if ($list->group == "Reviewer")
	// 			$reviewer = 1;
	// 		if ($list->group == "Ketua LP2M")
	// 			$ketuaLP2M = 1;
	// 	}
	// 	session(['reviewer' => $reviewer, 'ketua_lp2m' => $ketuaLP2M]);
	// 	self::setSessionUser($nidn);
	// 	return true;
	// }
	// public static function SendNotifikasi($idProposal,$pengirim,$penerima,$jenis,$judul, $desc)
	// {
	// 	$notify = Notifikasi::create([
	// 		'id_proposal' => $idProposal,
	// 		'nidn_pengirim' => $pengirim,
	// 		'nidn_penerima' => $penerima,
	// 		'jenis_notif' => $jenis,
	// 		'judul' => $judul,
	// 		'deskripsi' => $desc,
	// 		'terbaca' => 0,
	// 	]);
	// 	return true;
	// }
	public static function setSessionUser($nidn)
    {
        $dosen = Dosen::where('nidn',$nidn)->first();
		if ($dosen){
			session(['nama' => $dosen->nama]);
			session(['foto' => "assets/foto/".$dosen->foto]);
			if ($dosen->foto == '' ||$dosen->foto == null )
			    session(['foto' => "assets/foto/blank.jpg"]);
			
			session(['kependidikan' => $dosen->kependidikan]);
			self::setSessionMK();
		}
        return 1;
    }
	public static function setSessionMK()
    {
		$jumlahMK1 = MataKuliah::where('semester','1')
		->orWhere('mata_kuliahs.semester', 3)
		->orWhere('mata_kuliahs.semester', 5)
		->orWhere('mata_kuliahs.semester', 7)->count();
		$jumlahMK1Tekom = MataKuliah::where('id_prodi', '56202')
		->where('mata_kuliahs.semester', 1)
		->orWhere('mata_kuliahs.semester', 3)
		->orWhere('mata_kuliahs.semester', 5)->count();
		$jumlahMK2 = MataKuliah::where('semester','2')
		->orWhere('mata_kuliahs.semester', 4)
		->orWhere('mata_kuliahs.semester', 6)
		->orWhere('mata_kuliahs.semester', 8)->count();
		$jumlahMK2Tekom = MataKuliah::where('id_prodi', '56202')
		->where('semester','2')
		->orWhere('mata_kuliahs.semester', 4)
		->orWhere('mata_kuliahs.semester', 6)
		->orWhere('mata_kuliahs.semester', 8)->count();
		session(['jumlahMK1' => $jumlahMK1]);
		session(['jumlahMK1Tekom' => $jumlahMK1Tekom]);
		session(['jumlahMK1PTIK' => $jumlahMK1 - $jumlahMK1Tekom]);
		session(['jumlahMK2' => $jumlahMK2]);
		session(['jumlahMK2Tekom' => $jumlahMK2Tekom]);
		session(['jumlahMK2PTIK' => $jumlahMK1 - $jumlahMK2Tekom]);
    }
    
}
