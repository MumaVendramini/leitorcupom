<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToFacilitadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('facilitadors', function (Blueprint $table) {
            $table->string('telefone')->nullable()->after('email');
            $table->string('cpf')->nullable()->unique()->after('telefone');
            $table->string('cidade')->nullable()->after('cpf');
            $table->string('estado')->nullable()->after('cidade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('facilitadors', function (Blueprint $table) {
            $table->dropColumn(['telefone', 'cpf', 'cidade', 'estado']);
        });
    }
}
