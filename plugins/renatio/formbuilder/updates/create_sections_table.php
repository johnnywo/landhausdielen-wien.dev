<?php

namespace Renatio\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateSectionsTable
 * @package Renatio\FormBuilder\Updates
 */
class CreateSectionsTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::create('renatio_formbuilder_sections', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('form_id')->unsigned()->index()->nullable();
            $table->integer('sort_order')->unsigned()->index()->nullable();
            $table->string('label')->nullable();
            $table->string('name');
            $table->string('class')->nullable();
            $table->text('wrapper_begin')->nullable();
            $table->text('wrapper_end')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        Schema::table('renatio_formbuilder_fields', function ($table) {
            $table->integer('section_id')->after('form_id')->unsigned()->index()->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('renatio_formbuilder_sections');

        Schema::table('renatio_formbuilder_fields', function ($table) {
            $table->dropColumn('section_id');
        });
    }

}
