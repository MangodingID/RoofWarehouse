<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->bigInteger('amount')->default(0);
            $table->decimal('price', 10, 2)->default(0);
            $table->date('date');
            $table->foreignUlid('warehouse_id')->constrained();
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('transactions');
    }
};
