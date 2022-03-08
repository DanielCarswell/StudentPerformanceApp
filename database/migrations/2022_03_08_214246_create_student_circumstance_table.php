<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentCircumstanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_circumstance', function (Blueprint $table) {
            $table->primary(["circumstance_id", "student_id"]);
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('circumstance_id')->constrained('circumstances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_circumstance');
    }
}
