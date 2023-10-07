<?php

namespace bases;

use bases\BaseModel;

abstract class BaseField
{
    public BaseModel $model;
    public string $attribute;
    public string $type;
    public string $arguments;

    public function __construct(BaseModel $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    public function __toString()
    {
        return sprintf(
            '<div class="form-label">%s</div>
                        %s
                        
                        %s
                
                    <div class="invalid-feedback">
                        %s
                    </div>',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->arguments,
            $this->model->getFirstError($this->attribute),
        );
    }

    abstract public function renderInput();
}