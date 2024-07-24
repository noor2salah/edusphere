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
        Schema::table('about_wallets', function (Blueprint $table) {
            $table->unsignedBigInteger('fee_id')->nullable();
            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('cascade');
           
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_wallet', function (Blueprint $table) {
            //
        });
    }
};
