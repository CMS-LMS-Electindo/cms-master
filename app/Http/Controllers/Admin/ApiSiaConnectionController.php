<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class ApiSiaConnectionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = 'Koneksi API SIA ';
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
        return view('admin.api.sia',$data);
    }
    public function ApiConnection(Request $request)
    {
        $curl = curl_init();
        $url ='';
        $postAr = [];
        if ($request->type == "fakultas"){
            $url= "http://apisia.unm.ac.id/cms-all-fakultas?h=cms-apisia-4b72926408f7ggfa93946&app=cms-lms";
        }elseif ($request->type == "prodi"){
            $url= "http://apisia.unm.ac.id/cms-all-prodi?h=cms-apisia-4b72926408f7ggfa93946&app=cms-lms";
        }elseif ($request->type == "mk-semster"){
            $url= "http://apisia.unm.ac.id/cms-mk-semester?h=cms-apisia-4b72926408f7ggfa93946&app=cms-lms";
            $sem = Semester::where('active', 1)->first();
            $semName = $sem->name;
            $thn = substr($semName, 0,4);
            $tahunAkademik = $thn."-". (int)$thn + 1;
            $semester = substr($semName, -1);
            $postAr = array('tahun_akademik' => $tahunAkademik,'semester'=>$semester);
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

        $response = curl_exec($curl);
        $data = json_decode($response, TRUE);
        // $data = $response;
        curl_close($curl);
        // print_r($data);
        return response()->json($data);
    }

}
