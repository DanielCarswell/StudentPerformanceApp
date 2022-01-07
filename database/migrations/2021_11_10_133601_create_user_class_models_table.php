<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserClassModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_class_models', function (Blueprint $table) {
            $table->primary(["user_id", "class_models_id"]);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('class_models_id')->constrained('class_models')->onDelete('cascade');
            $table->double('grade');
            $table->double('attendance');
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
        Schema::dropIfExists('user_class_models');
    }
}
