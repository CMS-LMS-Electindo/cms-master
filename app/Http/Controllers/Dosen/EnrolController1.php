<?php

namespace App\Http\Controllers\Dosen;

use curl;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\MstUser;
use App\Models\Semester;
use Illuminate\Http\Request;

class EnrolController extends Controller
{
    public function EnrolDosen(Request $request)
    {
        $sem = Semester::where('active', 1)->first();
        $tahun = $sem->year;
        $semester = $sem->semester;
        $idCourseLMS = $request->idLMS;
        $qDosen = $this->ambilDosenSia($request->kode_mk,$request->kode_kurikulum,$request->kode_prodi,$semester, $tahun);
        $domain = Config::where("active", 1)->first()->domain_pt;
        // return response()->json($qDosen);
        // foreach ($qDosen as $list ) {
        for ($i=0; $i < count($qDosen); $i++) { 
            $dosen = MstUser::where('username', $qDosen[$i]['kode_dosen'])->first();
            if (isset($dosen->id_lms)){
                //Enrol
                $enrol = $this->EnrolUser($idCourseLMS, $dosen->id_lms, '3');
            }else{
                //Buat User 
                $qUser = $this->SyncUser($qDosen->kode_dosen,$qDosen[$i]['nama_dosenn'],$qDosen[$i]['kode_prodin'],$qDosen[$i]['kode_fakultasn'], $qDosen[$i]['emailn'],'dosen', $domain,"DSN");
                $enrol = $this->EnrolUser($idCourseLMS, $qUser[0]['id'], '3');
            }
        }
        if ($enrol == ''){
            $return = array(
                'status'    => 1,
                'message'    => "Enrol Dosen Berhasil ",
                'data'    => $enrol,
                'progress'    => rand(25,40),
                );
        }else{
            $return = array(
            'status'    => 0,
            'message'    => "Enrol Dosen Gagal ",
            'data'    => $enrol,
            );
        }
        return response()->json($return);
    }
    public function ambilDosenSia($kodeMK,$kodeKur,$kodeProdi,$semester, $tahun)
    {
        $curl = curl_init();
        $url ='';
        $postAr = array(
            'tahun_akademik' => $tahun,
            'semester' => $semester,
            'kode_kurikulum' => $kodeKur,
            'kode_mk' => $kodeMK,
            'kode_prodi' => $kodeProdi,
        );
        $url= session('DomainSIA')."/cms-dosen-per-mk-semester?h=".session('HeaderSIA')."&app=".session('AppSIA')."";

        curl_setopt_array($curl, 
        array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postAr,
            CURLOPT_HTTPHEADER => array(
                'Cookie: ci_session=f7e9286e42f285d6ecb4028cd78bf2499af77a7f'
            )
        ));
        $response = curl_exec($curl);
        $data = json_decode($response, TRUE);
        // $data = $response;
        // var_dump($postAr);
        // var_dump($data);
        curl_close($curl);
        return $data['data'];
    }
    public static function SyncUser($kode_dosen, $nama_dosen, $kode_prodi, $kode_fakultas,$email, $jenisUser, $domain,$pass)
    {
        if(strpos($email, '@') && strpos($email, '.') ){
            if (str_contains($email, 'example.com')) { 
                if ($jenisUser == '3')
                    $email = $kode_dosen."@".$domain;  
                else
                    $email = $kode_dosen."@student.".$domain; 
            }else{
                $ema = explode("@",$email);
                if ($ema[1] !== "unm.ac.id" || $ema[1] !== "gmail.com" || $ema[1] !== "yahoo.com" || $ema[1] !== "yahoo.co.id" || $ema[1] !== "rocketmail.com" || $ema[1] !== $domain ){
                    if ($jenisUser == '3')
                        $email = $kode_dosen."@".$domain; 
                    else
                        $email = $kode_dosen."@student.".$domain; 
                }
            }

        } else{
                $email = $kode_dosen."@".$domain; 
        }
        $users1 = array(
            'username'=> strtolower( $kode_dosen),
            'firstname'=>$kode_dosen,
            'lastname'=>$nama_dosen,
            'email'=> strtolower($email),
            'department'=>$kode_prodi,
            'institution'=>$kode_fakultas,
            'description'=>$jenisUser,
            'password' => $pass.$kode_dosen,
        );
        $users[] = $users1;      
		$data = array('users' => $users);
        // return var_dump($data);
        // return response()->json($dosenCMS);

        header('Content-Type: text/plain');
		$buatkategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_user_create_users';

		$curl = new curl;
		$injek = $curl->post($buatkategori, $data);
        $data1 = json_decode($injek, TRUE);
        // Tambah kategori ke db cms
        $i = 0;
        if (isset($data1['message'])){
            $return = array(
                   'status'    => false,
                   'message'    => $data1['message'],
                   'data1'    => $data1,
                   'data'    => $data,
               );
            // return response()->json($return);
        }else{
            foreach ($data1 as $list) {
                // Insert Dosen
                $data2 = array(
                    'usertype' => $jenisUser,
                    'username' => $kode_dosen,
                    'fullname'=> $nama_dosen,
                    'code_prodi'=> $kode_prodi,
                    'code_fakultas'=> $kode_fakultas,
                    'id_lms' =>$list['id'],
                );
                $insert = MstUser::create($data2);
                $i++;
            }
           
        }
        return $data1;

    }
    public function EnrolUser($idCourse, $idUser, $role)
    {
        $enrol = array();
        $users = array(
            'roleid'=> $role,
            'courseid'=>$idCourse,
            'userid'=>$idUser,
        );
        $enrol[] = $users;  
		$data = array('enrolments' => $enrol);
        // return var_dump($data);
        // return $data;

        header('Content-Type: text/plain');
		$buatkategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=enrol_manual_enrol_users';

		$curl = new curl;
		$injek = $curl->post($buatkategori, $data);
        $data1 = json_decode($injek, TRUE);
        return $data1;
        
    }
    
    public function EnrolMahasiswa(Request $request)
    {
        $sem = Semester::where('active', 1)->first();
        $tahun = $sem->year;
        $semester = $sem->semester;
        $idCourseLMS = $request->idLMS;
        $qMhs = $this->ambilMahasiswaSia($request->kode_mk,$request->kode_kurikulum,$request->kode_prodi,$semester, $tahun);
        $domain = Config::where("active", 1)->first()->domain_pt;
        // return response()->json($domain);
        $enrol = '';
        for ($i=0; $i < count($qMhs); $i++) { 
            $dosen = MstUser::where('username', $qMhs[$i]['kode_mahasiswa'])->first();
            if (isset($dosen->id_lms)){
                //Enrol
                $enrol = $this->EnrolUser($idCourseLMS, $dosen->id_lms, '5');
            }else{
                //Buat User 
                $qUser = $this->SyncUser($qMhs[$i]['kode_mahasiswa'],$qMhs[$i]['nama_mahasiswa'],$qMhs[$i]['kode_prodi'],$qMhs[$i]['kode_fakultas'], $qMhs[$i]['email'],'mahasiswa',$domain,"MHS");
                // return response()->json($qUser);
                $enrol = $this->EnrolUser($idCourseLMS, $qUser[0]['id'], '5');
            }
        }
        if ($enrol == ''){
            $return = array(
                'status'    => 1,
                'message'    => "Enrol Mahasiswa Berhasil ",
                'data'    => $qMhs,
                'progress'    => rand(45,85),
            );
        }else{
            $return = array(
            'status'    => 0,
            'message'    => "Enrol Mahasiswa Gagal ",
            'data'    => $enrol,
            );
        }
        return response()->json($return);
    }
    public function ambilMahasiswaSia($kodeMK,$kodeKur,$kodeProdi,$semester, $tahun)
    {
        $curl = curl_init();
        $url ='';
        $postAr = array(
            'tahun_akademik' => $tahun,
            'semester' => $semester,
            'kode_kurikulum' => $kodeKur,
            'kode_mk' => $kodeMK,
            'kode_prodi' => $kodeProdi,
        );
        $url= session('DomainSIA')."/cms-mahasiswa-per-mk-semester?h=".session('HeaderSIA')."&app=".session('AppSIA')."";

        curl_setopt_array($curl, 
        array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postAr,
            CURLOPT_HTTPHEADER => array(
                'Cookie: ci_session=f7e9286e42f285d6ecb4028cd78bf2499af77a7f'
            )
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, TRUE);
        // $data = $response;
        // var_dump($postAr);
        // var_dump($data);
        curl_close($curl);
        return $data['data'];
    }
    public function EnrolMahasiswaMK(Request $request)
    {
        
    }
    public function edit()
    {
        //
    }
    public function show($id)
    {
        //
    } 
}
