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
        Schema::create('materials', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('owner_id')->constrained();
            $table->foreignUlid('warehouse_id')->constrained();
            $table->bigInteger('amount')->default(0);
            $table->date('date');
            $table->longText('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down() : void
    {
        Schema::dropIfExists('materials');
    }
};
