<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Type;

use Instinct\Component\TypeAutoBoxing\Memory\Memory;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
abstract class Type implements TypeInterface
{
    protected $parameters = array();
    protected $defaultValueSet = true;
    protected $defaultValue = null;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        $this->parameters = $parameters;
    }

    /**
     * {@inheritDoc}
     */
    public function initialize($initialValue = null)
    {
        if (null === $initialValue && $this->hasDefaultValue()) {
            return $this->getDefaultValue();
        }

        return $this->finalize($initialValue);
    }

    /**
     * {@inheritDoc}
     */
    public function &operator($operator, &$leftValue, $rightValue = null)
    {
        switch ($operator) {
            case '=':
                if ($leftValue === $rightValue) {
                    // Auto-assignment

                    return $leftValue;
                }

                $value = $this->normalize($rightValue);
                $value = $this->finalize($value);

                $leftValue = $value;

                return $leftValue;

            case 'new':
                $result = Memory::alloc($leftValue);

                return $result;

            case 'delete':
                $result = Memory::free($rightValue);

                return $result;

            default:
                throw new \LogicException(sprintf('"%s" does not define the operator "%s"', get_class($this), $operator));
        }
    }

    /**
     * Returns true when the node has a default value
     *
     * @return Boolean If the node has a default value
     */
    protected function hasDefaultValue()
    {
        return $this->defaultValueSet;
    }

    /**
     * Returns the default value of the node.
     *
     * @return mixed The default value
     * @throws RuntimeException if the node has no default value
     */
    protected function getDefaultValue()
    {
        return $this->defaultValue;
    }


    /**
     * Normalizes the supplied value.
     *
     * @param mixed $value The value to normalize
     *
     * @return mixed The normalized value
     */
    final protected function normalize($value)
    {
        $value = $this->preNormalize($value);

        // validate type
        $this->validateType($value);

        // normalize value
        return $this->normalizeValue($value);
    }

    /**
     * Merges two values together
     *
     * @param mixed $leftSide
     * @param mixed $rightSide
     *
     * @return mixed The merged values
     */
    final protected function merge($leftSide, $rightSide)
    {
        $this->validateType($leftSide);
        $this->validateType($rightSide);

        return $this->mergeValues($leftSide, $rightSide);
    }

    /**
     * Finalizes a value
     *
     * @param &mixed $value The value to finalize
     *
     * @return &mixed The finalized value
     */
    final protected function finalize($value)
    {
        $this->validateType($value);

        $value = $this->finalizeValue($value);

        return $value;
    }

    /**
     * Normalizes the value before any other normalization is applied
     *
     * @param $value
     *
     * @return $value The normalized array value
     */
    protected function preNormalize($value)
    {
        return $value;
    }

    /**
     * Validates the type
     *
     * @param mixed $value The value to validate
     *
     * @throws \RuntimeException when the value is invalid
     */
    protected function validateType($value)
    {
    }

    /**
     * Normalizes the value
     *
     * @param mixed $value The value to normalize
     *
     * @return mixed The normalized value
     */
    protected function normalizeValue($value)
    {
        return $value;
    }

    /**
     * Merges two values together
     *
     * @param mixed $leftSide
     * @param mixed $rightSide
     *
     * @return mixed The merged value
     */
    protected function mergeValues($leftSide, $rightSide)
    {
        return $rightSide;
    }

    /**
     * Finalizes a value
     *
     * @param mixed $value The value to finalize
     *
     * @return mixed The finalized value
     */
    protected function finalizeValue($value)
    {
        return $value;
    }
}
