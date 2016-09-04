<?php namespace Renatio\FormBuilder\Updates;

use Seeder;
use Renatio\FormBuilder\Models\FieldType;
use File;
use Renatio\FormBuilder\Models\Form;
use System\Models\MailLayout;
use System\Models\MailTemplate;
use Backend\Models\User;
use Renatio\FormBuilder\Models\Field;

/**
 * Class SeedFileFieldType
 * @package Renatio\FormBuilder\Updates
 */
class SeedFileFieldType extends Seeder
{

    /**
     * @return void
     */
    public function run()
    {
        $fieldType = $this->createFileUploaderFieldType();

        $layout = $this->createMailLayout();

        $template = $this->createMailTemplate($layout);

        $form = $this->createForm($template);

        $this->createFields($form, $fieldType);
    }

    /**
     * @return mixed
     */
    protected function createFileUploaderFieldType()
    {
        return FieldType::create([
            'name'        => 'File uploader',
            'code'        => 'file_uploader',
            'description' => 'Renders a file uploader for regular files.',
            'markup'      => File::get(__DIR__ . '/fields/_file_uploader.htm')
        ]);
    }

    /**
     * @return mixed
     */
    protected function createMailLayout()
    {
        MailLayout::where('code', 'renatio::form_builder_file_attachment')->delete();

        return MailLayout::create([
            'name'         => 'Form Builder File Attachment',
            'code'         => 'renatio::form_builder_file_attachment',
            'content_html' => File::get(__DIR__ . '/mail/layouts/file/markup.htm'),
            'content_text' => File::get(__DIR__ . '/mail/layouts/file/plain.txt'),
            'content_css'  => File::get(__DIR__ . '/mail/layouts/file/style.css')
        ]);
    }

    /**
     * @param MailLayout $layout
     * @return mixed
     */
    protected function createMailTemplate(MailLayout $layout)
    {
        MailTemplate::where('code', 'renatio::form_builder_file_attachment')->delete();

        return MailTemplate::create([
            'code'         => 'renatio::form_builder_file_attachment',
            'subject'      => 'Renatio Form Builder',
            'description'  => 'File mail template.',
            'content_html' => File::get(__DIR__ . '/mail/templates/file/markup.htm'),
            'content_text' => File::get(__DIR__ . '/mail/templates/file/plain.txt'),
            'layout'       => $layout,
            'is_custom'    => 1
        ]);
    }

    /**
     * @param MailTemplate $template
     * @return mixed
     */
    protected function createForm(MailTemplate $template)
    {
        $admin = User::find(1);

        return Form::create([
            'template'        => $template,
            'name'            => 'Example File Form',
            'code'            => 'form_builder_file',
            'description'     => 'Renders example form with file attachment field type.',
            'to_email'        => $admin ? $admin->email : 'admin@domain.tld',
            'to_name'         => $admin ? ($admin->first_name . ' ' . $admin->last_name) : 'Admin Person',
            'success_message' => 'Message was sent successfully!',
            'error_message'   => 'There was an error. Please try again!'
        ]);
    }

    /**
     * @param Form $form
     * @param FieldType $fieldType
     */
    protected function createFields(Form $form, FieldType $fieldType)
    {
        Field::create([
            'form'        => $form,
            'field_type'  => $fieldType,
            'label'       => 'Example file upload field',
            'name'        => 'files',
            'validation'  => 'mimes:jpg,jpeg,png|max:5120',
            'placeholder' => 'Drop files here or click to upload.',
            'nest_left'   => 1,
            'nest_right'  => 2
        ]);

        Field::create([
            'form'          => $form,
            'field_type_id' => 8,
            'label'         => 'Example submit field',
            'name'          => 'submit',
            'nest_left'     => 3,
            'nest_right'    => 4
        ]);
    }

}
