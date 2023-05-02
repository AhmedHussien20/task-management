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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->boolean('completed')->default(false);
            $table->unsignedBigInteger('assign_to_id')->nullable();
            $table->unsignedBigInteger('assigned_by_id')->nullable();
            $table->foreign('assign_to_id')
            ->references('id')
            ->on('users')
            ->onDelete('set null');
            $table->foreign('assigned_by_id')
            ->references('id')
            ->on('users')
            ->onDelete('set null');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
