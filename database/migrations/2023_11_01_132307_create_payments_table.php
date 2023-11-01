<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up() : void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('owner_id')->constrained();
            $table->bigInteger('material')->default(0);
            $table->bigInteger('product')->default(0);
            $table->date('date');
            $table->longText('note')->nullable();
            $table->decimal('amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('payments');
    }
};
