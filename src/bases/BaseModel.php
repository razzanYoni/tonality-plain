<?php

namespace bases;

use cores\Application;

abstract class BaseModel
{
    const RULE_REQUIRED = 'required';
    const RULE_EMAIL = 'email';
    const RULE_MIN = 'min';
    const RULE_MAX = 'max';
    const RULE_MIN_VALUE = 'minValue';
    const RULE_MATCH = 'match';
    const RULE_UNIQUE = 'unique';
    const RULE_MAX_FILE_SIZE = 'maxFileSize';

    public array $errors = [];

    abstract public function constructFromArray(array $data);

    abstract public function toArray(): array;

    public function set($attr, $value): BaseModel
    {
        $this->$attr = $value;
        return $this;
    }

    public function get($attr)
    {
        return $this->$attr;
    }

    public function loadData($data): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function attributes(): array
    {
        return [];
    }

    public function labels(): array
    {
        return [];
    }

    public function getLabel($attribute)
    {
        return $this->labels()[$attribute] ?? $attribute;
    }

    public function rules(): array
    {
        return [];
    }

    public function validate(): bool
    {
        foreach ($this->rules() as $attribute => $rules) {

            $value = $this->{$attribute};

            foreach ($rules as $rule) {

                $ruleName = $rule;

                if (!is_string($rule)) {
                    $ruleName = $rule[0];
                }
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addErrorByRule($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addErrorByRule($attribute, self::RULE_EMAIL);
                }
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addErrorByRule($attribute, self::RULE_MIN, ['min' => $rule['min']]);
                }
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addErrorByRule($attribute, self::RULE_MAX);
                }
                if ($ruleName === self::RULE_MIN_VALUE && (int)$value < $rule['minValue']) {
                    $this->addErrorByRule($attribute, self::RULE_MIN_VALUE, ['minValue' => $rule['minValue']]);
                }
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addErrorByRule($attribute, self::RULE_MATCH, ['match' => $rule['match']]);
                }
                if ($ruleName === self::RULE_UNIQUE) {
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();

                    $db = Application::$app->db;
                    $statement = $db->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :$uniqueAttr");
                    $statement->bindValue(":$uniqueAttr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();

                    if ($record) {
                        $this->addErrorByRule($attribute, self::RULE_UNIQUE);
                    }
                }
                if ($ruleName === self::RULE_MAX_FILE_SIZE && !empty($_FILES)) {
                    if ($_FILES['cover_filename'] || $_FILES['audio_filename'] !== null) {
                        $fileError = $_FILES['cover_filename']['error'] ?? $_FILES['audio_filename']['error'];
                    }

                    if ($fileError === 1) {
                        // https://www.php.net/manual/en/features.file-upload.errors.php
                        $this->addErrorByRule($attribute, self::RULE_MAX_FILE_SIZE);
                    }
                }
            }
        }

        return empty($this->errors);
    }

    public function errorMessages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MIN_VALUE => 'Min value of this field must be {minValue}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with with this {field} already exists',
            self::RULE_MAX_FILE_SIZE => 'File size must not exceed 20 MB',
        ];
    }

    public function errorMessage($rule): string
    {
        return $this->errorMessages()[$rule];
    }

    protected function addErrorByRule(string $attribute, string $rule, $params = []): void
    {
        $params['field'] ??= $attribute;
        $errorMessage = $this->errorMessage($rule);
        foreach ($params as $key => $value) {
            $errorMessage = str_replace("{{$key}}", $value, $errorMessage);
        }
        $this->errors[$attribute][] = $errorMessage;
    }

    public function addError(string $attribute, string $message): void
    {
        $this->errors[$attribute][] = $message;
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute)
    {
        $errors = $this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }
}