<?php

/**
 * Defines the Result class
 */

namespace Ciarand\Utils;

use Exception;
use RuntimeException;

/**
 * A class that represents the result of an operation. Defines an abstract
 * interface that subclasses (Success, Failure) have to implement
 */
abstract class Result
{
    /**
     * Gets the value stored inside the Result, or throws a runtime exception
     * if the Result is a Failure
     *
     * @return mixed
     *
     * @throws RuntimeException
     */
    abstract public function get();

    /**
     * Returns a failure if the parameter matches the stored value, otherwise
     * returns the same Success
     *
     * @param $value mixed      The value to reject
     * @param $message string   The message associated with the failure
     *
     * @return Result
     */
    abstract public function reject($value, $message = "");

    /**
     * Returns the Result object generated by the $callable
     *
     * @param $callable callable
     *
     * @return Result
     */
    abstract public function resultOf(callable $callable);

    /**
     * Throws an exception if the result is a Failure
     *
     * @param $type string      The type of exception to throw
     * @param $message string   The message to attach to the exception
     *
     * @return Success
     *
     * @throws Exception
     */
    abstract public function orThrow($type, $message = "");
}