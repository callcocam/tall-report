<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('font_name',50)->default('Arial')->nullable();
            $table->string('font_style',50)->nullable();
            $table->integer('font_size')->default(12)->nullable();
            $table->string('font_color',30)->default("000000")->nullable();
            $table->boolean('bold')->nullable();
            $table->boolean('italic')->nullable();
            $table->boolean('underline')->nullable();
            $table->boolean('strikethrough')->nullable();
            $table->string('background_color',50)->nullable();
            $table->string('alignment',50)->default('center')->nullable();
            $table->string('vertical_alignment',20)->default('auto')->nullable();
            $table->boolean('wrap_text')->nullable()->default(true);
            $table->uuidMorphs('attributeable');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
};
