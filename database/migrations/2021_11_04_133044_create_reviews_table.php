<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('pros');
            $table->string('cons');
            $table->foreignId('assignment_id')
                ->nullable()
                ->references('id')
                ->on('assignments');
            $table->foreignId('mentor_id')
                ->nullable()
                ->references('id')
                ->on('users');
            $table->foreignId('intern_id')
                ->nullable()
                ->references('id')
                ->on('interns');
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
        Schema::dropIfExists('reviews');
    }
}