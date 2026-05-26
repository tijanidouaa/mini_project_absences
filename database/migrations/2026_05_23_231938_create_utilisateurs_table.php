<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // On remplace la table users par défaut de Laravel
        Schema::dropIfExists('users');

        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('login', 100)->unique();
            $table->string('password');
            $table->enum('role', ['etudiant', 'enseignant', 'administrateur']);
            $table->unsignedBigInteger('personne_id')->default(0); // ref etudiant ou enseignant
            $table->boolean('enabled')->default(true);
            $table->boolean('locked')->default(false);
            $table->unsignedInteger('tentatives')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('utilisateurs'); }
};
