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
			$config = Config::where('active',1)->first();
			$version = Version::where('active',1)->first();
			if ($config){
				session(['TokenLMS' => $config->token_lms]);
				session(['TokenLMSAuth' => $config->token_auth]);
				session(['DomainLMS' => $config->domain_lms]);
				session(['DomainPT' => $config->domain_pt]);
				session(['DomainSIA' => $config->domain_api]);
				session(['HeaderSIA' => $config->token_sia]);
				session(['AppSIA' => $config->app_sia]);
				session(['namaApp' => $config->nama_app]);
				session(['namaPT' => $config->nama_pt]);
				session(['logo' => "assets/media/logos/" . $config->logo]);
				session(['logo_gelap' => "assets/media/logos/" . $config->logo_gelap]);
				session(['logo_terang' => "assets/media/logos/" . $config->logo_terang]);

				session(['version_name' => $version->version_name]);
				session(['version_number' => $version->version_number]);
				session(['desc' => $version->desc]);
			}
		// }
        return 1;
    }
	
    
}
