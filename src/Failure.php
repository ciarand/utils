<?php

/**
 * Defines the Failure class
 */

namespace Ciarand\Utils;

use RuntimeException;

/**
 * A class that represents a failed operation and, potentially, the error
 * message associated with that failure
 */
class Failure extends Result
{
    /**
     * The message associated with this Failure
     *
     * @var string
     */
    private $message;

    /**
     * Creates a new Failure object with the given message
     *
     * @param $message string
     */
    public function __construct($message = "")
    {
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function get()
    {
        throw new RuntimeException($this->message ?: "Result failed");
    }

    /**
     * {@inheritdoc}
     */
    public function reject($value, $message = "")
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function resultOf(callable $callable)
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function orThrow($type, $message = "")
    {
        throw new $type($message ?: $this->message);
    }
}
