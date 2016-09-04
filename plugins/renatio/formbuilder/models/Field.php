<?php

namespace Renatio\FormBuilder\Models;

use Model;
use October\Rain\Database\Traits\NestedTree;
use October\Rain\Database\Traits\Validation;
use Twig;
use Request;

/**
 * Class Field
 * @package Renatio\FormBuilder\Models
 */
class Field extends Model
{

    use Validation;
    use NestedTree;

    /**
     * @var array
     */
    public $implement = ['@RainLab.Translate.Behaviors.TranslatableModel'];

    /**
     * @var string
     */
    public $table = 'renatio_formbuilder_fields';

    /**
     * @var array
     */
    public $rules = [
        'field_type'        => 'required',
        'label'             => 'max:255',
        'name'              => 'required|max:255',
        'default'           => 'max:255',
        'validation'        => 'max:255',
        'custom_attributes' => 'max:255',
        'class'             => 'max:255',
        'placeholder'       => 'max:255',
        'wrapper_class'     => 'max:255',
        'comment'           => 'max:255',
    ];

    /**
     * @var array
     */
    public $attributeNames = [
        'field_type'        => 'renatio.formbuilder::lang.field.field_type',
        'label'             => 'renatio.formbuilder::lang.field.label',
        'name'              => 'renatio.formbuilder::lang.field.name',
        'default'           => 'renatio.formbuilder::lang.field.default',
        'validation'        => 'renatio.formbuilder::lang.field.validation',
        'custom_attributes' => 'renatio.formbuilder::lang.field.custom_attributes',
        'class'             => 'renatio.formbuilder::lang.field.class',
        'placeholder'       => 'renatio.formbuilder::lang.field.placeholder',
        'wrapper_class'     => 'renatio.formbuilder::lang.field.wrapper_class',
        'comment'           => 'renatio.formbuilder::lang.field.comment'
    ];

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @var array
     */
    public $translatable = ['label', 'default', 'placeholder', 'options', 'validation_messages', 'comment'];

    /**
     * @var array
     */
    protected $jsonable = ['options', 'validation_messages'];

    /**
     * @var array
     */
    public $belongsTo = [
        'form'       => ['Renatio\FormBuilder\Models\Form'],
        'field_type' => ['Renatio\FormBuilder\Models\FieldType'],
        'section'    => ['Renatio\FormBuilder\Models\Section'],
    ];

    /**
     * @return mixed
     */
    public function getHtmlAttribute()
    {
        return Twig::parse($this->field_type->markup, $this->prepareFieldOptions());
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * @return array
     */
    public function getFileConfig()
    {
        return [
            'name'        => $this->name,
            'placeholder' => $this->placeholder,
            'maxSize'     => $this->getFileMaxSize(),
            'fileTypes'   => $this->getAcceptedFileTypes(),
            'validation'  => $this->validation,
        ];
    }

    /**
     * @return array
     */
    public function listTypes()
    {
        $types = FieldType::where('code', '!=', 'section')->get();

        return ['' => trans('renatio.formbuilder::lang.form.placeholder')] + $types->lists('name', 'id');
    }

    /**
     * @return array
     */
    public function listSections()
    {
        $sections = Section::where('form_id', Request::segment(6));

        return ['' => trans('renatio.formbuilder::lang.form.placeholder')] + $sections->lists('name', 'id');
    }

    /**
     * @return float|int
     */
    private function getFileMaxSize()
    {
        $maxSize = $this->getDefaultMaxSizeInMegabytes();

        $rules = explode('|', $this->validation);

        foreach ($rules as $rule) {
            if (strpos($rule, 'max') !== false) {
                $sizeInKb = str_replace('max:', '', $rule);

                return $this->KbToMb($sizeInKb);
            }
        }

        return $maxSize;
    }

    /**
     * @return array|string
     */
    private function getAcceptedFileTypes()
    {
        $fileTypes = '*';

        $rules = explode('|', $this->validation);

        foreach ($rules as $rule) {
            if (strpos($rule, 'mimes') !== false) {
                return $this->processFileTypes(str_replace('mimes:', '', $rule));
            }
        }

        return $fileTypes;
    }

    /**
     * Process file types
     *
     * @param $fileTypes
     * @return array
     */
    protected function processFileTypes($fileTypes)
    {
        $result = [];

        if ($fileTypes != '*') {
            foreach (explode(',', $fileTypes) as $type) {
                $type = trim($type);

                if (substr($type, 0, 1) != '.') {
                    $type = '.' . $type;
                }

                $result[] = $type;
            }
        } else {
            $result[] = '*';
        }

        return $result;
    }

    /**
     * @return int
     */
    private function getDefaultMaxSizeInMegabytes()
    {
        return 5;
    }

    /**
     * @param $sizeInKb
     * @return float
     */
    private function KbToMb($sizeInKb)
    {
        return round($sizeInKb / 1024, 3);
    }

    /**
     * @return mixed
     */
    public function postValue()
    {
        $value = post($this->name);

        if ($this->field_type->code == 'country_select' && post($this->name)) {
            $value = $this->getCountryById(post($this->name))->name;
        }

        if ($this->field_type->code == 'state_select' && post($this->name)) {
            $value = $this->getStateById(post($this->name))->name;
        }

        return $value;
    }

    /**
     * @param $countryId
     * @return mixed
     */
    private function getCountryById($countryId)
    {
        if (class_exists('RainLab\Location\Models\Country')) {
            return \RainLab\Location\Models\Country::findOrFail($countryId);
        }
    }

    /**
     * @param $stateId
     * @return mixed
     */
    private function getStateById($stateId)
    {
        if (class_exists('RainLab\Location\Models\State')) {
            return \RainLab\Location\Models\State::findOrFail($stateId);
        }
    }

    /**
     * @return array
     */
    private function prepareFieldOptions()
    {
        $settings = Settings::instance();

        return [
            'field_id'          => $this->id,
            'label'             => $this->label,
            'name'              => $this->name,
            'default'           => $this->default,
            'comment'           => $this->comment,
            'class'             => $this->class,
            'wrapper_class'     => $this->wrapper_class,
            'placeholder'       => $this->placeholder,
            'options'           => $this->options,
            'custom_attributes' => $this->custom_attributes,
            'settings'          => $settings,
        ];
    }

}
