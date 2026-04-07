<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Afegir camps a la taula 'premis'
        if (!Schema::hasColumn('premis', 'categoria')) {
            Schema::table('premis', function (Blueprint $table) {
                $table->string('categoria')->nullable()->default('accessories')->after('descripcio');
                $table->integer('stock')->nullable()->default(10)->after('categoria');
                $table->string('temps_enviament')->nullable()->default('3-5 dies')->after('stock');
                $table->decimal('rating', 3, 2)->nullable()->default(4.5)->after('temps_enviament');
            });
        }

        // Asegurar que 'opinions' té el camp user_id si manqua
        if (!Schema::hasColumn('opinions', 'user_id')) {
            Schema::table('opinions', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
        }

        // Asegurar que 'opinions' té el camp 'producte_id' o similar per a relació
        if (!Schema::hasColumn('opinions', 'producte_id')) {
            Schema::table('opinions', function (Blueprint $table) {
                $table->integer('producte_id')->nullable()->after('user_id');
            });
        }

        // Asegurar que 'opinions' té timestamps correctes
        if (!Schema::hasColumn('opinions', 'updated_at')) {
            Schema::table('opinions', function (Blueprint $table) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('premis', 'categoria')) {
            Schema::table('premis', function (Blueprint $table) {
                $table->dropColumn(['categoria', 'stock', 'temps_enviament', 'rating']);
            });
        }

        if (Schema::hasColumn('opinions', 'user_id')) {
            Schema::table('opinions', function (Blueprint $table) {
                $table->dropColumn(['user_id', 'producte_id', 'updated_at']);
            });
        }
    }
};
