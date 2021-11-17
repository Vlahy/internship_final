<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignment_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')
                ->nullable()
                ->references('id')
                ->on('assignments')
                ->cascadeOnDelete();
            $table->foreignId('group_id')
                ->nullable()
                ->references('id')
                ->on('groups')
                ->cascadeOnDelete();
            $table->date('start_date')
                ->nullable()
                ->default(null);
            $table->date('end_date')
                ->nullable()
                ->default(null);
            $table->boolean('is_active')
                ->default(false);
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
        Schema::dropIfExists('assignments_groups');
    }
}
