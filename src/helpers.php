<?php

/**
 * A set of utility functions that provide (mostly functional) additions to the
 * PHP toolkit
 */

namespace Ciarand\Utils;

use InvalidArgumentException;

/**
 * Dies if ever called, a stub for unimplemented code.
 *
 * The "…" method functions similarly to Perl6's "..." operator (the "yada,
 * yada, yada" operator) and dies if it's ever called. It's used as a stub for
 * unwritten code.
 *
 * @SuppressWarnings(PHPMD.ExitExpression)
 */
function …()
{
    die("Method stub");
}

/**
 * Returns a callable which returns an item from an array corresponding to the
 * given index
 *
 * @param mixed $index
 *
 * @return callable
 */
function index($index)
{
    return function($array) use ($index) {
        return $array[$index];
    };
}

/**
 * Returns a callable which returns an item from a nested array corresponding
 * to the given path.
 *
 * Examples:
 *
 *     $array = [
 *         'foo' => [
 *             'bar' => [
 *                 'baz' => 42
 *             ]
 *         ]
 *     ];
 *
 *     $getIndexFooBar = fn\nested_index('foo', 'bar');
 *     $getIndexFooBarBaz = fn\nested_index('foo', 'bar', 'baz');
 *
 *     $getIndexFooBar($array)
 *     => ['baz' => 42]
 *
 *     $getIndexFooBarBaz($array)
 *     => 42
 *
 * @param mixed[] ...$indices Path of indices
 *
 * @return callable
 */
function nested_index(/* ...$indices */) {
    $indices = func_get_args();

    return function($array) use ($indices) {
        foreach ($indices as $index) {
            $array = $array[$index];
        }

        return $array;
    };
}

/**
 * Returns a callable which returns a property from an object corresponding to
 * the provided string
 *
 * @param string $propertyName
 *
 * @return callable
 */
function property($propertyName) {
    return function($object) use ($propertyName) {
        return $object->$propertyName;
    };
}

/**
 * Returns a callable which returns the result of a method call corresponding
 * to the provided string and args
 *
 * @param string $methodName
 * @param array $args
 *
 * @return callable
 */
function method($methodName, array $args = []) {
    if (empty($args)) {
        return function($object) use ($methodName) {
            return $object->$methodName();
        };
    } else {
        return function($object) use ($methodName, $args) {
            return call_user_func_array([$object, $methodName], $args);
        };
    }
}

/**
 * Returns a callable which returns the result of the provided operator on its
 * two arguments.
 *
 * @param string $operator
 * @param mixed $arg
 *
 * @return callable
 *
 * @throws InvalidArgumentException
 *
 * @SuppressWarnings(PHPMD.ShortVariableName)
 */
function operator($operator, $arg = null) {
    $functions = [
        'instanceof' => function($a, $b) { return $a instanceof $b; },
        '*'   => function($a, $b) { return $a *   $b; },
        '/'   => function($a, $b) { return $a /   $b; },
        '%'   => function($a, $b) { return $a %   $b; },
        '+'   => function($a, $b) { return $a +   $b; },
        '-'   => function($a, $b) { return $a -   $b; },
        '.'   => function($a, $b) { return $a .   $b; },
        '<<'  => function($a, $b) { return $a <<  $b; },
        '>>'  => function($a, $b) { return $a >>  $b; },
        '<'   => function($a, $b) { return $a <   $b; },
        '<='  => function($a, $b) { return $a <=  $b; },
        '>'   => function($a, $b) { return $a >   $b; },
        '>='  => function($a, $b) { return $a >=  $b; },
        '=='  => function($a, $b) { return $a ==  $b; },
        '!='  => function($a, $b) { return $a !=  $b; },
        '===' => function($a, $b) { return $a === $b; },
        '!==' => function($a, $b) { return $a !== $b; },
        '&'   => function($a, $b) { return $a &   $b; },
        '^'   => function($a, $b) { return $a ^   $b; },
        '|'   => function($a, $b) { return $a |   $b; },
        '&&'  => function($a, $b) { return $a &&  $b; },
        '||'  => function($a, $b) { return $a ||  $b; },
    ];

    if (!isset($functions[$operator])) {
        throw new InvalidArgumentException("Unknown operator \"{$operator}\"");
    }

    $fn = $functions[$operator];
    if ($arg === null) {
        return $fn;
    }

    return function($a) use ($fn, $arg) {
        return $fn($a, $arg);
    };
}

/**
 * Returns a callable that returns the inverse (!) of the provided callable
 *
 * @param callable $function
 *
 * @return callable
 */
function not($function) {
    return function() use ($function) {
        return !call_user_func_array($function, func_get_args());
    };
}
