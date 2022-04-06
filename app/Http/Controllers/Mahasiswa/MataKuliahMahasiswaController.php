<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Course;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MataKuliahMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $page = 'Mata Kuliah Reguler ';
        $parent1 = 'Mahasiswa ';
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
        // $data['mk'] = $this->edit;
        return view('mahasiswa.mata_kuliah.default',$data);
    }
    
    public function getMkMahasiswa(Request $request)
    {
        $curl = curl_init();
        $url ='';
        $postAr = [];
        $url= session('DomainSIA')."/cms-mahasiswa-mk-semester?h=".session('HeaderSIA')."&app=".session('AppSIA');
        // $url= Response::DomainSIA."/cms-mahasiswa-mk-semester?h=".Response::HeaderSIA."&app=".Response::AppSIA;

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
        $kode_mahasiswa = Auth::user()->username;
        $postAr = array(
            'tahun_akademik' => $tahunAkademik,
            'semester'=>$semester,
            'tipe'=>$tipe,
        );
        if ($kode_mahasiswa !== "admin"){
            $postAr['kode_mahasiswa'] = $kode_mahasiswa;
        }else{
            $postAr['kode_mahasiswa'] = '0003117804';
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
            $footer ='';
  
            $qMK = Course::where(['idsemester' =>$sem->id, 'code_prodi' =>$data['data'][$i]['kode_prodi'], 'idnumber' => $data['data'][$i]['kode_prodi']. '-'.$tahunSingkat. '-'.$data['data'][$i]['kode_kurikulum'].'-'.$data['data'][$i]['kode_mk']])->first();
            $idEn =  Response::encrypt('0');
            if (isset($qMK->id_lms) >=1){
              // if (count($qMK) >=1){
              $disable = "";
              $idEn =  Response::encrypt($qMK->id_lms);
              $footer ='
              <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('masuk').'" target="_blank" class="btn btn-sm btn-success me-3" >Masuk</a>';
            }
            $html .='<div class="col-xl-12">
              <div class="card card-xl-stretch mb-xl-8 bg-light-warning rounded p-4 border-danger border border-dashed">
                <div class="card-header border-0 mb-3" style="min-height: auto; justify-content: start; z-index: 1;">
                  <div class=" m-2">
                    <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('nilai').'" target="_blank"  class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary '.$disable.'"  style="width: auto;">
                      <div class="badge badge-success p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-trophy-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Nilai  &nbsp;&nbsp; 
                      </div>
                    </a>
                  </div>
                  <div class=" m-2">
                    <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('file').'" target="_blank"  class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary '.$disable.'"  style="width: auto;">
                      <div class="badge badge-warning p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-archive-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Repositori  &nbsp;&nbsp; 
                      </div>
                    </a>
                  </div>
                  <div class=" m-2">
                    <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('calender').'" target="_blank"  class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary '.$disable.'"  style="width: auto;">
                      <div class="badge badge-danger p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-calendar-day-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Kalender  &nbsp;&nbsp; 
                      </div>
                    </a>
                  </div>
                  <div class=" m-2">
                    <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('badges').'" target="_blank"  class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary '.$disable.'"  style="width: auto;">
                      <div class="badge badge-secondary p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-ticket-perforated-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Lencana  &nbsp;&nbsp; 
                      </div>
                    </a>
                  </div>
                  <div class=" m-2">
                    <a href="sso-lms?id='.$idEn.'&type='.Response::encrypt('kompetensi').'" target="_blank"  class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary '.$disable.'"  style="width: auto;">
                      <div class="badge badge-primary p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-credit-card-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Kompetensi  &nbsp;&nbsp; 
                      </div>
                    </a>
                  </div>
                  <div class=" m-2">
                    <a href="#"  class="btn btn-sm btn-icon btn-color-light-dark btn-active-light-primary"  style="width: auto;" onclick="detailMK(\''.$data['data'][$i]['kode_kurikulum'].'\',\''.$data['data'][$i]['kode_mk'].'\')">
                      <div class="badge badge-info p-3" style="font-size: 11px;"> 
                        <span class="menu-icon">
                          <i class="bi bi-eye-fill fs-3" style="color: white"></i>
                        </span> &nbsp;&nbsp;Info Mata Kuliah  &nbsp;&nbsp; 
                      </div>
                    </a>
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
          );
        }
        
        // return $data['data'];
        return response()->json($result);
    }
    public function show($id)
    {
        //
    } 
}
