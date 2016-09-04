<?php

namespace Renatio\FormBuilder\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Renatio\FormBuilder\Models\FormLog;

/**
 * Class FormLogs
 * @package Renatio\FormBuilder\Controllers
 */
class FormLogs extends Controller
{

    /**
     * @var array
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Renatio.FormBuilder.Behaviors.FormLogController'
    ];

    /**
     * @var array
     */
    public $requiredPermissions = ['renatio.formbuilder.access_formlogs'];

    /**
     * @var string
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        $this->addCss('/plugins/renatio/formbuilder/assets/css/logger.css');

        BackendMenu::setContext('Renatio.FormBuilder', 'formbuilder', 'formlogs');
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function preview_html()
    {
        $log = FormLog::find($this->params[0]);

        return response($log->content_html);
    }

}
