<?php

namespace App\Http\Controllers\Dosen;
use curl;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\MstUser;
use App\Models\Semester;
use Illuminate\Http\Request;

class GroupingMahasiswaController extends Controller
{
    //
    public function AddGroupMk(Request $request)
    {
        $sem = Semester::where('active', 1)->first();
        $tahun = $sem->year;
        $semester = $sem->semester;
        $tahunSingkat = substr($sem->year,0,4). $sem->semester; 
        $idCourseLMS = $request->idLMS;
        $qMhs = $this->ambilMahasiswaSia($request->kode_mk,$request->kode_kurikulum,$request->kode_prodi,$semester, $tahun); 
        $kel = '';
        $idGrup = '';
        $addMember = 0;
        for ($i=0; $i < count($qMhs); $i++) { 
            $idUser = MstUser::where('username', $qMhs[$i]['kode_mahasiswa'])->first()->id_lms;
            $idNumber = $tahunSingkat."-".$request->kode_fakultas.$request->kode_prodi."-".$request->kode_kurikulum.'-'.$request->kode_mk."-".$qMhs[$i]['kode_kelas'];
            if ($kel !== $qMhs[$i]['kode_kelas']){
                //buat grup
                // id number : 20212-59888-BC333333-PTIKA
                $addGroup = $this->createGroupMK($idCourseLMS,$qMhs[$i]['kode_kelas'],$idNumber);
                $kel = $qMhs[$i]['kode_kelas'];
                // tambahkan mhs ke grup
                // return response()->json($addGroup);
                $idGrup = $addGroup[0]['id'];
                $addMember = $this->AddMemberGroup($idGrup, $idUser) ;
            }else{
                if ($idGrup != ''){
                    // tambahkan mhs ke grup
                    $addMember = $this->AddMemberGroup($idGrup, $idUser) ;
                }else{
                    // get id grup lalu tambahkan
                    $idGrup = $this->checkGroup($idCourseLMS,$qMhs[$i]['kode_kelas'],$idNumber);
                    $addMember = $this->AddMemberGroup($idGrup, $idUser) ;
                }
            }
        }
        $return = array(
            'status'    => 1,
            'message'    => "Enrol Mahasiswa Berhasil ",
            'data'    => $addMember,
            'progress'    =>100,
        );
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
        curl_close($curl);
        return $data['data'];
    }
    function createGroupMK($idCourse,$kodeKelas,$idNumber)
    {
        $users1 = array(
            'name'=> $kodeKelas,
            'courseid'=>$idCourse,
            'idnumber'=>$idNumber,
            'description'=>$idNumber,
        );
        $users[]= $users1;       
		$data = array('groups' => $users);
        // return var_dump($data);
        // return response()->json($dosenCMS);

        header('Content-Type: text/plain');
		$buatkategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_group_create_groups';

		$curl = new curl;
		$injek = $curl->post($buatkategori, $data);
        $data1 = json_decode($injek, TRUE);
        // var_dump()
        return $data1;
    }
    function AddMemberGroup($groupid,$idUser)
    {
        $users = array(
            'groupid'=>$groupid,
            'userid'=>$idUser,
        );
               
		$data = array('groups' => $users);
        // return var_dump($data);
        // return response()->json($dosenCMS);

        header('Content-Type: text/plain');
		$buatkategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_group_add_group_members';

		$curl = new curl;
		$injek = $curl->post($buatkategori, $data);
        $data1 = json_decode($injek, TRUE);
        return $data1;
    }
    function checkGroup($idCourse,$kodeKelas,$idNumber)
    {
        $data = array(
            'courseid'=>$idCourse,
        );
        header('Content-Type: text/plain');
		$buatkategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_group_get_course_groups';

		$curl = new curl;
		$injek = $curl->post($buatkategori, $data);
        $data1 = json_decode($injek, TRUE);
        $idGrup = 0;
        // var_dump($data);
        // var_dump($data1);
        for ($i=0; $i < count($data1); $i++) { 
            if ($kodeKelas == $data1[$i]['name']){
                $idGrup =  $data1[$i]['id'];
                break;
            }
        }
        return $idGrup;
    }
    public function AddMhsGroupMk(Request $request)
    {
        $sem = Semester::where('active', 1)->first();
        $tahun = $sem->year;
        $semester = $sem->semester;
        $tahunSingkat = substr($sem->year,0,4). $sem->semester; 
        $idCourseLMS = $request->idLMS;
        $qMhs = $this->ambilMahasiswaSia($request->kode_mk,$request->kode_kurikulum,$request->kode_prodi,$semester, $tahun); 
        $kel = '';
        $idGrup = '';
        $addMember = 0;
        for ($i=0; $i < count($qMhs); $i++) { 
            $idUser = MstUser::where('username', $qMhs[$i]['kode_mahasiswa'])->first()->id_lms;
            $idNumber = $tahunSingkat."-".$request->kode_prodi."-".$request->kode_mk."-".$qMhs[$i]['kode_kelas'];
            // get id grup lalu tambahkan
            $idGrup = $this->checkGroup($idCourseLMS,$qMhs[$i]['kode_kelas'],$idNumber);
            $addMember = $this->AddMemberGroup($idGrup, $idUser) ;
        }
        $return = array(
            'status'    => 1,
            'message'    => "Enrol Mahasiswa Berhasil ",
            'data'    => $addMember,
            'progress'    =>100,
        );
        return response()->json($return);
    }
}
