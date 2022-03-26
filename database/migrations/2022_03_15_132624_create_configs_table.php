<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('code_pt')->unique();
            $table->string('nama_pt');
            $table->string('nama_app');
            $table->string('domain_pt');
            $table->string('email_pt')->nullable();
            $table->string('desc')->nullable();
            $table->string('add_course')->nullable(); //Config Penambahan MK Type 1,2,3
            $table->string('req_course')->nullable(); //Config Jenis Pembuatan MK Buat langsung atau paksa buat dgn rppe
            $table->string('active')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
