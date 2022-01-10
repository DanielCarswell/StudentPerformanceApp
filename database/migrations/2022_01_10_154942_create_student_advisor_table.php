<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentAdvisorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_advisor', function (Blueprint $table) {
            $table->primary(["user_id", "advisor_id"]);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('advisor_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_advisor');
    }
}
