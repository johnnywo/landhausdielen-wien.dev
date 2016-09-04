<?php

namespace Renatio\FormBuilder\Updates;

use Seeder;
use Renatio\FormBuilder\Models\FieldType;
use File;

/**
 * Class SeedSectionFieldType
 * @package Renatio\FormBuilder\Updates
 */
class SeedSectionFieldType extends Seeder
{

    /**
     * @return void
     */
    public function run()
    {
        FieldType::create([
            'name'        => 'Section',
            'code'        => 'section',
            'description' => 'Renders a section with assigned fields.',
            'markup'      => File::get(__DIR__ . '/fields/_section.htm'),
        ]);
    }

}
