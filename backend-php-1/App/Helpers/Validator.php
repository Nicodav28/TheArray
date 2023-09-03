<?php

namespace App\Helpers;

class Validator
{
    /**
     * Validation errors storage.
     *
     * @var array
     */
    protected $errors = [];

    /**
     * Validate input data against a set of validation rules.
     *
     * @param array $data   The input data to be validated.
     * @param array $rules  An array of validation rules for each field.
     *
     * @return $this
     */
    public function validate(array $data, array $rules)
    {
        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);

            foreach ($rulesArray as $singleRule) {
                $nullable = false;

                // Check if the rule is nullable
                if (strpos($singleRule, 'nullable') !== false) {
                    $nullable = true;
                    $singleRule = str_replace('nullable|', '', $singleRule);
                }

                $this->validateRule($field, $singleRule, $data, $nullable);
            }
        }

        return $this;
    }

    /**
     * Validate a single rule for a specific field.
     *
     * @param string $field     The name of the field being validated.
     * @param string $rule      The validation rule to apply.
     * @param array  $data      The input data to be validated.
     * @param bool   $nullable  Indicates if the field is nullable.
     *
     * @return void
     */
    protected function validateRule($field, $rule, $data, $nullable)
    {
        $params = [];

        if (strpos($rule, ':') !== false) {
            list($rule, $params) = explode(':', $rule, 2);
            $params = explode(',', $params);
        }

        $method = 'validate' . ucfirst($rule);

        if ($nullable && empty($data[$field])) {
            return; // Skip validation if the field is nullable and empty
        }

        if (method_exists($this, $method)) {
            call_user_func([$this, $method], $field, $data[$field], $params);
        }
    }

    /**
     * Add an error message for a specific field.
     *
     * @param string $field     The name of the field.
     * @param string $message   The error message to add.
     *
     * @return void
     */
    protected function addError($field, $message)
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [];
        }

        $this->errors[$field][] = $message;
    }

    /**
     * Check if validation passes (no errors).
     *
     * @return bool
     */
    public function passes()
    {
        return empty($this->errors);
    }

    /**
     * Get the array of validation errors.
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Validate that a field is required and not empty.
     *
     * @param string $field  The name of the field.
     * @param mixed  $value  The value of the field.
     *
     * @return void
     */
    protected function validateRequired($field, $value)
    {
        if (empty($value)) {
            $this->addError($field, "The $field field is required.");
        }
    }

    /**
     * Validate that a field contains a numeric value.
     *
     * @param string $field  The name of the field.
     * @param mixed  $value  The value of the field.
     *
     * @return void
     */
    protected function validateNumeric($field, $value)
    {
        if (!is_numeric($value)) {
            $this->addError($field, "The $field field must be a number.");
        }
    }

    /**
     * Validate that a field contains a valid date.
     *
     * @param string $field  The name of the field.
     * @param mixed  $value  The value of the field.
     *
     * @return void
     */
    protected function validateDate($field, $value)
    {
        if (!strtotime($value)) {
            $this->addError($field, "The $field field must be a valid date.");
        }
    }
}
