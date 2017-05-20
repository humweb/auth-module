<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('slug')->unique();
			$table->text('permissions')->nullable();
			$table->timestamps();
		});

		Schema::create('user_groups', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
			$table->integer('group_id')->unsigned();

            // Indexes
            $table->primary(['user_id', 'group_id']);

            // Foreign ref indexes
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('group_id')
                ->references('id')
                ->on('groups')
                ->onDelete('cascade');


		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_groups');
		Schema::drop('groups');
	}
}
