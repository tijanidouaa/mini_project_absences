<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('nom_fr', 100);
            $table->string('prenom_fr', 100);
            $table->string('nom_ar', 100)->nullable();
            $table->string('prenom_ar', 100)->nullable();
            $table->string('massar', 20)->unique();
            $table->string('cin', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->foreignId('niveau_id')->nullable()->constrained('niveaux')->nullOnDelete();
            $table->string('cursus', 100)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('photo', 255)->default('default.png');
            $table->softDeletes(); // deleted_at — récupérable
            $table->timestamps()+1;
        });
    }
    public function down(): void { Schema::dropIfExists('etudiants'); }
};
