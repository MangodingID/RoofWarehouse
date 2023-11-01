<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up() : void
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->date('date');
            $table->integer('amount')->default(0);
            $table->foreignUlid('owner_id')->constrained();
            $table->foreignUlid('warehouse_id')->constrained();
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('productions');
    }
};
