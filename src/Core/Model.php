<?php
namespace BooksSystem\Core;

abstract class Model
{
    protected array $errors = [];

    public function getErrors(string|bool $separator = false): array|string
    {
        if ($separator) {
            return implode($separator, $this->errors);
        }
    
        return $this->errors;
    }

    public function addError(string $error): void
    {
        $this->errors[] = $error;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function setProps(array $props)
    {
        foreach ($props as $key => $val) {
            if (!property_exists($this, $key)) {
                $class = static::class;

                throw new \Exception("Invalid property '{$key}' for class '{$class}'.");
            }

            $this->{$key} = $val;
        }
    }

    abstract public function validate(): bool;
}