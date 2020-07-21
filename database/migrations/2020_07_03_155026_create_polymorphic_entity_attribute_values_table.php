<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePolymorphicEntityAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('laravel-polymorphic-eav.attribute-table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('type')->nullable();
            $table->timestamps();
        });

        Schema::create(config('laravel-polymorphic-eav.value-table'), function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('attributable_id');
            $table->string('attributable_type');
            $table->unsignedInteger('entity_attribute_id');
            $table->string('value')->nullable();
            $table->timestamps();

            $table->index(['attributable_id', 'attributable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('laravel-polymorphic-eav.attribute-table'));
        Schema::dropIfExists(config('laravel-polymorphic-eav.value-table'));
    }
}
