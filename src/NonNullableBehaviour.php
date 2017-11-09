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

namespace simondeeley;

use Throwable;
use InvalidArgumentException;
use RuntimeException;

/**
 * Non-nullable Behavior
 *
 * This trait adds a reusable method to type-check variables to ensure they
 * are not null. It also provides a sanity check object desctructor that runs
 * checks on all accessible properties of an object to ensure they are not set
 * to null.
 */
trait NonNullableBehaviour
{
    /**
     * Type-check a variable
     *
     * Checks that the passed variable $arg is not nullable against all of the
     * PHP implemented NULL types. If any checks are positive, then an exception
     * is thrown.
     *
     * @param mixed $arg
     * @param Throwable $exception
     * @return void
     * @throws Throwable
     */
    final protected function checkNotNullable($arg, Throwable $exception = null): void
    {
        if ($exception === null) {
            $exception = new InvalidArgumentException(sprintf(
                'A nullable or NULL argument was passed in %s',
                get_class($this)
            ));
        }

        if (false === isset($arg)
            || null == $arg
            || NULL === $arg
            || is_null($arg)
        ) {
            throw $exception;
        }
    }

    /**
     * Sanity-check all object properties
     *
     * When an immutable object is deconstruced then its state should be that of
     * when it was constructed. This checks all accessible properties and if any
     * are null then an exception is thrown.
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function __destruct()
    {
        foreach (get_object_vars($this) as $key => $value) {
            $this->checkNotNullable($value, new RuntimeException());
        }
    }
}
