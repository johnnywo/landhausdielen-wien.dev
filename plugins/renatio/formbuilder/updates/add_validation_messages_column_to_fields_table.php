<?php

namespace Renatio\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class AddValidationMessagesColumnToFieldsTable
 * @package Renatio\FormBuilder\Updates
 */
class AddValidationMessagesColumnToFieldsTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::table('renatio_formbuilder_fields', function ($table) {
            $table->text('validation_messages')->after('validation')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('renatio_formbuilder_fields', function ($table) {
            $table->dropColumn('validation_messages');
        });
    }

}
