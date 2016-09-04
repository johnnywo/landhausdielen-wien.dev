<?php

namespace Renatio\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class AddCommentColumnToFieldsTable
 * @package Renatio\FormBuilder\Updates
 */
class AddCommentColumnToFieldsTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::table('renatio_formbuilder_fields', function ($table) {
            $table->string('comment')->after('validation')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('renatio_formbuilder_fields', function ($table) {
            $table->dropColumn('comment');
        });
    }

}
