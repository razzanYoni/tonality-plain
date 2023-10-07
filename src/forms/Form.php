<?php

namespace forms;

require_once ROOT_DIR . "src/forms/Field.php";

use bases\BaseModel;

class Form
{
    public static function begin($action, $method, $options = [], $enctype = 'application/x-www-form-urlencoded'): Form
    {
        $attributes = '';
        foreach ($options as $key => $value) {
            $attributes .= "$key=\"$value\"  ";
        }
        echo sprintf('<form action="%s" method="%s" enctype="%s" %s>', $action, $method, $enctype, $attributes);
        return new Form();
    }

    public static function end(): void
    {
        echo '</form>';
    }

    public function field(BaseModel $model, $attribute, $options = [], $arguments = ''): Field
    {
        return new Field($model, $attribute, $options, $arguments);
    }
}