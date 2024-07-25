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
        //
        Schema::table('resources', function(Blueprint $table) {
            $table->json('template')->nullable();
            $table->string('form_fields')->nullable();
            $table->string('api_fields')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('resources', function (Blueprint $table) {
            $table->dropColumn('template');
            $table->dropColumn('form_fields');
            $table->dropColumn('api_fields');
        });
    }
};
