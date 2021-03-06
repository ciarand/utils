<?php

/**
 * Defines the Success class
 */

namespace Ciarand\Utils;

/**
 * A container object that represents a successful operation and carries the
 * result of that operation
 */
class Success extends Result
{
    /**
     * The value used in operations
     *
     * @var mixed
     */
    private $value;

    /**
     * Constructs a new Success object with the provided $value
     *
     * @param $value mixed
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function reject($value, $message = "")
    {
        if ($this->value === $value) {
            return new Failure($message);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function resultOf(callable $callable)
    {
        $result = call_user_func($callable, $this->value);

        if (!$result instanceof Result) {
            throw new RuntimeException("The provided callable didn't return a Result object");
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function orThrow($type, $message = "")
    {
        return $this;
    }
}
