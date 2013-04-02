<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Composite;

use Instinct\Component\TypeAutoBoxing\AutoBoxType;

/**
 * It used to enforce strong typing of the structure type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 */
abstract class Structure extends Storage
{
    static private $validClass = array();

    /**
     * Declare all properties:
     *
     * - Type::pnew($this->property1)
     * - Type::pnew($this->property2)
     * - ...
     *
     */
    abstract protected function register();

    /**
     * Returns an associative array with the name of the index properties.
     * Case sensitive.
     *
     * @return array
     */
    public function get()
    {
        $array = array();

        $static = new \ReflectionClass(get_called_class());
        $properties = $static->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach($properties as $property) {
            $name = $property->getName();
            $array[$name] = $this->$name->get();
        }

        return $array;
    }

    /**
     * @throws \LogicException
     */
    protected function clear()
    {
        $callClass = get_called_class();
        $this->register();

        if(in_array($callClass, self::$validClass)) {
            return;
        }

        // verification that all the property are instances of AutoBoxType
        $static = new \ReflectionClass(get_called_class());
        $properties = $static->getProperties(\ReflectionProperty::IS_PUBLIC);

        foreach ($properties as $property) {
            $name = $property->getName();
            if (! $this->$name instanceof AutoBoxType) {
                $message = ""
                . get_called_class()."->".$name." "
                . "property must point to an instance of "
                . "Instinct\\Component\\TypeAutoBoxing\\AutoBoxType"
                ;

                throw new \LogicException($message, E_PARSE);
            }
        }

        self::$validClass[] = $callClass;
    }

    /**
     * @param array $value
     *
     * @return boolean
     */
    protected function fromArray($value)
    {
        try {
            foreach ($value as $name => $property) {
                if (property_exists($this, $name)) {
                    $this->$name = $property;
                }
            }
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }

}
