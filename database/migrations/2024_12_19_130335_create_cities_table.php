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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('lat')->nullable();
            $table->float('lon')->nullable();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('city');
        });

        Schema::create('user_city', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained();
            $table->foreignId('city_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_city', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['city_id']);
        });

        Schema::dropIfExists('user_city');

        Schema::table('users', function (Blueprint $table) {
            $table->string('city');
        });

        Schema::dropIfExists('cities');
    }
};
