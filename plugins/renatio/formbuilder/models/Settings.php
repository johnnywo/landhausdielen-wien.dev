<?php

namespace Renatio\FormBuilder\Models;

use Model;

/**
 * Class Settings
 * @package Renatio\FormBuilder\Models
 */
class Settings extends Model
{

    /**
     * @var array
     */
    public $implement = ['System.Behaviors.SettingsModel'];

    /**
     * @var string
     */
    public $settingsCode = 'renatio_formbuilder_settings';

    /**
     * @var string
     */
    public $settingsFields = 'fields.yaml';

}
