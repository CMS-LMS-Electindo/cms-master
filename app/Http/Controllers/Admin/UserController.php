<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Dosen\EnrolController;
use App\Models\Config;
use App\Models\MstUser;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use curl;

class UserController extends Controller
{
    /** Sinkronisasi Dosen SIA
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // $fak = MstUser::where('parent', 0)->get();
            $data = MstUser::where('usertype', 'dosen')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $btn = '<div class="d-flex align-items-center">
                    <div class="d-flex justify-content-start flex-column">
                        <label class="text-dark fw-bolder text-hover-primary fs-6 align-items-center fw-bold mb-2">'.$row->fullname.'</label>
                        <span class="text-muted fw-bold text-muted d-block fs-7"><span class="badge badge-secondary fs-base mx-1">Id LMS : '.$row->id_lms.' </span><span class="badge badge-info fs-base mx-1">Username : '.$row->username.'</span></span>
                        </div>
                    </div>';
                    return $btn;
                })->addColumn('type', function ($row)  {
                    $btn = ' <label class="text-dark fw-bolder text-hover-primary fs-6 align-items-center fw-bold mb-2">'.$row->usertype.'</label>';
                    
                    return $btn;
                })
                ->rawColumns(['nama','type'])
                ->make(true);
        }
        $page = 'Data User ';
        $parent1 = 'Master Data ';
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
        return view('admin.user.default',$data);
    }
    public function SyncDosen(Request $request)
    {
        // Tambah User Dosen ke LMS 
        $dosenSIA = $this->getDosen();
        // return response()->json($dosenSIA);
        $qDosen = MstUser::where('usertype','dosen')->get();
        $domain = Config::where("active", 1)->first()->domain;
        $users = array();
        $dosenCMS = array();
        $i=0; 
        foreach ($dosenSIA as $list) {
            // get parent
            $ada = 0;
            // if ($i == 1)
            //     break;
            foreach ($qDosen as $listDosen ) {
                if ($list['kode_dosen'] == $listDosen->username){
                    $ada = 1;
                    break;
                }
            }
            if ($ada == 0){
                // Buat User
                $email = $list['email'] ;//== "-" ? $list['kode_dosen']."@unm.ac.id" : $list['email'];
                if(strpos($email, '@') && strpos($email, '.') ){
                    if (str_contains($email, 'example.com')) { 
                        $email = $list['kode_dosen']."@".$domain; 
                    }else{
                        $ema = explode("@",$email);
                        if ($ema[1] !== "unm.ac.id" || $ema[1] !== "gmail.com" || $ema[1] !== "yahoo.com" || $ema[1] !== "yahoo.co.id" || $ema[1] !== "rocketmail.com" || $ema[1] !== $domain  )
                            $email = $list['kode_dosen']."@".$domain; 
                    }

                } else{
                        $email = $list['kode_dosen']."@".$domain; 
                }
                $users = array(
                    'username'=> strtolower( $list['kode_dosen']),
                    'firstname'=>$list['kode_dosen'],
                    'lastname'=>$list['nama_dosen'],
                    'email'=> strtolower($email),
                    'department'=>$list['kode_prodi'],
                    'institution'=>$list['kode_fakultas'],
                    'description'=>"dosen",
                    'password' => 'DSN'.$list['kode_dosen'],
                );
                $users1[] = $users;
                $dosenCMS[] = $users;
                $i++;
                
                // 'username'=>$list['kode_dosen'],
                // 'firstname'=>$list['kode_dosen'],
                // 'lastname'=>$list['nama_dosen'],
                // 'email'=> $email,
                // 'department'=>$list['kode_prodi'],
                // 'unit'=>$list['kode_fakultas'],
                // 'description'=>"dosen",
                // 'password' => 'DSN'.$list['kode_dosen'],
            }
        }
		$data = array('users' => $users1);
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
            return response()->json($return);
        }else{
            foreach ($data1 as $list) {
                // Insert Dosen
                $data2 = array(
                    'usertype' => 'dosen',
                    'username' => $dosenCMS[$i]['username'],
                    'fullname'=> $dosenCMS[$i]['lastname'],
                    'code_prodi'=> $dosenCMS[$i]['department'],
                    'code_fakultas'=> $dosenCMS[$i]['institution'],
                    'id_lms' =>$list['id'],
                );
                $insert = MstUser::create($data2);
                $i++;
            }
            $return = array(
                'status'    => 1,
                'message'    => "Data Dosen Berhasil ditambahkan",
                'data'    => $data1,
            );
        }
        return response()->json($return);

    }
    
    function getDosen()
    {
        $curl = curl_init();
        $url ='';
        $postAr = [];
        $url= session('DomainSIA')."/cms-all-dosen?h=".session('HeaderSIA')."&app=".session('AppSIA')."";

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
    public function GetDosen1(Request $request)
    {
        $jml = $request->jumlah;
        $curl = curl_init();
        $url ='';
        $postAr = [];
        $url= session('DomainSIA')."/cms-all-dosen?h=".session('HeaderSIA')."&app=".session('AppSIA')."";

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
        // return $data['data'];

        $dosen = array();
        $qDosen = MstUser::where('usertype', 'dosen')->get();
        $b= 0;
        $no= 0;
        // return response()->json($data['data']);
        $html='';
        for ($i=0; $i < count($data['data']); $i++) { 
            $a= 0;
            foreach ($qDosen as $list ) {
                if ($data['data'][$i]['kode_dosen'] == $list->username){
                    $a = 1;
                    break;
                }
            }
            if ($a == 1){
                continue;
            }else{
                $dosen[] = $data['data'][$i];
                $no++;
                $html.='<tr>
                <td>
                  <div class="d-flex justify-content-start flex-column">
                    <span class="text-dark fw-bolder text-hover-primary fs-6">'.$no.'</span>
                  </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="d-flex justify-content-start flex-column">
                            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">'.$data['data'][$i]['nama_dosen'].'</a>
                            <span class="text-muted fw-bold text-muted d-block fs-7">'.$data['data'][$i]['kode_dosen'].'</span>
                        </div>
                    </div>
                </td>
                <td>
                    <a href="#" class="text-dark fw-bolder text-hover-primary d-block fs-6">'.$data['data'][$i]['nama_prodi'].'</a>
                    <span class="text-muted fw-bold text-muted d-block fs-7">'.$data['data'][$i]['nama_fakultas'].'</span>
                </td>
                <td >
                    <div class="d-flex flex-column w-100 me-2">
                      <span class="text-muted fw-bold text-muted d-block fs-7">'.$data['data'][$i]['email'].'</span>
                    </div>
                </td>
                <td class="text-center">
                  <span class="badge badge-light-primary fs-8 fw-bolder" id="status'.$b.'">Menunggu Proses</span>
                </td>
              </tr>';
              $b++;
            }
            if ($b == $jml)
                break;
        }
        $return = array(
            'status'    => 1,
            'progress'    => 10,
            'message'    => "Data Dosen Berhasil diambil",
            'data'    => $dosen,
            'html'    => $html,
        );
        return response()->json($return);
    }
    public function CreateUserLms(Request $request)
    {
        // Response progress
        $progress = 0;
        $jml = $request->jumlah;
        $id = $request->id;
        $next = $id + 1;
        if ($next == $jml) 
            $progress = 100;
        else 
            $progress = round((($next / $jml ) * 90) + 10);

        $kodeUser = $request->data[$id]['kode_dosen'];
        $namaUser = $request->data[$id]['nama_dosen'];
        $kode_prodi = $request->data[$id]['kode_prodi'];
        $kode_fakultas = $request->data[$id]['kode_fakultas'];
        $email = $request->data[$id]['email'];
        $domain = Config::where("active", 1)->first()->domain_pt;

        $buatUser = EnrolController::SyncUser($kodeUser, $namaUser, $kode_prodi, $kode_fakultas,$email, 'dosen', $domain,"DSN");

        $return = array(
            'progress'    => $progress ,
            // 'data'    => $request->data,
            'next'    => $next,
            'id'    => $id,
            'data'    => $buatUser,
        );
        if (isset($buatUser[0]['id'])){
            $return['status'] = 1;
            $return['message'] = "Data Dosen Berhasil Disinkronisasi";
        }else{
            $return['status'] = 0;
            $return['message'] = "Terdapat Data Dosen Gagal Disinkronisasi";
        }
        return response()->json($return);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
