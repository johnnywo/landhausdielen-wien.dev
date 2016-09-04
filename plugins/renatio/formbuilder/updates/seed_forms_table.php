<?php

namespace Renatio\FormBuilder\Updates;

use Backend\Models\User;
use Seeder;
use Renatio\FormBuilder\Models\Form;
use File;
use System\Models\MailLayout;
use System\Models\MailTemplate;

/**
 * Class SeedFormsTable
 * @package Renatio\FormBuilder\Updates
 */
class SeedFormsTable extends Seeder
{

    /**
     * @return void
     */
    public function run()
    {
        $layout = $this->createMailLayout();

        $template = $this->createMailTemplate($layout);

        $this->createForm($template);
    }

    /**
     * @return mixed
     */
    protected function createMailLayout()
    {
        MailLayout::where('code', 'renatio::form_builder_default')->delete();

        return MailLayout::create([
            'name'         => 'Form Builder Default',
            'code'         => 'renatio::form_builder_default',
            'content_html' => File::get(__DIR__ . '/mail/layouts/default/markup.htm'),
            'content_text' => File::get(__DIR__ . '/mail/layouts/default/plain.txt'),
            'content_css'  => File::get(__DIR__ . '/mail/layouts/default/style.css')
        ]);
    }

    /**
     * @param MailLayout $layout
     * @return mixed
     */
    protected function createMailTemplate(MailLayout $layout)
    {
        MailTemplate::where('code', 'renatio::form_builder_default')->delete();

        return MailTemplate::create([
            'code'         => 'renatio::form_builder_default',
            'subject'      => 'Renatio Form Builder',
            'description'  => 'Default mail template.',
            'content_html' => File::get(__DIR__ . '/mail/templates/default/markup.htm'),
            'content_text' => File::get(__DIR__ . '/mail/templates/default/plain.txt'),
            'layout'       => $layout,
            'is_custom'    => 1
        ]);
    }

    /**
     * @param MailTemplate $template
     */
    protected function createForm(MailTemplate $template)
    {
        $admin = User::find(1);

        Form::create([
            'template'        => $template,
            'name'            => 'Example Form',
            'code'            => 'form_builder_example',
            'description'     => 'Renders example form with all available field types.',
            'to_email'        => $admin ? $admin->email : 'admin@domain.tld',
            'to_name'         => $admin ? ($admin->first_name . ' ' . $admin->last_name) : 'Admin Person',
            'success_message' => 'Message was sent successfully!',
            'error_message'   => 'There was an error. Please try again!',
        ]);
    }

}
