<?php

namespace Renatio\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class CreateFormLogsTable
 * @package Renatio\FormBuilder\Updates
 */
class CreateFormLogsTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::create('renatio_formbuilder_form_logs', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('form_id')->unsigned()->index();
            $table->text('form_data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('renatio_formbuilder_form_logs');
    }

}
