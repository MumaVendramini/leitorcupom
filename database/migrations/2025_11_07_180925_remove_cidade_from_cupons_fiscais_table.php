<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveCidadeFromCuponsFiscaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cupons_fiscais', function (Blueprint $table) {
            $table->dropColumn('cidade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cupons_fiscais', function (Blueprint $table) {
            $table->string('cidade', 100)->nullable();
        });
    }
}
