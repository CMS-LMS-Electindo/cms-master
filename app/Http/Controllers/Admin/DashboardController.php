<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Lainnya;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $page = 'Dashboard ';
        // $parent1 = 'Master Data ';
        $data['page'] = $page;
        $data['toolBarDesc'] = "";

        Lainnya::setSessionToken();
        return view('admin/dashboard', $data);
    }
}
