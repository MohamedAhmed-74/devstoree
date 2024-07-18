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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->decimal('price', 10, 2);
            $table->string('file', 225);
            $table->longText('description');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Ensuring the constraint references 'users'
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Ensuring the constraint references 'categories'
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
