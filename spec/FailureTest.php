<?php

use Ciarand\Utils\Failure;

class FailureTest extends BaseTestCase
{
    /**
     * @test
     * @expectedException        RuntimeException
     * @expectedExceptionMessage foobar
     */
    public function it_should_throw_an_exception_with_the_provided_message_when_get_is_called()
    {
        $fail = new Failure("foobar");

        $fail->get();
    }

    /**
     * @test
     * @expectedException        RuntimeException
     * @expectedExceptionMessage Result failed
     */
    public function it_should_throw_an_exception_with_a_default_message_when_get_is_called()
    {
        $fail = new Failure;

        $fail->get();
    }
}
