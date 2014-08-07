<?php

use Ciarand\Utils as fn;

class HelpersTest extends BaseTestCase
{
    /**
     * @test
     * @dataProvider helpersDataProvider
     */
    public function they_should_return_closures($func)
    {
        $this->assertInstanceOf("Closure", $func('+'));
    }

    public function helpersDataProvider()
    {
        $operators = [
            "index",
            "nested_index",
            "property",
            "method",
            "operator",
            "not",
        ];

        $namespace = function ($func) {
            return "Ciarand\\Utils\\{$func}";
        };

        $data = [];

        foreach ($operators as $func) {
            $data[$func] = [$namespace($func)];
        }

        return $data;
    }

    /**
     * @test
     */
    public function the_index_function_should_retrieve_the_right_index()
    {
        $arr = [1, 2];

        $func = fn\index(1);

        $this->assertEquals(2, $func($arr));
    }

    /**
     * @test
     */
    public function the_nested_index_function_should_retrieved_the_right_index()
    {
        $arr = [0, 1 => ["1.0", "1.1" => ["key" => "1.1.0"]]];

        $func = fn\nested_index(1, "1.1", "key");

        $this->assertEquals("1.1.0", $func($arr));
    }

    /**
     * @test
     */
    public function the_property_function_should_retrieve_the_correct_property()
    {
        $obj = (object) ['foo' => 'bar', 'baz' => 'nope'];

        $func = fn\property('foo');

        $this->assertEquals("bar", $func($obj));
    }

    /**
     * @test
     */
    public function the_method_function_should_call_the_correct_method()
    {
        $obj = new Exception("message");

        $func = fn\method('getMessage');

        $this->assertEquals("message", $func($obj));
    }

    /**
     * @test
     * @dataProvider operatorsDataProvider
     */
    public function the_operator_function_should_perform_the_correct_operation(
        $operator,
        $params
    ) {
        $func = fn\operator($operator);

        list($args, $result) = $params;

        $this->assertEquals($result, call_user_func_array($func, $args));
    }

    public function operatorsDataProvider()
    {
        return [
            'instanceof' => ['instanceof', [[(object) [], 'stdClass'], true]],
            '*'          => ['*', [[4, 3], 12]],
            '/'          => ['/', [[12, 3], 4]],
            '%'          => ['%', [[12, 3], 0]],
            '+'          => ['+', [[4, 3], 7]],
            '-'          => ['-', [[4, 3], 1]],
            '.'          => ['.', [[4, 3], '43']],
            '<<'         => ['<<', [[4, 3], 32]],
            '>>'         => ['>>', [[4, 3], 0]],
            '<'          => ['<', [[4, 3], false]],
            '<='         => ['<=', [[4, 3], false]],
            '>'          => ['>', [[4, 3], true]],
            '>='         => ['>=', [[4, 3], true]],
            '=='         => ['==', [[4, '4'], true]],
            '!='         => ['!=', [[4, 3], true]],
            '==='        => ['===', [[4, '4'], false]],
            '!=='        => ['!==', [[4, '4'], true]],
            '&'          => ['&', [[4, 3], 0]],
            '^'          => ['^', [[4, 3], 7]],
            '|'          => ['|', [[4, 3], 7]],
            '&&'         => ['&&', [[true, false], false]],
            '||'         => ['||', [[true, false], true]],
        ];
    }

    /**
     * @test
     */
    public function the_not_function_should_return_false_given_a_true_value()
    {
        $notFalse = fn\not(function () {
            return false;
        });

        $notTrue = fn\not(function () {
            return true;
        });

        $this->assertFalse($notTrue());
        $this->assertTrue($notFalse());
    }
}
