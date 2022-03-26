<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
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
            $data = MstUser::get();
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
                        $email = $list['kode_dosen']."@unm.ac.id"; 
                    }else{
                        $ema = explode("@",$email);
                        if ($ema[1] !== "unm.ac.id" || $ema[1] !== "gmail.com" || $ema[1] !== "yahoo.com" || $ema[1] !== "yahoo.co.id" || $ema[1] !== "rocketmail.com" || $ema[1] !== "yahoo.co.id"  )
                            $email = $list['kode_dosen']."@unm.ac.id"; 
                    }

                } else{
                        $email = $list['kode_dosen']."@unm.ac.id"; 
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
		$buatkategori = Response::DomainLMS . '/webservice/rest/server.php'.'?wstoken=' . Response::TokenLMS . '&moodlewsrestformat=json&wsfunction=core_user_create_users';

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
        $url= "http://apisia.unm.ac.id/cms-all-dosen?h=cms-apisia-4b72926408f7ggfa93946&app=cms-lms";

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
