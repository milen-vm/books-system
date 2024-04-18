<?php
namespace BooksSystem\Core;

abstract class Model
{
    protected array $guarded = ['id'];
    protected array $errors = [];
    protected ?int $id = null;
    protected static string $table;

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

    public function save(array $props = []): bool
    {
        if ($props) {
            $this->setProps($props);
        }

        if (!$this->validate()) {
            return false;
        }

        if ($this->id) {
            return $this->update();
        }

        return $this->create();
    }

    public function setProps(array $props)
    {
        foreach ($props as $key => $val) {
            if (in_array($key, $this->guarded)) {

                throw new \Exception("'{$key}' is guarded property.");
            }

            if (!property_exists($this, $key)) {
                $class = static::class;

                throw new \Exception("Invalid property '{$key}' for class '{$class}'.");
            }

            $this->{$key} = $val;
        }
    }

    abstract public function validate(): bool;

    abstract protected function update(): bool;

    abstract protected function create(): bool;
}