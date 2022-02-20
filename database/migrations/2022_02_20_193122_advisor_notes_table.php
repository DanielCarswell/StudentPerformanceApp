<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdvisorNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_advisor_notes', function (Blueprint $table) {
            $table->primary(["student_id", "advisor_id"]);
            $table->foreignId('student_id')->constrained('student_advisor')->onDelete('cascade');
            $table->foreignId('advisor_id')->constrained('student_advisor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_advisor_notes');
    }
}
