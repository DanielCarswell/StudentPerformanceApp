<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCircumstanceLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('circumstance_links', function (Blueprint $table) {
            $table->primary(["circumstance_id", "link"]);
            $table->foreignId('circumstance_id')->constrained('circumstances')->onDelete('cascade');
            $table->string('link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('circumstance_links');
    }
}
