<?php

namespace Renatio\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class AddContentHtmlColumnToFormLogsTable
 * @package Renatio\FormBuilder\Updates
 */
class AddContentHtmlColumnToFormLogsTable extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::table('renatio_formbuilder_form_logs', function ($table) {
            $table->text('content_html')->after('form_data')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('renatio_formbuilder_form_logs', function ($table) {
            $table->dropColumn('content_html');
        });
    }

}
