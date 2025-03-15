<?php

use App\Models\BikeModel;
use App\Models\User;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->foreignIdFor(BikeModel::class)->constrained();
            $table->string('model_number');
            $table->string('type');
            $table->string('size');
            $table->string('color');
            $table->float('price', 12, 3)->nullable();
            $table->integer('warranty_duration');
            $table->string('status');
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
