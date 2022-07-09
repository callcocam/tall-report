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
        Schema::create('relationships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->integer('ordering')->nullable();
            $table->longtext('content')->nullable();
            $table->string('status_id')->nullable()->comment("Situação")->default('published');
            if (Schema::hasTable('tenants')) {           
                $table->foreignUuid('tenant_id')->nullable()->constrained('tenants')->cascadeOnDelete();
            }
            $table->foreignUuid('column_id')->nullable()->constrained('columns')->cascadeOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->cascadeOnDelete();
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
        Schema::dropIfExists('relationships');
    }
};
