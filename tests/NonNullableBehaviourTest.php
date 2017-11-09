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

use InvalidArgumentException;
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

            public function test($data): void
            {
                $this->checkNotNullable($data);
            }
        };
    }

    final public function testShouldThrowExceptionWhenInvalidTypePassed($data): void
    {
        $this->expectException(InvalidArgumentException::class);

        self::$class->test($data);
    }

    final public function testShouldThrowExceptionWhenObjectHasNullProperties(): void
    {
        $this->expectException(InvalidArgumentException::class);

        self::$class = 1; // Deconstruct $class
    }


    final public function dataProvider(): array
    {
        return [
            'Using null' => [null],
            'Using NULL constant' => [NULL],
        ];
    }
}
