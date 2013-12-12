<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Type;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
class Enum extends Scalar
{
    private $values = array();

    /**
     * @param array $parameters
     *
     * @throws InvalidArgumentException
     */
    public function __construct(array $parameters = array())
    {
        if (!isset($parameters['enum.values']) || !is_array($parameters['enum.values'])) {
            throw new \InvalidArgumentException(sprintf('Missing "enum.values" parameter for an enum type.'));
        }

        $values = array_unique($parameters['enum.values']);
        if (count($values) <= 1) {
            throw new \InvalidArgumentException('The "enum.values" parameter for an enum type must contain at least two distinct elements.');
        }

        parent::__construct($parameters);

        $this->values = $values;
    }

    public function getValues()
    {
        return $this->values;
    }

    /**
     * {@inheritDoc}
     */
    protected function finalizeValue($value)
    {
        $value = parent::finalizeValue($value);

        if (!in_array($value, $this->values, true)) {
            throw new \RuntimeException(
                sprintf('The value %s is not allowed. Permissible values: %s',
                json_encode($value),
                implode(', ', array_map('json_encode', $this->values))
            ));
        }

        return $value;
    }
}
