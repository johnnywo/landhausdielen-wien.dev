<?php

namespace Renatio\FormBuilder\Traits;

use Event;
use Renatio\FormBuilder\Models\FormLog;
use Validator;
use Redirect;
use Request;
use Flash;

/**
 * Class RenderFormAjax
 * @package Renatio\FormBuilder\Traits
 */
trait RenderFormAjax
{

    /**
     * @var
     */
    public $message;

    /**
     * @return mixed
     */
    public function onSubmit()
    {
        $validator = $this->makeValidator();

        if ($validator->fails()) {
            return $this->printErrors($validator);
        }

        $response = Event::fire('formBuilder.sendMessage', [$this->form]);

        return $this->processResult($response);
    }

    /**
     * Render flash partial
     *
     * @return array
     */
    public function onFlash()
    {
        return ['#errors' => $this->renderPartial('errors')];
    }

    /**
     * On update file handle
     */
    public function onUpdateFile()
    {
        $file = $this->getFile();

        if (($deleteId = post('id')) && post('mode') == 'delete') {
            if ($deleteFile = $file->find($deleteId)) {
                $deleteFile->delete();
            }
        }

        $this->page['file'] = $file;
    }

    /**
     * @return string
     */
    public function onChangeCountry()
    {
        $options = class_exists('RainLab\Location\Models\State') ? \RainLab\Location\Models\State::getNameList(post('country')) : [];

        return json_encode($options);
    }

    /**
     * Get uploaded file
     *
     * @return mixed
     */
    private function getFile()
    {
        if ($sessionKey = $this->getSessionKey()) {
            $model = new FormLog;

            $deferredQuery = $model
                ->files()
                ->withDeferred($sessionKey)
                ->orderBy('id', 'desc');

            return $deferredQuery->get();
        }
    }

    /**
     * @return mixed
     */
    private function makeValidator()
    {
        $data = post();

        $rules = $this->form->buildValidationRules();

        $rules = $this->checkFileRequired($rules);

        $validator = Validator::make($data, $rules, $this->form->customMessages());

        $validator->setAttributeNames($this->form->buildAttributeNames());

        return $validator;
    }

    /**
     * Process result sending email
     *
     * @param $result
     * @return mixed
     */
    private function processResult($result)
    {
        $success = $this->form->success_message ? $this->form->success_message : trans('renatio.formbuilder::lang.message.success');
        $error = $this->form->error_message ? $this->form->error_message : trans('renatio.formbuilder::lang.message.error');
        $result ? $this->setMessage($success, 'success', true) : $this->setMessage($error);

        if ($result) {
            return $this->getRedirect();
        }
    }

    /**
     * Check file was uploaded
     *
     * @param $rules
     * @return mixed
     */
    private function checkFileRequired($rules)
    {
        if (str_contains($this->fileConfig['validation'], 'required')) {
            $formLog = new FormLog;
            if ( ! $formLog->files()->withDeferred(post('_session_key'))->get()->isEmpty()) {
                $rules[$this->fileConfig['name']] = preg_replace('/required\|?/', '', $this->fileConfig['validation']);
            }
        }

        return $rules;
    }

    /**
     * Set message in session
     *
     * @param $message
     * @param string $type
     * @param bool $flash
     */
    public function setMessage($message, $type = 'danger', $flash = false)
    {
        $this->message = [
            'text' => $message,
            'type' => $type
        ];

        if ($flash) {
            Flash::$type($message . $this->form->code);
        }
    }

    /**
     * @param $validator
     */
    private function printErrors($validator)
    {
        $errors = '';

        foreach ($validator->errors()->all() as $message) {
            $errors .= '<p class="form-error">' . $message . '</p>';
        }

        $this->setMessage($errors);
    }

    /**
     * @return mixed
     */
    private function getRedirect()
    {
        if ($this->property('redirect')) {
            return Redirect::intended($this->pageUrl($this->property('redirect')));
        } elseif ($this->property('custom_redirect')) {
            return Redirect::to($this->property('custom_redirect'));
        } else {
            return Redirect::to(Request::url());
        }
    }

}
