<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('instruktur', function (Blueprint $table) {
            if (!Schema::hasColumn('instruktur', 'foto_profil')) {
                $table->text('foto_profil')->nullable();
            }
            if (!Schema::hasColumn('instruktur', 'sertifikat')) {
                $table->text('sertifikat')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('instruktur', function (Blueprint $table) {
            if (Schema::hasColumn('instruktur', 'foto_profil')) {
                $table->dropColumn('foto_profil');
            }
            if (Schema::hasColumn('instruktur', 'sertifikat')) {
                $table->dropColumn('sertifikat');
            }
        });
    }
};
