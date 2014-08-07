<?php

use Ciarand\Utils\Success;

class SuccessTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider differentValuesDataProvider
     */
    public function it_should_be_able_to_get_different_values($value)
    {
        $success = new Success($value);

        $this->assertEquals($success->get(), $value);
    }

    public function differentValuesDataProvider()
    {
        $data = [];

        foreach ([1, 'foo', null, [3]] as $arg) {
            $data[$this->getDescriptionOfData($arg)] = [$arg];
        }

        return $data;
    }
}
