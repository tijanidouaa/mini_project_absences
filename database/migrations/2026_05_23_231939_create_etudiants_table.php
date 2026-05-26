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
            $table->string('nom_ar', 100);
            $table->string('prenom_ar', 100);
            $table->string('massar', 20)->unique();
            $table->string('cin', 20);
            $table->string('email', 100);
            $table->unsignedBigInteger('niveau_id')->nullable();
            $table->string('cursus', 100);
            $table->string('telephone', 20);
            $table->date('date_naissance');
            $table->string('photo', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('etudiants');
    }
};