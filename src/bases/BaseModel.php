<?php

namespace bases;

abstract class BaseModel
{
    public function set($attr, $value): BaseModel
    {
        $this->$attr = $value;
        return $this;
    }

    public function get($attr)
    {
        return $this->$attr;
    }

    abstract public function constructFromArray(array $data);

    abstract public function toResponse(): array;
}
