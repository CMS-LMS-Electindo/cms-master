<?php

namespace App\Helpers;

use App\Anggota;
use App\LapAkhir;
use App\LapKemajuan;
use App\MasterDekan;
use App\Models\Config;
use App\Models\Dosen;
use App\Models\MataKuliah;
use App\Models\Version;
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
	public static function setSessionToken()
    {
		// if (session()->has('namaApp')) {
			$dosen = Config::where('active',1)->first();
			$version = Version::where('active',1)->first();
			if ($dosen){
				session(['TokenLMS' => $dosen->token_lms]);
				session(['TokenLMSAuth' => $dosen->token_auth]);
				session(['DomainLMS' => $dosen->domain_lms]);
				session(['DomainPT' => $dosen->domain_pt]);
				session(['DomainSIA' => $dosen->domain_api]);
				session(['HeaderSIA' => $dosen->token_sia]);
				session(['AppSIA' => $dosen->app_sia]);
				session(['namaApp' => $dosen->nama_app]);
				session(['namaPT' => $dosen->nama_pt]);

				session(['version_name' => $version->version_name]);
				session(['version_number' => $version->version_number]);
				session(['desc' => $version->desc]);
			}
		// }
        return 1;
    }
	
    
}
