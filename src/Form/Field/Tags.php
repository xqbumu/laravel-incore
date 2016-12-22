<?php

namespace Encore\Incore\Form\Field;

use Encore\Incore\Form\Field;

class Tags extends Field
{
    protected $value = [];

    protected static $css = [
        '/packages/docore/AdminLTE/plugins/select2/select2.min.css',
    ];

    protected static $js = [
        '/packages/docore/AdminLTE/plugins/select2/select2.full.min.js',
    ];

    public function fill($data)
    {
        $relations = array_get($data, $this->column);

        if (is_string($relations)) {
            $this->value = explode(',', $relations);
        }

        $this->value = array_filter($this->value);
    }

    public function prepare($value)
    {
        return array_filter($value);
    }

    public function render()
    {
        $this->script = "$(\".{$this->getElementClass()}\").select2({
            tags: true,
            tokenSeparators: [',']
        });";

        return parent::render();
    }
}
