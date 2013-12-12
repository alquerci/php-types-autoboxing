<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing;

use Instinct\Component\TypeAutoBoxing\Type\TypeInterface;
use Instinct\Component\TypeAutoBoxing\Type\Types;
use Instinct\Component\TypeAutoBoxing\Memory\Memory;

/**
 * Extend it to enforce strong typing.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 */
final class AutoBoxer
{
    /**
     * @var integer|string
     */
    private $address;

    /**
     * @var mixed
     */
    private $pointer;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var TypeInterface
     */
    private $type;

    /**
     * Use strong typing to ensure a certain type.
     *
     * Declares a new pointer and assign it year object.
     *
     * @param TypeInterface|Types::*|NULL $type
     * @param &mixed                      $pointer
     * @param mixed                       $initialValue [Optional]
     */
    public function __construct($type, &$pointer, $initialValue = null)
    {
        if ($pointer !== null) {
            throw new \LogicException(sprintf(
                'The identifier of type "%s" is defined more than once. '.
                'The first argument of "%s::__construct()" must be null or undefined.',
                gettype($pointer),
                get_called_class()
            ));
        }

        $this->type = null === $type ? Types::get(Types::VOID) : Types::get($type);

        $pointer = $this;
        $this->pointer = &$pointer;
        $this->address = $this->type->operator('new', $pointer);

        if ($initialValue instanceof self) {
            $initialValue = $initialValue->value;
        }
        $this->value = $this->type->initialize($initialValue);
    }

    public function __destruct()
    {
        $value = $this->pointer;

        // Calls the value destructor
        $this->value = null;

        // Removes the obsolete pointer
        $this->type->operator('delete', $this->pointer, $this->address);

        if ($this === $value) {
            return;
        }

        if (null === $value) {
            return;
        }

        if ($value instanceof self) {
            $value = $value->value;
        }
        $this->type->operator('=', $newValue, $value);

        $this->pointer = null;
        new self($this->type, $this->pointer, $newValue);
    }

    /**
     * Gets the value
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Gets the type
     *
     * @return TypeInterface
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the value
     *
     * @param mixed $value
     */
    public function setValue($value)
    {
        if ($value instanceof self) {
            $value = $value->value;
        }

        $this->type->operator('=', $this->value, $value);
    }
}
