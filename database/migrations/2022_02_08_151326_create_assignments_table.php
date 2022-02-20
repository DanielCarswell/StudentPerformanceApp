<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_class_assignments', function (Blueprint $table) {
            $table->primary(["user_id", "class_id"]);
            $table->foreignId('user_id')->constrained('user_class')->onDelete('cascade');
            $table->foreignId('class_id')->constrained('user_class')->onDelete('cascade');
            $table->string('name');
            $table->integer('class_worth');
            $table->boolean('is_exam');
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
        Schema::dropIfExists('assignments');
    }
}
