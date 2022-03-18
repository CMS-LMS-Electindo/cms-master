<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('categoryid');
            $table->string('fullname');
            $table->string('shortname');
            $table->string('idnumber')->nullable();
            $table->string('idsemester');
            $table->string('code_prodi');
            $table->string('code_kur');
            $table->string('nidn')->nullable();
            $table->string('code_class')->nullable();
            $table->string('id_lms')->nullable(); // id dari LMS
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
        Schema::dropIfExists('courses');
    }
}
