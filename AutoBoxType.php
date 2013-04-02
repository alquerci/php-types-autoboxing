<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing;

use Instinct\Component\TypeAutoBoxing\Memory\Memory;

/**
 * Extend it to enforce strong typing.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 */
abstract class AutoBoxType extends Type
{
    /**
     * @var integer|string
     */
    private $memoryId;

    /**
     * Use strong typing to ensure a certain type.
     *
     * Declares a new pointer and assign it year object.
     *
     * @param NULL  $pointer
     * @param mixed $value [Optional]
     *
     * @throws \LogicException When trying to redefine a pointer.
     */
    final static public function create(&$pointer, $value = NULL)
    {
        if ($pointer !== null) {
            throw new \LogicException('Trying to redefine a pointer.');
        }

        $pointer = new static($value);

        // Allocate the pointer.
        $pointer->memoryId = Memory::alloc($pointer);
    }

    final public function __destruct()
    {
        if ($this->memoryId === null) {
            return;
        }

        $pointer = &Memory::getReferenceById($this->memoryId);

        if ($pointer !== $this && $pointer !== null) {
            if ($pointer instanceof static) {
                $pointer = clone $pointer;
            } else {
                if (is_object($pointer)) {
                    $pointer = clone $pointer;
                }

                $pointer = new static($pointer);
            }

            // Relocate the pointer.
            $pointer->memoryId = Memory::alloc($pointer);
        }

        // Removing the obsolete pointer.
        Memory::free($this->memoryId);
    }
}
