<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('nota_fiscals', function (Blueprint $table) {
            $table->string('uf', 2)->nullable()->after('cidade');
            $table->string('codigo_num', 9)->nullable()->after('numero_nf');
            $table->string('dv', 1)->nullable()->after('codigo_num');
        });
    }

    public function down(): void
    {
        Schema::table('nota_fiscals', function (Blueprint $table) {
            $table->dropColumn(['uf','codigo_num','dv']);
        });
    }
};
