<?php

namespace App\Http\Controllers\Dosen;

use curl;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Config;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class MataKuliahController extends Controller
{
    public function index(Request $request)
    {
        $page = 'Mata Kuliah Reguler ';
        $parent1 = 'Dosen ';
        $data['page'] = $page;
        $data['toolBarDesc'] = "<li class=\"breadcrumb-item text-muted\">
            <a href=\"dashboard\" class=\"text-muted text-hover-primary\">Dashboard</a>
            </li>
            <li class='breadcrumb-item'>
                <span class='bullet bg-gray-300 w-5px h-2px'></span>
            </li>
            <li class=\"breadcrumb-item text-muted\">".$parent1."</li>
            <li class='breadcrumb-item'>
                <span class='bullet bg-gray-300 w-5px h-2px'></span>
            </li>
            <li class='breadcrumb-item text-dark'>".$page."</li>";
        $data['sem'] =Semester::orderBy('year', 'desc')->orderBy('semester', 'desc')->get();
        $data['prodi'] =Category::where('parent', '<>', '0')->orderBy('parent', 'asc')->get();
        return view('dosen.mata_kuliah.default',$data);
    }
    
    public function getMkDosen(Request $request)
    {
        $curl = curl_init();
        $url ='';
        $postAr = [];
        $url= session('DomainSIA')."/cms-dosen-mk-semester?h=".session('HeaderSIA')."&app=".session('AppSIA');
        
        $sem = Semester::where('id', $request->id)->first();
        if ($request->id == null)
          $sem = Semester::where('active', 1)->first();
        $semester = $sem->semester;
        $tahunAkademik = $sem->year;
        $mulai= $sem->startdate . ' 00:00:00';
        $selesai= $sem->enddate . ' 23:59:59';
        $tahunSingkat = substr($sem->year,0,4). $sem->semester; 

        $conf = Config::where('active', 1)->first();
        $tipe = $conf->add_course;
        $nidn = Auth::user()->username;
        $postAr = array(
            'tahun_akademik' => $tahunAkademik,
            'semester'=>$semester,
            'tipe'=>$tipe,
        );
        if ($nidn !== "admin"){
            $postAr['nidn'] = $nidn;
        }else{
            $postAr['nidn'] = '0003117804';
        }

        if ($request->kode_prodi !== null){
          $postAr['kode_prodi'] =$request->kode_prodi; 
        }
        
        if ($request->search !== null){
          $postAr['search'] =$request->search; 
        }

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
        try {
          $response = curl_exec($curl);
          $data = json_decode($response, TRUE);
          // $data = $response;
          curl_close($curl);
          $html="";
          for ($i=0; $i < count($data['data']) ; $i++) { 
            $disable ="disabled";
            $footer ='<a href="#" class="btn btn-sm btn-bg-light btn-active-color-primary me-3 " onclick="detailMK(\''.$data['data'][$i]['kode_kurikulum'].'\',\''.$data['data'][$i]['kode_mk'].'\')">Info Mata Kuliah</a>
            <a href="#" class="btn btn-sm btn-danger me-3 create-mk-'.$i.'" onclick="buatMK(\'create-mk-'.$i.'\',\''.$data['data'][$i]['kode_prodi'].'\',\''.$data['data'][$i]['kode_kurikulum'].'\',\''.$data['data'][$i]['kode_mk'].'\',\''.$data['data'][$i]['nama_mk'].'\')">Buat Mata Kuliah</a>';
  
            $qMK = Course::where(['idsemester' =>$sem->id, 'code_prodi' =>$data['data'][$i]['kode_prodi'], 'idnumber' => $data['data'][$i]['kode_prodi']. '-'.$tahunSingkat. '-'.$data['data'][$i]['kode_kurikulum'].'-'.$data['data'][$i]['kode_mk']])->first();
            $idEn =  Response::encrypt('0');
            $idLMS =  0;
            if (isset($qMK->id_lms) >=1){
              // if (count($qMK) >=1){
              $disable = "";
              $idEn =  Response::encrypt($qMK->id_lms);
              $idLMS =  $qMK->id_lms;
              $footer ='<a href="#" class="btn btn-sm btn-bg-light btn-active-color-primary me-3 " onclick="detailMK(\''.$data['data'][$i]['kode_kurikulum'].'\',\''.$data['data'][$i]['kode_mk'].'\')">Info Mata Kuliah</a>
              <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('masuk').'" target="_blank" class="btn btn-sm btn-success me-3" >Masuk</a>';
            }
            
            $html .='<div class="col-xl-12">
              <div class="card card-xl-stretch mb-xl-8 bg-light-warning rounded p-4 border-danger border border-dashed">
                <div class="card-header border-0 mb-3" style="min-height: auto; justify-content: start; z-index: 1;">
                  <div class=" m-2">
                    <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary '.$disable.'" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;">
                      <div class="badge badge-primary p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-people-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Peserta  &nbsp;&nbsp; 
                        
                        <span class="menu-icon">
                          <i class="bi bi-caret-down-fill fs-5 " style="color: white"></i>
                        </span>
                      </div>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true" >
                      <div class="menu-item px-3">
                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Peserta</div>
                      </div>
                      <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3 sync-peserta"  onclick="syncMahasiswa(\'create-mk-'.$i.'\',\''.$data['data'][$i]['kode_prodi'].'\',\''.$data['data'][$i]['kode_kurikulum'].'\',\''.$data['data'][$i]['kode_mk'].'\',\''.$data['data'][$i]['nama_mk'].'\',\''.$idLMS.'\')">Sinkron Peserta</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="#" class="menu-link px-3">Enrol Dosen LB/Tamu</a>
                      </div>
                      <div class="menu-item px-3">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('peserta').'" target="_blank" class="menu-link px-3">Daftar Mahasiswa</a>
                      </div>
                      <div class="menu-item px-3">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('kelas').'" target="_blank" class="menu-link px-3">Daftar Kelas</a>
                      </div>
                    </div>
                  </div>
                  <div class=" m-2">
                    <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-success '.$disable.'" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;"">
                      <div class="badge badge-success p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-award-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp; Nilai  &nbsp;&nbsp; 
                        <span class="menu-icon">
                          <i class="bi bi-caret-down-fill fs-5" style="color: white"></i>
                        </span>
                      </div>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                      <div class="menu-item px-3">
                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Nilai</div>
                      </div>
                      <div class="menu-item px-3">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('bobotn').'" target="_blank" class="menu-link px-3">Atur Bobot Nilai</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('lihatn').'" target="_blank" class="menu-link px-3">Daftar Nilai</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('eksn').'" target="_blank" class="menu-link px-3">Export Nilai</a>
                      </div>
                    </div>
                  </div>
                  <div class=" m-2">
                    <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-secondary '.$disable.'" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;">
                      <div class="badge badge-secondary p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-binoculars-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Monitoring Kelas  &nbsp;&nbsp; 
                        
                        <span class="menu-icon">
                          <i class="bi bi-caret-down-fill fs-5" style="color: white"></i>
                        </span>
                      </div>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                      <div class="menu-item px-3">
                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Monitoring Kelas</div>
                      </div>
                      <div class="menu-item px-3">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('statistik').'" target="_blank" class="menu-link px-3">Statistik Kelas</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('komplit').'" target="_blank" class="menu-link px-3">Ketuntasan Mahasiswa</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('partisipasi').'" target="_blank" class="menu-link px-3">Partisipasi Mahasiswa</a>
                      </div>
                    </div>
                  </div>
                  <div class=" m-2">
                    <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-warning '.$disable.'" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;">
                      <div class="badge badge-warning p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-bookmarks-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Bank Soal  &nbsp;&nbsp; 
                        
                        <span class="menu-icon">
                          <i class="bi bi-caret-down-fill fs-5" style="color: white"></i>
                        </span>
                      </div>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                      <div class="menu-item px-3">
                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Bank Soal</div>
                      </div>
                      <div class="menu-item px-3">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('datas').'" target="_blank" class="menu-link px-3">Daftar Soal</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('imports').'" target="_blank" class="menu-link px-3">Import Soal</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('ekspors').'" target="_blank" class="menu-link px-3">Export Soal</a>
                      </div>
                    </div>
                  </div>
                  <div class=" m-2">
                    <button type="button" class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-danger '.$disable.'" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" style="width: auto;">
                      <div class="badge badge-danger p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-gear-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Tools  &nbsp;&nbsp; 
                        
                        <span class="menu-icon">
                          <i class="bi bi-caret-down-fill fs-5" style="color: white"></i>
                        </span>
                      </div>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-bold w-200px py-3" data-kt-menu="true">
                      <div class="menu-item px-3">
                        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Pengaturan</div>
                      </div>
                      <div class="menu-item px-3">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('editk').'" target="_blank" class="menu-link px-3">Pengaturan Kelas</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('backupk').'" target="_blank" class="menu-link px-3">Backup Kelas</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('restorek').'" target="_blank" class="menu-link px-3">Restore Kelas</a>
                      </div>
                      <div class="menu-item px-3 my-1">
                        <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('importk').'" target="_blank" class="menu-link px-3">Import Kelas</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body p-0" style="">
                  <div class="d-flex align-items-center p-5 pt-0 ">
                    <span class="svg-icon svg-icon-warning me-5">
                      <span class="svg-icon svg-icon-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black" />
                          <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black" />
                        </svg>
                      </span>
                    </span>
                    <div class="flex-grow-1 me-2">
                      <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('masuk').'" target="_blank" class="fw-bolder text-gray-800 text-hover-primary fs-2x">'.$data['data'][$i]['kode_mk'].' - '.$data['data'][$i]['nama_mk'].'</a>
                      <div class="d-flex mb-1">
                        <div class="notice d-flex bg-light-warning rounded border-primary border border-dashed p-2 mx-1" style="width: fit-content;">
                          <span class="text-muted fw-bold d-block">'.$data['data'][$i]['kode_kurikulum'].'</span> 
                        </div>
                        <div class="notice d-flex bg-light-warning rounded border-primary border border-dashed p-2 mx-1" style="width: fit-content;">
                          <span class="fw-bolder text-gray-800 text-hover-primary fs-6"> '.$data['data'][$i]['nama_prodi'].' </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer p-0" style="border-top: 0px;">
                  <div class="d-flex mb-1" style="justify-content: flex-end;">
                    '.$footer.'
                  </div>
                </div>
                <img src="assets/media/illustrations/sigma-1/17-dark.png" class="position-absolute me-3 end-0 h-150px" alt="" style="z-index: 0; bottom: 50px;" />
              </div>
            </div>
            ';
            $result['html'] = $html;
            $result['req'] = $postAr;
          }
        } catch (\Throwable $th) {
          //throw $th;
          $result = array(
            'status'    => 1,
            'message'    => $th->getMessage(),
            'html' => "Data Tidak Ditemukan"
          );
          $result['req'] = $postAr;
        }
        // print_r($data);

        // $qMK = Course::where(['idsemester' =>$sem->id, 'code_prodi' =>$nidn])->get();

        
        
        // return $data['data'];
        return response()->json($result);
    }
    public function show($id)
    {
        //
    } 
    public function MakeMKLMS(Request $request)
    {
      // Tambah Kategori Category ke LMS
      $sem = Semester::where('active', 1)->first();
      $mulai= $sem->startdate . ' 00:00:00';
      $selesai= $sem->enddate . ' 23:59:59';
      $tahunSingkat = substr($sem->year,0,4). $sem->semester; 
      // Check Kategori 
      $kodeKategori = $request->kode_prodi. "-". $tahunSingkat; //idnumber
      $idCategory = $this->getCategory($kodeKategori);

      $s = "Ganjil";
      if ($sem->semester == 2)
        $s = "Genap";
      elseif ($sem->semester == 2)
        $s = "Antara";

      if ($idCategory === 0){
        // 20303 - 2021/2022 Genap
        $nama = $request->kode_prodi . " - ". substr_replace($sem->year,'/',4,1) ." " . $s;
        $idCategory =$this->makeCategory($kodeKategori, $request->kode_prodi, $nama );
      }
      // return response()->json($idCategory);
      
      $fullname =substr($sem->year,0,4). " ". $s. " - ". $request->nama_mk;
      $shortname=$request->kode_prodi. '-'.$tahunSingkat. '-'.$request->kode_mk;
      $categoryid=$idCategory;
      $idnumber=$request->kode_prodi. '-'.$tahunSingkat. '-'.$request->kode_kurikulum.'-'.$request->kode_mk;

      $course= new stdClass();
      $course->fullname=$fullname;
      $course->shortname=$shortname;
      $course->categoryid= $idCategory;
      $course->idnumber=$idnumber;
      $timestamp = strtotime($mulai);
      $course->startdate=$timestamp;
      $timestamp = strtotime($selesai);
      $course->enddate=$timestamp;
      $course->numsections=16; //deprecated
      $course->groupmode=2; //0=no group (buat mk perkelas) 1= visible group 2= separate group
      $course->showreports=1;
      $course->enablecompletion=1;
      $course = array($course);
      $data = array('courses' => $course);
      
      header('Content-Type: text/plain');
      $buatkelas = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_course_create_courses';
      
      $curl = new curl;
      $injek = $curl->post($buatkelas, $data);

      // $data1 = var_dump($data);		
      //cek status injek
      $data1 = json_decode($injek, TRUE);
      // echo $data1 = json_encode($data, TRUE);
      if (isset($data1[0]['id'])){
        //berhasil
        $dataMK = array(
          'categoryid' => $idCategory,
          'fullname' =>substr($sem->year,0,4). " ". $s. " - ". $request->nama_mk,
          'shortname' => $data1[0]['shortname'],
          'idnumber' => $request->kode_prodi. '-'.$tahunSingkat. '-'.$request->kode_kurikulum.'-'.$request->kode_mk,
          'idsemester' => $sem->id,
          'code_prodi' => $request->kode_prodi,
          'code_kur' => $request->kode_kurikulum,
          'nidn' => Auth::user()->username,
          'code_class' => $data1[0]['id'],
          'id_lms' => $data1[0]['id']
        );
        $insert = Course::create($dataMK);
        $return = array(
          'status'    => 1,
          'message'    => "Data Mata Kuliah Berhasil Ditambahkan",
          'data'    => $data1,
          'progress'    => rand(10,20),
          'id_lms'    => $data1[0]['id'],
          
        );
      }else{
        $return = array(
          'status'    => 0,
          'message'    => "Data Mata Kuliah Gagal Ditambahkan",
          'data'    => $data1,
        );
      }
      return response()->json($return);

    }
    function getCategory($kode)
    {
      header('Content-Type: text/plain');
      $baca_kategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_course_get_categories&criteria[0][key]=parent&criteria[0][value]=0';
      $cri = array(
        'key'=>'idnumber',
        'value'=>$kode,
      );
      $criteria = array($cri);
      $data = array('criteria' => $criteria);
      
      $curl = new curl;
      $injek = $curl->post($baca_kategori, $data);
      //print_r($injek);
      
      $hasil = json_decode($injek);
      // return $hasil;
      if (count($hasil) < 1)
        return 0;
      else
        return $hasil[0]->id;
      
    }
    public function makeCategory($kodeKategori, $kode_prodi, $nama )
    {
      // Tambah Kategori Prodi - Semester ke LMS
      $parent = $this->getCategory($kode_prodi);
        // return $parent;
      $category = array(
          'name'=>$nama,
          'parent'=>$parent,
          'idnumber'=>$kodeKategori,
          'description' => ''    ,            
          'descriptionformat' => 1  ,              
      );
      $categories[] = $category;
      $data = array('categories' => $categories);

      header('Content-Type: text/plain');
      $buatkategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_course_create_categories';

      $curl = new curl;
      $injek = $curl->post($buatkategori, $data);
      $data1 = json_decode($injek, TRUE);

      // return $data1;
      return $data1[0]['id'];

    }
    
    function getUsers($kode)
    {
      header('Content-Type: text/plain');
      $baca_kategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_user_get_users&criteria[0][key]=parent&criteria[0][value]=0';
      $cri = array(
        'key'=>'idnumber',
        'value'=>$kode,
      );
      $criteria = array($cri);
      $data = array('criteria' => $criteria);
      
      $curl = new curl;
      $injek = $curl->post($baca_kategori, $data);
      //print_r($injek);
      
      $hasil = json_decode($injek);
      // return $hasil;
      if (count($hasil) < 1)
        return 0;
      else
        return $hasil[0]->id;
      
    }

    public function ActionMoodle(Request $request)
    {
      $nidn = Auth::user()->username;
      if ($nidn !== "admin"){
          $nidn = $nidn;
      }else{
          $nidn = '0003117804';
      }
      
      $username = $nidn;
      $functionname = 'auth_userkey_request_login_url';
      $login="";
      $param = [
        'user' => [
          'username'  => strtolower($username),    
        ]
      ];
    
      $curl = new curl;
      $baca_kategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMSAuth') . '&moodlewsrestformat=json&wsfunction=' . $functionname ;
      $resp = $curl->post($baca_kategori, $param);
      $respA = json_decode($resp);
      var_dump($respA);
      var_dump($param);
      var_dump(session('TokenLMSAuth'));
      if (!empty($respA->loginurl)) {
        $loginurl = $respA->loginurl; 

        $id = Response::decrypt($request->id);
        $menu = Response::decrypt($request->type);
        $domainLMS = session('DomainLMS');

        if($menu=="peserta") {
          $login=$loginurl.'&wantsurl='.$domainLMS.'/user/index.php?id='.$id;
        } else if($menu=="kelas"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/group/index.php?id='.$id;
        }elseif($menu=="bobotn"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/grade/edit/tree/index.php?id='.$id;
        }elseif($menu=="lihatn"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/grade/report/grader/index.php?id='.$id;
        }elseif($menu=="eksn"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/grade/export/xls/index.php?id='.$id;
        }elseif($menu=="statistik"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/report/overviewstats/index.php?course='.$id;
        }elseif($menu=="komplit"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/report/progress/index.php?course='.$id;
        }elseif($menu=="partisipasi"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/report/participation/index.php?id='.$id;
        }elseif($menu=="datas"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/question/edit.php?courseid='.$id;
        }elseif($menu=="imports"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/question/import.php?courseid='.$id;
        }elseif($menu=="ekspors"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/question/export.php?courseid='.$id;
        }elseif($menu=="editk"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/course/edit.php?id='.$id;
        }elseif($menu=="backupk"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/backup/backup.php?id='.$id;
        }elseif($menu=="restorek"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/backup/restorefile.php?contextid='.$id;
        }elseif($menu=="importk"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/backup/import.php?id='.$id;
        }elseif($menu=="masuk"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/course/view.php?id='.$id;
          
          // menu mahasiswa
        }elseif($menu=="nilai"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/grade/report/user/index.php?id='.$id;
        }elseif($menu=="file"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/user/files.php';
        }elseif($menu=="calender"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/calendar/view.php?view=month&course='.$id;
        }elseif($menu=="badges"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/badges/view.php?type=2&id='.$id;
        }elseif($menu=="kompetensi"){
          $login=$loginurl.'&wantsurl='.$domainLMS.'/admin/tool/lp/coursecompetencies.php?courseid='.$id;
        }
        header('Location: '.$login);
      }
    }
    public function getDetailMK(Request $request)
    {
      
        $curl = curl_init();
        $url ='';
        $postAr = [];
        $url= session('DomainSIA')."/cms-detail-mk?h=".session('HeaderSIA')."&app=".session('AppSIA');
        $sem = Semester::where('active', 1)->first();
        $semester = $sem->semester;
        $tahunAkademik = $sem->year;
        $conf = Config::where('active', 1)->first();
        $postAr = array(
            'tahun_akademik' => $tahunAkademik,
            'semester'=>$semester,
            'kode_mk'=>$request->kode_mk,
            'kode_kurikulum'=>$request->kode_kurikulum,
        );
        $html = '';
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
        try {
          $response = curl_exec($curl);
          $data = json_decode($response, TRUE);
          // $data = $response;
          curl_close($curl);
          $html="";
          $jumlahDosen = count($data['dataDosen']);
          $jumlahKelas = count($data['dataKelas']);
          $listDosen = '';
          for ($i=0; $i < $jumlahDosen; $i++) { 
            $listDosen .= '<div class="d-flex align-items-center mb-7">
              <span class="fw-bold fs-5 text-gray-700 flex-grow-1">'.$data['dataDosen'][$i]['kode_dosen'].' - '.$data['dataDosen'][$i]['nama_dosen'].'</span>
            </div>';
          }
          $listKelas = '';
          for ($i=0; $i < $jumlahKelas; $i++) { 
            $listKelas .= '<div class="d-flex align-items-center mb-7">
              <span class="fw-bold fs-5 text-gray-700 flex-grow-1">'.$data['dataKelas'][$i]['kelas'].'</span>
            </div>';
          }
          // var_dump($listKelas);

          $html ='
            <div class="col-lg-6 mb-10 mb-lg-0">
              <div class="nav flex-column">
                <div class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 active mb-6" data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_startup">
                  <div class="d-flex align-items-center me-2">
                    <div class="form-check form-check-custom form-check-solid form-check-success me-6">
                      <input class="form-check-input" type="radio" name="plan"  value="startup" />
                    </div>
                    <div class="flex-grow-1">
                      <h2 class="d-flex align-items-center fs-2 fw-bolder flex-wrap">'.$data['dataDosen'][0]['nama_mk'].'</h2>
                      <div class="fw-bold opacity-50">'.$data['dataDosen'][0]['nama_prodi'].'</div>
                    </div>
                  </div>
                  <div class="ms-5">
                    <span class="mb-2"></span>
                    <span class="fs-2x fw-bolder" data-kt-plan-price-month="39" data-kt-plan-price-annual="399">'.$data['dataDosen'][0]['kode_prodi'].'</span>
                  </div>
                </div>
                <div class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6" data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_advanced">
                  <div class="d-flex align-items-center me-2">
                    <div class="form-check form-check-custom form-check-solid form-check-success me-6">
                      <input class="form-check-input" type="radio" name="plan" value="advanced" />
                    </div>
                    <div class="flex-grow-1">
                      <h2 class="d-flex align-items-center fs-2 fw-bolder flex-wrap">List Dosen</h2>
                      <div class="fw-bold opacity-50">Jumlah Dosen : </div>
                    </div>
                  </div>
                  <div class="ms-5">
                    <span class="mb-2"></span>
                    <span class="fs-2x fw-bolder" data-kt-plan-price-month="'.$jumlahDosen.'" data-kt-plan-price-annual="'.$jumlahDosen.'">'.$jumlahDosen.'</span>
                  </div>
                </div>
                <div class="nav-link btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6" data-bs-toggle="tab" data-bs-target="#kt_upgrade_plan_enterprise">
                  <div class="d-flex align-items-center me-2">
                    <div class="form-check form-check-custom form-check-solid form-check-success me-6">
                      <input class="form-check-input" type="radio" name="plan" value="enterprise" />
                    </div>
                    <div class="flex-grow-1">
                      <h2 class="d-flex align-items-center fs-2 fw-bolder flex-wrap">List Kelas
                      </h2>
                      <div class="fw-bold opacity-50">Jumlah Kelas :</div>
                    </div>
                  </div>
                  <div class="ms-5">
                    <span class="mb-2"></span>
                    <span class="fs-2x fw-bolder" data-kt-plan-price-month="'.$jumlahKelas.'" data-kt-plan-price-annual="'.$jumlahKelas.'">'.$jumlahKelas.'</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="tab-content rounded h-100 bg-light p-10">
                <div class="tab-pane fade show active" id="kt_upgrade_plan_startup">
                  <div class="pb-5">
                    <h2 class="fw-bolder text-dark">'.$data['dataDosen'][0]['nama_mk'].'</h2>
                    <div class="text-muted fw-bold">'.$data['dataDosen'][0]['nama_prodi'].'</div>
                  </div>
                  <div class="pt-1">
                    <div class="d-flex align-items-center mb-7">
                      <span class="fw-bold fs-5 text-gray-700 flex-grow-1">Kode MK : '.$request->kode_mk.'</span>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                      <span class="fw-bold fs-5 text-gray-700 flex-grow-1">Jumlah SKS : '.$data['dataDosen'][0]['sks'].'</span>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                      <span class="fw-bold fs-5 text-gray-700 flex-grow-1">Jumlah Dosen Pengampu : '.$jumlahDosen.'</span>
                    </div>
                    <div class="d-flex align-items-center mb-7">
                      <span class="fw-bold fs-5 text-gray-700 flex-grow-1">Jumlah Kelas : '.$jumlahKelas.'</span>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="kt_upgrade_plan_advanced">
                  <div class="pb-5">
                    <h2 class="fw-bolder text-dark">List Dosen Pengampu Mata Kuliah</h2>
                  </div>
                  <div class="pt-1">
                    '.$listDosen.'
                  </div>
                </div>
                <div class="tab-pane fade" id="kt_upgrade_plan_enterprise">
                  <div class="pb-5">
                    <h2 class="fw-bolder text-dark">List Kelas pada Mata Kuliah</h2>
                  </div>
                  <div class="pt-1">
                    '.$listKelas.'
                  </div>
                </div>
              </div>
          </div>';
          $result['status'] =1;
          $result['html'] = $html;
        } catch (\Throwable $th) {
          //throw $th;
          $result = array(
            'status'    => 0,
            'message'    => $th->getMessage(),
          );
        }
        // print_r($data);

        // $qMK = Course::where(['idsemester' =>$sem->id, 'code_prodi' =>$nidn])->get();

        
        
        // return $data['data'];
        return response()->json($result);
    }
}
