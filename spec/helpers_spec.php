<?php require __DIR__ . "/../vendor/autoload.php";

use Ciarand\Utils as fn;

describe("the index function", function () {
    it("should return a callable", function () {
        expect(fn\index(1))->toBeAnInstanceOf("Closure");
    });

    it("should retrieve the right index", function () {
        $arr = [1, 2];

        $fn = fn\index(1);

        expect($fn($arr))->toBe(2);
    });
});

describe("the nested_index function", function () {
    it("should return a callable", function () {
        expect(fn\nested_index(1, 2, 3))->toBeAnInstanceOf("Closure");
    });

    it("should retrieve the right index", function () {
        $arr = [0, 1 => ["1.0", "1.1" => ["key" => "1.1.0"]]];

        $fn = fn\nested_index(1, "1.1", "key");

        expect($fn($arr))->toBe("1.1.0");
    });
});

describe("the property function", function () {
    it("should return a callable", function () {
        expect(fn\property('prop'))->toBeAnInstanceOf("Closure");
    });

    it("should retrieve the correct property", function () {
        $obj = (object) ['foo' => 'bar', 'baz' => 'nope'];

        $fn = fn\property('foo');

        expect($fn($obj))->toBe("bar");
    });
});

describe("the method function", function () {
    it("should return a callable", function () {
        expect(fn\method('method'))->toBeAnInstanceOf("Closure");
    });

    it("should call the correct method", function () {
        $obj = new Exception("message");

        $fn = fn\method("getMessage");

        expect($fn($obj))->toBe("message");
    });
});

describe("the operator function", function () {
    $ops = [
        'instanceof' => [[(object) [], 'stdClass'], true],
        '*' => [[4, 3], 12],
        '/' => [[12, 3], 4],
        '%' => [[12, 3], 0],
        '+' => [[4, 3], 7],
        '-' => [[4, 3], 1],
        '.' => [[4, 3], '43'],
        '<<' => [[4, 3], 32],
        '>>' => [[4, 3], 0],
        '<' => [[4, 3], false],
        '<=' => [[4, 3], false],
        '>' => [[4, 3], true],
        '>=' => [[4, 3], true],
        '==' => [[4, '4'], true],
        '!=' => [[4, 3], true],
        '===' => [[4, '4'], false],
        '!==' => [[4, '4'], true],
        '&' => [[4, 3], 0],
        '^' => [[4, 3], 7],
        '|' => [[4, 3], 7],
        '&&' => [[true, false], false],
        '||' => [[true, false], true],
    ];

    it("should return a callable", function () use ($ops) {
        foreach (array_keys($ops) as $op) {
            expect(fn\operator($op))->toBeAnInstanceOf("Closure");
        }
    });

    foreach ($ops as $op => $params) {
        it("should perform the correct op for {$op}", function () use ($op, $params) {
            $fn = fn\operator($op);

            list($args, $result) = $params;

            expect(call_user_func_array($fn, $args))->toBe($result);
        });
    }
});

describe("the not function", function () {
    it("should return a callable", function () {
        expect(fn\not('method'))->toBeAnInstanceOf("Closure");
    });

    it("should return false given a true value", function () {
        $false = fn\not(function () {
            return true;
        });

        $true = fn\not(function () {
            return false;
        });

        expect($true())->toBe(true);
        expect($false())->toBe(false);
    });
});
