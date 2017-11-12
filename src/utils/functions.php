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

/**
 * Define global function is_nullable
 *
 */
if (!function_exists('is_nullable')) {

  /**
   * Check if a variable is Nullable
   *
   * Accepts any number of parameters each of which will be checked to see if
   * they are null (or nullable). If any are null then true will be returned
   * otherwise the function will return false.
   * This function is recursive so any arrays will be iterated including child
   * arrays.
   *
   * @param mixed ...$args  Variadic paramaters
   * @return bool           False if no paramaters are null, true otherwise
   */
  function is_nullable(...$args): bool
  {
      foreach ($args as $arg) {
          if (is_array($arg) || $arg instanceof Traversable) {
              if (is_nullable(extract(
                  $arg,
                  EXTR_PREFIX_INVALID | EXTR_REFS,
                  bin2hex(random_bytes(32))
              ))) {
                  return true;
              }
          } elseif (!isset($arg) || is_null($arg) || gettype($arg) === NULL) {
              return true;
          }
      }

      return false;
  }
}
