<?php

namespace Renatio\FormBuilder\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

/**
 * Class AddReplyAndAutoresponseFields
 * @package Renatio\FormBuilder\Updates
 */
class AddReplyAndAutoresponseFields extends Migration
{

    /**
     * @return void
     */
    public function up()
    {
        Schema::table('renatio_formbuilder_forms', function ($table) {
            $table->string('reply_email', 100)->nullable();
            $table->string('reply_name')->nullable();
            $table->string('response_email_field')->nullable();
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::table('renatio_formbuilder_forms', function ($table) {
            $table->dropColumn('reply_email');
            $table->dropColumn('reply_name');
            $table->dropColumn('response_email_field');
        });
    }

}
