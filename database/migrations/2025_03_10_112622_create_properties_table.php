<?php

use App\Category;
use App\Product;
use App\Property;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('unit');
            $table->integer('sort')->unsigned()->default(10);
        });

        Schema::create('product_property', function (Blueprint $table) {
            $table->foreignIdFor(Product::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(Property::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->string('value');

            $table->primary(['product_id', 'property_id']);
        });

        Schema::create('category_property', function (Blueprint $table) {
            $table->foreignIdFor(Category::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignIdFor(Property::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->integer('sort')->unsigned()->default(10);

            $table->primary(['category_id', 'property_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_property');
        Schema::dropIfExists('product_property');
        Schema::dropIfExists('properties');
    }
};
