<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Tanggal;
use App\Models\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Config::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (Auth::user()->role_id == 1){
                        $btn = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button  onclick="edit(\''. $row->id . '\'); return false;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" title="Edit Data">
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="black" />
                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="black" />
                                    </svg>
                                </span>
                            </button>
                            <button onclick="hapus(\'' . $row->id . '\');return false;" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" title="Hapus Data">
                                <span class="svg-icon svg-icon-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="black" />
                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="black" />
                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="black" />
                                    </svg>
                                </span>
                            </button>
                        </div>';
                    }
                    return $btn;
                })->addColumn('config', function ($row) {
                    
                    $btn = '<span class="badge badge-light-danger fw-bold me-1"> Tipe : '.$row->add_course.'</span>    <span class="badge badge-light-info fw-bold me-1"> Tipe Pembuatan : '.$row->req_course.'</span>';
                    return $btn;
                })->addColumn('aktif', function ($row) {
                    if ($row->active == 1){
                        $btn = '<span class="badge badge-secondary fs-base"> Aktif </span>';
                    }else{
                        $btn = '<label class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" value="'.$row->id.'" title="Aktifkan?" onclick="aktifkan(\''.$row->id.'\')" />
                      </label>';

                    }

                    return $btn;
                })->addColumn('nama', function ($row) {
                    $btn = '<div class="d-flex align-items-center">
                    <div class="d-flex justify-content-start flex-column">
                        <label class="text-dark fw-bolder text-hover-primary fs-6 align-items-center fw-bold mb-2">'.$row->nama_app.' <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip" title="'.$row->desc.'"></i></label>
                       
                        <span class="text-muted fw-bold text-muted d-block fs-7">'.$row->code_pt.' - '.$row->nama_pt.'</span>
                        </div>
                    </div>';
                    return $btn;
                })->addColumn('domain', function ($row) {
                    $btn = '<div class="d-flex align-items-center">
                    <div class="d-flex justify-content-start flex-column">
                            <span class="text-muted fw-bold text-muted d-block fs-7">'.$row->domain_pt.'</span>
                            <span class="text-muted fw-bold text-muted d-block fs-7">'.$row->email_pt.'</span>
                        </div>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action','nama','config','aktif','domain'])
                ->make(true);
        }
        $page = 'Data Config ';
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
        return view('admin.config.default',$data);
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
       // dd($request->appName);
        if ($request->kode != null)
            $request->validate([
                'appName' =>  'required',
                'ptName' =>  'required',
                'ptCode' =>  'required',
                'ptDomain' =>  'required',
                'ptEmail' =>  'required',
                // 'config_type' =>  'required',
                'config_req' =>  'required',
                // 'file' => 'required|mimes:jpeg,jpg,png,mp4|max:2048',
            ]);
       else
            $request->validate([
                'appName' =>  'required',
                'ptName' =>  'required',
                'ptCode' =>  'required',
                'ptDomain' =>  'required',
                'ptEmail' =>  'required',
                // 'config_type' =>  'required',
                'config_req' =>  'required',
            ]);
        $data = array(
            'nama_app' =>  $request->appName,
            'nama_pt' =>  $request->ptName,
            'code_pt' =>  $request->ptCode,
            'domain_pt' =>  $request->ptDomain,
            'domain_lms'=>  $request->lmsDomain,
            'domain_api'=>  $request->apiDomain,
            'email_pt' =>  $request->ptEmail,
            'token_lms'=>  $request->token_lms,
            'token_auth'=>  $request->token_auth,
            'token_sia'=>  $request->token_sia,
            'app_sia'=>  $request->keyApiSia,
            // 'add_course' =>  $request->config_type,
            'req_course' =>  $request->config_req,
            'desc' =>  $request->desc,
        );
        if (!empty($_FILES['logo']['name'])) {
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filenameLogo = 'logo'."_" . time() . '.' . $extension;
            $file->move('assets/media/logos/', $filenameLogo);
            $data['logo']= $filenameLogo;
        }
        if (!empty($_FILES['logo_gelap']['name'])) {
            $file = $request->file('logo_gelap');
            $extension = $file->getClientOriginalExtension();
            $filenameLogoGelap = 'logo_gelap'."_" . time() . '.' . $extension;
            $file->move('assets/media/logos/', $filenameLogoGelap);
            $data['logo_gelap']= $filenameLogoGelap;
        }
        if (!empty($_FILES['logo_terang']['name'])) {
            $file = $request->file('logo_terang');
            $extension = $file->getClientOriginalExtension();
            $filenameLogoTerang = 'logo_terang'."_" . time() . '.' . $extension;
            $file->move('assets/media/logos/', $filenameLogoTerang);
            $data['logo_terang']= $filenameLogoTerang;
        }
      
       if ($request->kode != null){
           Config::where('id', $request->kode)
               ->update($data);
       }else{
            $data['active'] =0;
            Config::create($data);
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
       $unit = Config::where("id",$id)->first();
       return response()->json($unit);
    }
    public function ConfigAktif(Request $request)
    {
        if ( $request->id == null){
            $return = array(
                'status' => false,
                'message' => 'Gagal diaktifkan..'
            );
            return response()->json($return);
        }
        $data['active'] = 0;
        Config::query()->update($data);
        $data1['active'] = 1;
        $updated = Config::where('id', $request->id)
            ->update($data1);
        if ($updated) {
            $return = array(
                'status' => true,
                'message' => 'Data berhasil diaktifkan..'
            );
        } else {
            $return = array(
                'status' => false,
                'message' => 'Gagal diaktifkan..'
            );
        }
 
        return response()->json($return);
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
        $deleted = Config::where('id', $id)->delete();
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
