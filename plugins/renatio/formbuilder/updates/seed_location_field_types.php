<?php

namespace Renatio\FormBuilder\Updates;

use Renatio\FormBuilder\Models\FieldType;
use Seeder;
use File;

/**
 * Class SeedLocationFieldTypes
 * @package Renatio\FormBuilder\Updates
 */
class SeedLocationFieldTypes extends Seeder
{

    /**
     * @return void
     */
    public function run()
    {
        FieldType::create([
            'name'        => 'Country select',
            'code'        => 'country_select',
            'description' => 'Renders a dropdown with country options.',
            'markup'      => File::get(__DIR__ . '/fields/_country_select.htm')
        ]);

        FieldType::create([
            'name'        => 'State select',
            'code'        => 'state_select',
            'description' => 'Renders a dropdown with state options.',
            'markup'      => File::get(__DIR__ . '/fields/_state_select.htm')
        ]);
    }

}
