<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id("departement_id");
            $table->string("departement_code", 20);
            $table->string("departement_name", 100);
            $table->bigInteger("parent_departement_id")->nullable()->comment("foreign key table ms_departement field departement_id");
            $table->bigInteger("position_id")->nullable()->comment("foreign key table ms_position field position_id");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departments');
    }
}
