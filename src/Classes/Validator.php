<?php

namespace App\Classes;

class Validator
{
    private Request $request;
    private array $errors = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function validate($array): static
    {
        foreach ($array as $field => $rules) {
            if (in_array('nullable', $rules) && !$this->request->{$field}->isFile()) {
                continue;
            }
            foreach ($rules as $rule) {
                if ($rule === 'nullable'){
                    continue;
                }
                if(str_contains($rule, ':')){
                   $rule = explode(':', $rule);
                   $ruleName = $rule[0];
                   $ruleValue = $rule[1];
                   if ($error = $this->{$ruleName}($field, $ruleValue)){
                       $this->errors[$field] = $error;
                   }
                } else {
                    if($error = $this->{$rule}($field)){
                        $this->errors[$field] = $error;
                        break;
                    }
                }
            }
        }
        return $this;
    }

    public function hasErrors(): bool
    {
        return count($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function required($field): false|string
    {
        if (is_null($this->request->get($field))) {
            return "{$field} is required";
        }

        if (empty($this->request->get($field))) {
            return "{$field} is required";
        }

        return false;
    }

    private function email($field): false|string
    {
        if (!filter_var($this->request->{$field}, FILTER_VALIDATE_EMAIL)) {
            return "{$field} is not a valid email address";
        }

        return false;
    }

    private function min($field, $value): false|string
    {
        if (strlen($this->request->{$field}) < $value) {
            return "{$field} must be at least {$value} characters long";
        }
        return false;
    }

    private function max($field, $value): false|string
    {
        if (strlen($this->request->{$field}) > $value) {
            return "{$field} must be less than {$value} characters long";
        }

        return false;
    }

    private function in($field, $items): false|string
    {
        $items = explode(',', $items);
        if (!in_array($this->request->{$field}, $items)) {
            return "selected {$field} in invalid";
        }
        return false;
    }

    public function size($field, $len): false|string
    {
        if($this->request->{$field} > $len * 1024){
            return "{$field} must be less than {$len} KB";
        }
        return false;
    }

    public function type($field, $types): false|string
    {
        $types = explode(',', $types);
        if (!in_array($this->request->{$field}->getExtension(), $types)) {
            return "selected {$field} in invalid";
        }
        return false;
    }

    public function file($field): false|string
    {
        if (!$this->request->{$field} instanceof Upload)
        {
            return "{$field} is not a valid file";
        }
        if (!$this->request->{$field}->isFile())
        {
            return "{$field} is not a file";
        }
        return false;
    }
}