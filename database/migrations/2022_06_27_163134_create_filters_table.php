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
        Schema::create('filters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->string('column',255)->nullable();
            $table->string('operador',255)->nullable();
            $table->string('type',255)->nullable();
            $table->text('value')->nullable();
            $table->boolean('nulo')->nullable();
            $table->integer('ordering')->nullable();
            $table->foreignUuid('report_id')->nullable()->constrained('reports')->cascadeOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->cascadeOnDelete();   
            $table->string('status_id')->nullable()->comment("Situação")->default('published');
            if (Schema::hasTable('tenants')) {           
                $table->foreignUuid('tenant_id')->nullable()->constrained('tenants')->cascadeOnDelete();
            }
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
        Schema::dropIfExists('filters');
    }
};
