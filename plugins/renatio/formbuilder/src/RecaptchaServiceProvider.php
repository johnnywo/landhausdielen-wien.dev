<?php

namespace Renatio\FormBuilder;

use Session;
use Renatio\FormBuilder\Models\Settings;
use Validator;
use Illuminate\Support\ServiceProvider;
use ReCaptcha\ReCaptcha;
use Request;

/**
 * Class RecaptchaServiceProvider
 * @package Renatio\FormBuilder
 */
class RecaptchaServiceProvider extends ServiceProvider
{

    /**
     * @return void
     */
    public function boot()
    {
        Validator::extend('recaptcha', function ($attribute, $value, $parameters) {
            if (Session::has('recaptcha')) {
                $response = Session::get('recaptcha');
                Session::reflash();
            } else {
                $recaptcha = new ReCaptcha(Settings::get('secret_key'));

                $response = $recaptcha->verify($value, Request::ip());

                Session::flash('recaptcha', $response);
            }

            return $response->isSuccess();

        }, trans('renatio.formbuilder::lang.recaptcha.error'));
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
    }

}
