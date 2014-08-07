<?php

use PHPUnit_Framework_TestCase as TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function getDescriptionOfData($data)
    {
        if (is_scalar($data)) {
            return gettype($data) . "({$data})";
        }

        return gettype($data);
    }
}
