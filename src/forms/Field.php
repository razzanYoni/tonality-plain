<?php

namespace forms;

require_once ROOT_DIR . "src/bases/BaseField.php";
require_once ROOT_DIR . "src/models/UserModel.php";
require_once ROOT_DIR . "src/models/SongModel.php";

use bases\BaseField;
use bases\BaseModel;

class Field extends BaseField
{
    const TYPE_TEXT = 'text';
    const TYPE_NUMBER = 'number';
    const TYPE_PASSWORD = 'password';
    const TYPE_FILE = 'file';
    const TYPE_DATE = 'date';
    protected array $options = [];

    public function __construct(BaseModel $model, string $attribute, $options = [], $arguments = '')
    {
        $this->type = self::TYPE_TEXT;
        $this->options = $options;
        $this->arguments = $arguments;
        parent::__construct($model, $attribute);
    }

    public function renderInput(): string
    {
        $optionsString = '';
        foreach ($this->options as $key => $value) {
            $optionsString .= "$key=\"$value\" ";
        }

        return sprintf(
            '<input type="%s" name="%s" value="%s" %s>',
            $this->type,
            $this->attribute,
            $this->model->get($this->attribute),
            $optionsString,
        );
    }

    public function numberField(): static
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

    public function passwordField(): static
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    public function fileField(): static
    {
        $this->type = self::TYPE_FILE;
        return $this;
    }

    public function dateField(): static
    {
        $this->type = self::TYPE_DATE;
        return $this;
    }
}
