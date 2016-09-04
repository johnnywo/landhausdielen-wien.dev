<?php

namespace Renatio\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class AddCssWrapperClassColumnToFieldsTable
 * @package Renatio\FormBuilder\Updates
 */
class AddCssWrapperClassColumnToFieldsTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::table('renatio_formbuilder_fields', function ($table) {
            $table->string('wrapper_class')->after('class')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('renatio_formbuilder_fields', function ($table) {
            $table->dropColumn('wrapper_class');
        });
    }

}
