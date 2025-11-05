<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaFiscalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_fiscals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade');
            $table->string('chave_acesso', 44)->unique(); // Chave de acesso da NF-e
            $table->string('cnpj', 14);
            $table->date('data_emissao');
            $table->decimal('valor', 10, 2);
            $table->string('cidade', 100);
            $table->integer('ano');
            $table->integer('mes');
            $table->string('modelo', 10);
            $table->string('numero_nf', 20);
            $table->string('serie', 10)->nullable();
            $table->string('sat', 50)->nullable();
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
        Schema::dropIfExists('nota_fiscals');
    }
}
