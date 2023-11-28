<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sepay_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('gateway');
            $table->string('transactionDate');
            $table->string('accountNumber');
            $table->string('subAccount')->nullable();
            $table->string('code')->nullable();
            $table->string('content');
            $table->string('transferType');
            $table->string('description', 1000)->nullable();
            $table->bigInteger('transferAmount');
            $table->string('referenceCode')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sepay_transactions');
    }
};
