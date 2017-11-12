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
     * Sanity-check all object properties
     *
     * When an immutable object is deconstruced then its state should be that of
     * when it was constructed. This checks all accessible properties and if any
     * are null then an exception is thrown.
     *
     * @return void
     * @throws RuntimeException
     */
    public function __destruct()
    {
        if (is_nullable(get_object_vars($this))) {
            throw new RuntimeException(sprintf(
                'A property in %s has been set to null, which is not allowed.',
                get_class($this)
            ));
        }
    }
}
