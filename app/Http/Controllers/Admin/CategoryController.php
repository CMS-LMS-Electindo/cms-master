<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Category;
use curl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $fak = Category::where('parent', 0)->get();
            $data = Category::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('nama', function ($row) {
                    $btn = '<div class="d-flex align-items-center">
                    <div class="d-flex justify-content-start flex-column">
                        <label class="text-dark fw-bolder text-hover-primary fs-6 align-items-center fw-bold mb-2">'.$row->name.'</label>
                        <span class="text-muted fw-bold text-muted d-block fs-7"><span class="badge badge-secondary fs-base mx-1">Id SIA : '.$row->code_sia.' </span><span class="badge badge-info fs-base mx-1">ID LMS : '.$row->code_lms.'</span></span>
                        </div>
                    </div>';
                    return $btn;
                })->addColumn('parent1', function ($row) use ($fak) {
                    $btn = "";
                    if ($row->parent != 0){
                        $parent = "";
                        foreach ($fak as $list ) {
                            if ($list->id == $row->parent)
                                $parent = $list->name;
                        }
                        $btn = '<div class="d-flex align-items-center">
                            <div class="d-flex justify-content-start flex-column">
                                <span class="badge badge-success fs-base mb-1">'.$parent.'</span>
                            </div>
                        </div>';
                    }
                    return $btn;
                })
                ->rawColumns(['nama','parent1'])
                ->make(true);
        }
        $page = 'Data Kategori ';
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
        return view('admin.category.default',$data);
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
    public function SyncCategoryFakultas(Request $request)
    {
        // Add Fakultas Category
        // Tambah Kategori Category ke LMS
        $fakultas = $this->getFakultas();
        $categoryCMS = array();
        $categories = array();
        $i=0;
        foreach ($fakultas['data'] as $list) {
            $category = array(
                'name'=>$list['nama_fakultas'],
                'idnumber'=>$list['kode_fakultas'],
                'parent'=>0,
                'description' => ''    ,            
                'descriptionformat' => 1  ,              
            );
            $categories[] = $category;
            $categoryCMS[] = $category;
            $i++;
        }
		$data = array('categories' => $categories);

        header('Content-Type: text/plain');
		$buatkategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_course_create_categories';

		$curl = new curl;
		$injek = $curl->post($buatkategori, $data);
        $data1 = json_decode($injek, TRUE);
        // Tambah kategori ke db cms
        $i = 0;
        if (isset($data1['message'])){
            $return = array(
                   'status'    => false,
                   'message'    => $data1['message'],
                   'data'    => $data1,
               );
            return response()->json($return);
        }else{
            foreach ($data1 as $list) {
                $data2 = array(
                    'code_sia'=> $fakultas['data'][$i]['kode_fakultas'],
                    'name' =>$list['name'],
                    'parent' =>0,
                    'code_lms' =>$list['id']
                );
                $insert = Category::create($data2);
                $i++;
            }
            $return = array(
                'status'    => 1,
                'message'    => "Data Kategori Berhasil ditambahkan",
                'data'    => $data1,
            );
        }
        // Add Prodi Category
        //$prodi = $this->getProdi();

        return response()->json($return);

    }
    public function SyncCategoryProdi(Request $request)
    {
        // Add Prodi Category
        // get data fakultas sebagai parent
        $fakultas = Category::where('parent', 0)->get();
       
        // Tambah Kategori Prodi ke LMS
        $prodi = $this->getProdi();
        $categories = array();
        $i=0; 
        foreach ($prodi['data'] as $list) {
            // get parent
            $parent = 0;
            foreach ($fakultas as $listFakultas ) {
                if ($listFakultas->code_sia == $list['kode_fakultas']){
                    $parent = $listFakultas->code_lms;
                    break;
                }
            }

            $category = array(
                'name'=>$list['nama_prodi'],
                'idnumber'=>$list['kode_prodi'],
                'parent'=>$parent,
                'description' => ''    ,            
                'descriptionformat' => 1  ,              
            );
            $categories[] = $category;
            $i++;
        }
		$data = array('categories' => $categories);

        header('Content-Type: text/plain');
		$buatkategori = session('DomainLMS') . '/webservice/rest/server.php'.'?wstoken=' . session('TokenLMS') . '&moodlewsrestformat=json&wsfunction=core_course_create_categories';

		$curl = new curl;
		$injek = $curl->post($buatkategori, $data);
        $data1 = json_decode($injek, TRUE);
        // Tambah kategori ke db cms
        $i = 0;
        if (isset($data1['message'])){
            $return = array(
                   'status'    => false,
                   'message'    => $data1['message'],
                   'data'    => $data1,
               );
            return response()->json($return);
        }else{
            foreach ($data1 as $list) {
                // get parent
                $parent = 0;
                foreach ($fakultas as $listFakultas ) {
                    if ($listFakultas->code_sia == $prodi['data'][$i]['kode_fakultas']){
                        $parent = $listFakultas->id;
                        break;
                    }
                }
                $data2 = array(
                    'code_sia'=> $prodi['data'][$i]['kode_prodi'],
                    'name' =>$list['name'],
                    'parent' =>$parent,
                    'code_lms' =>$list['id']
                );
                $insert = Category::create($data2);
                $i++;
            }
            $return = array(
                'status'    => 1,
                'message'    => "Data Kategori Berhasil ditambahkan",
                'data'    => $data1,
            );
        }
        return response()->json($return);

    }
    function getFakultas()
    {
        $curl = curl_init();
        $url ='';
        $postAr = [];
        $url= session('DomainSIA')."/cms-all-fakultas?h=".session('HeaderSIA')."&app=".session('AppSIA')."";

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
        return $data;
    }
    
    function getProdi()
    {
        $curl = curl_init();
        $url ='';
        $postAr = [];
        $url= session('DomainSIA')."/cms-all-prodi?h=".session('HeaderSIA')."&app=".session('AppSIA')."";

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
        // print_r($data);
        // return response()->json($data);
        return $data;
    }
    public function store(Request $request)
    {
       // dd($request->appName);
        if ($request->kode != null)
            $request->validate([
                'appName' =>  'required',
                'ptName' =>  'required',
                'ptCode' =>  'required',
                'ptDomain' =>  'required',
                'ptEmail' =>  'required',
                // 'Category_type' =>  'required',
                'Category_req' =>  'required',
                // 'file' => 'required|mimes:jpeg,jpg,png,mp4|max:2048',
            ]);
       else
            $request->validate([
                'appName' =>  'required',
                'ptName' =>  'required',
                'ptCode' =>  'required',
                'ptDomain' =>  'required',
                'ptEmail' =>  'required',
                // 'Category_type' =>  'required',
                'Category_req' =>  'required',
            ]);
        $data = array(
            'nama_app' =>  $request->appName,
            'nama_pt' =>  $request->ptName,
            'code_pt' =>  $request->ptCode,
            'domain_pt' =>  $request->ptDomain,
            'email_pt' =>  $request->ptEmail,
            // 'add_course' =>  $request->Category_type,
            'req_course' =>  $request->Category_req,
            'desc' =>  $request->desc,
        );
       if ($request->kode != null){
           Category::where('id', $request->kode)
               ->update($data);
       }else{
            $data['active'] =0;
            Category::create($data);
       }
       $return = array(
        //    'file'    => $media,
           'status'    => true,
           'message'    => 'Data berhasil disimpan..',
       );

       return response()->json($return);
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
       $unit = Category::where("id",$id)->first();
       return response()->json($unit);
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
        $deleted = Category::where('id', $id)->delete();
        if ($deleted) {
            $return = array(
                'status' => true,
                'message' => 'Data berhasil dihapus..'
            );
        } else {
            $return = array(
                'status' => false,
                'message' => 'Gagal dihapus..'
            );
        }
 
        return response()->json($return);
    }
}