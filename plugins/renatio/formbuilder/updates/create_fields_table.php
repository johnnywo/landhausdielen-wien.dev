<?php

namespace Renatio\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateFieldsTable
 * @package Renatio\FormBuilder\Updates
 */
class CreateFieldsTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::create('renatio_formbuilder_fields', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('form_id')->unsigned()->index()->nullable();
            $table->integer('field_type_id')->unsigned()->index();
            $table->string('label')->nullable();
            $table->string('name');
            $table->string('default')->nullable();
            $table->string('validation')->nullable();
            $table->string('class')->nullable();
            $table->string('placeholder')->nullable();
            $table->string('custom_attributes')->nullable();
            $table->text('options')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('renatio_formbuilder_fields');
    }

}
