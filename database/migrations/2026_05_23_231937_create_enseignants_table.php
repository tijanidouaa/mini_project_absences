<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->string('nom_fr', 100);
            $table->string('prenom_fr', 100);
            $table->string('nom_ar', 100)->nullable();
            $table->string('prenom_ar', 100)->nullable();
            $table->string('cin', 20)->unique();
            $table->string('email', 100)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
