<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create();
        DB::table('roles')->insert([
            'name_role' => "admin",
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
        DB::table('roles')->insert([
            'name_role' => "operator",
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
            ]);
        DB::table('roles')->insert([
            'name_role' => "dosen",
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
        DB::table('roles')->insert([
            'name_role' => "mahasiswa",
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
        DB::table('users')->insert([
            'name' => "admin",
            'username' => "admin",
            'role_id' => "1",
            'password' => Hash::make('admin'),
            'email' => "admin@unm.ac.id",
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
        
        DB::table('versions')->insert([
            'version_name' => "1.0",
            'version_number' => "1",
            'active' => "1",
            'desc' => "First Version",
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
        
        DB::table('configs')->insert([
            'code_pt'  => "001036",
            'nama_app'  => "Course Management System (CMS)",
            'nama_pt'  => "Universitas Negeri Makassar",
            'domain_pt'  => "unm.ac.id",
            'domain_lms'  => "https://lms.syam-ok.unm.ac.id",
            'domain_api'  => "http://apisia.unm.ac.id",
            'email_pt'  => "cms@unm.ac.id",
            'add_course'  => "1",
            'req_course'  => "Buat Otomatis",
            'active'  => "1",
            'desc'  => "CMS merupakan ...",
            'token_lms'  => "",
            'token_auth'  => "",
            'token_sia'  => "",
            'app_sia'  => "",
            'logo'  => "logo.png",
            'logo_gelap'  => "logo_gelap.png",
            'logo_terang'  => "logo_terang.png",
            'created_at' => date("Y-m-d h:i:s"),
            'updated_at' => date("Y-m-d h:i:s"),
        ]);
    }
}
