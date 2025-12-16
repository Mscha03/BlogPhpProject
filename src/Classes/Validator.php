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
            foreach ($rules as $rule) {
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
}