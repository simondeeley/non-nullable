<?php
declare(strict_types=1);
/**
 * This file is part of the Non Nullable package.
 * For the full copyright information please view the LICENCE file that was
 * distributed with this package.
 *
 * @author    Simon Deeley <s.deeley@icloud.com>
 * @copyright Simon Deeley 2017
 */

namespace simondeeley\Tests;

use RuntimeException;
use PHPUnit\Framework\TestCase;
use simondeeley\NonNullableBehaviour;

/**
* Unit tests for Non Nullable Behavior
*
*/
final class NonNullableBehaviourTest extends TestCase
{
    protected static $class;

    final static public function setUpBeforeClass(): void
    {
        self::$class = new class {
            use NonNullableBehaviour;

            protected $foo = 1;
            protected $bar;
        };
    }

    /**
     * @dataProvider dataProvider
     */
    final public function testShouldCatchNullProperties($data): void
    {
        $this->assertTrue(is_nullable($data));
    }

    final public function testShouldThrowRuntimeExceptionWhenObjectHasNullProperties(): void
    {
        $this->expectException(RuntimeException::class);

        self::$class = 1; // Force deconstruct of $class
    }


    final public function dataProvider(): array
    {
        return [
            'Simple argument' => [
                null
            ],
            'Simple array' => [
                [1, 2, 3, 4, null, 6]
            ],
            'Array with keys' => [
                [
                    'foo' => 'bar',
                    'baz' => 16423,
                    'foobar' => null
                ]
            ],
            'Nested arrays' => [
                [
                    'a' => 1,
                    'b' => 2 ,
                    'c' => [
                        1,
                        2 => [
                            1 => 1,
                            2 => 2,
                            3 => 3
                        ],
                        null
                    ]
                ]
            ],
        ];
    }
}
