<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('detail_transaksis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('transaksi_id')->constrained()->cascadeOnDelete();
    $table->foreignId('produk_id')->constrained()->cascadeOnDelete();
    $table->integer('jumlah');
    $table->integer('subtotal');
    $table->boolean('is_deduction')->default(false);
    $table->timestamps();
});

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksis');
    }
};
