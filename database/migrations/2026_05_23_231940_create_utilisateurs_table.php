<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id();
            $table->string('login', 100)->unique();
            $table->string('password_hash', 255);
            $table->enum('role', ['etudiant', 'enseignant', 'administrateur']);
            $table->unsignedBigInteger('personne_id');
            $table->tinyInteger('enabled')->default(1);
            $table->tinyInteger('locked')->default(0);
            $table->integer('tentatives')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('utilisateurs');
    }
};