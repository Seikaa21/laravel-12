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
    Schema::table('users', function (Blueprint $table) {
        $table->boolean('can_access_konten')->default(false);
        $table->boolean('can_access_kategori')->default(false);
        $table->boolean('can_access_profil')->default(false);
    });
}


public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['can_access_konten', 'can_access_kategori', 'can_access_profil']);
    });
}
};
