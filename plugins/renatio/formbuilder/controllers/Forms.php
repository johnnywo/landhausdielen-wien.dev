<?php

namespace Renatio\FormBuilder\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Renatio\FormBuilder\Models\Field;


/**
 * Class Forms
 * @package Renatio\FormBuilder\Controllers
 */
class Forms extends Controller
{

    /**
     * @var array Behaviors
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController',
        'Renatio.FormBuilder.Behaviors.FormController'
    ];

    /**
     * @var array
     */
    public $requiredPermissions = ['renatio.formbuilder.access_forms'];

    /**
     * @var string
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string
     */
    public $listConfig = 'config_list.yaml';

    /**
     * @var string
     */
    public $relationConfig = 'config_relation.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Renatio.FormBuilder', 'formbuilder', 'forms');
    }

    /**
     * @param $formId
     */
    public function reorder($formId)
    {
        $this->pageTitle = trans('renatio.formbuilder::lang.fields.reorder');

        $toolbarConfig = $this->makeConfig();
        $toolbarConfig->buttons = '$/renatio/formbuilder/controllers/forms/_reorder_toolbar.htm';

        $this->vars['toolbar'] = $this->makeWidget('Backend\Widgets\Toolbar', $toolbarConfig);
        $this->vars['records'] = Field::where('form_id', $formId)->get();
        $this->vars['formId'] = $formId;
    }

}
