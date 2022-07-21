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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->string('model',255)->nullable();          
            $table->string('freeze_column',10)->nullable();          
            $table->integer('freeze_row')->nullable();          
            $table->integer('zoom_scale')->nullable();          
            $table->integer('views')->nullable();
            $table->text('content')->nullable();       
            $table->string('status_id')->nullable()->comment("Situação")->default('published');
            if (Schema::hasTable('tenants')) {           
                $table->foreignUuid('tenant_id')->nullable()->constrained('tenants')->cascadeOnDelete();
            }
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
        Schema::dropIfExists('reports');
    }
};
