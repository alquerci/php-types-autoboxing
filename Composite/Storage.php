<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Composite;

/**
 * It used to enforce strong typing of the array type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 *
 * @api
 */
class Storage extends Composite implements \SeekableIterator, \RecursiveIterator, \ArrayAccess, \Countable
{
    /**
     * @var array
     */
    private $array;

    /**
     * @var int
     */
    private $size = 0;

    // Methods for the interface Iterator \\

    /**
     * Returns the key of the current element.
     *
     * @return mixed
     */
    public function key()
    {
        return key($this->array);
    }

    /**
     * Returns the current element.
     *
     * @return mixed
     */
    public function current()
    {
        return current($this->array);
    }

    /**
     * Moves to the next item.
     */
    public function next()
    {
        do {
            $v = next($this->array);
        } while ($v === null);
    }

    /**
     * Rewind the internal array pointer.
     */
    public function prev()
    {
        do {
            $v = prev($this->array);
        } while ($v === null);
    }

    /**
     * Checks whether the current position is valid.
     *
     * @return boolean
     */
    public function valid()
    {
        if ($this->key() === null) {
            return false;
        }

        return true;
    }

    /**
     * Replace the iterator to the first element.
     */
    public function rewind()
    {
        $v = reset($this->array);

        if ($v === null) {
            $this->next();
        }
    }

    // Methodes pour l'interface ArrayAccess \\
    /**
     * Indicates whether the index exists.
     *
     * @param mixed $index
     * @return boolean
     */
    public function offsetExists($index)
    {
        if (is_object($index)) {
            if (method_exists($index, "__toString")) {
                $index = $index->__toString();
            } else {
                $index = spl_object_hash($index);
            }
        }

        return array_key_exists($index, $this->array);
    }

    /**
     * Returns the value at the given index.
     *
     * @param mixed $index
     * @return mixed
     */
    public function offsetGet($index)
    {
        if (is_object($index)) {
            if (method_exists($index, "__toString")) {
                $index = $index->__toString();
            } else {
                $index = spl_object_hash($index);
            }
        }

        if ($this->offsetExists($index) !== false) {
            return $this->array[$index];
        }

        return null;
    }

    /**
     * Assign a value to the given index.
     *
     * @param mixed $index
     * @param mixed $value
     */
    public function offsetSet($index, $value)
    {
        if ($index === null) {
            if ($value !== null) {
                $this->size++;
            }

            $this->array[] = $value;
        } else {
            if (is_object($index)) {
                if (method_exists($index, "__toString")) {
                    $index = $index->__toString();
                } else {
                    $index = spl_object_hash($index);
                }
            }

            if ($this->offsetExists($index) !== false) {
                $this->array[$index] = $value;
            } else {
                $this->size++;
                $this->array[$index] = $value;
            }
        }
    }

    /**
     * Destroyed the element at index $index.
     *
     * @param mixed $index
     */
    public function offsetUnset($index)
    {
        if (is_object($index)) {
            if (method_exists($index, "__toString")) {
                $index = $index->__toString();
            } else {
                $index = spl_object_hash($index);
            }
        }

        if ($this->offsetExists($index) !== false) {
            $this->size--;
            $this->array[$index] = null;
        }
    }

    // Methodes pour l'interface Countable \\

    /**
     * Counts the number of array elements.
     *
     * @return int
     */
    public function count()
    {
        return $this->size;
    }

    // Methodes pour l'interface SeekableIterator \\

    /**
     * Seeks to a position
     *
     * @param int $position
     * @throws \OutOfBoundsException
     */
    public function seek($position)
    {
        if (is_object($position)) {
            if (method_exists($position, "__toString")) {
                $position = (string) $position;
            } else {
                throw new \OutOfBoundsException(sprintf(
                    'The class "%s" must define "__toString" method '.
                    'to be a valid seekable position.',
                    get_class($position)
                ));
            }
        }

        $position = (int) $position;

        if ($position < $this->size) {
            $this->rewind();
            for ($i = 0 ; $i < $position ; $i++) {
                $this->next();
            }
        } else {
            throw new \OutOfBoundsException(sprintf(
                'The position "%d" is not seekable.',
                $position
            ));
        }
    }

    // Methodes pour l'interface RecursiveIterator \\

    /**
     * Checks whether the value of the current index is
     * an object \ Traversable or array.
     *
     * @return boolean
     */
    public function hasChildren()
    {
        $child = $this->current();

        if ($child instanceof \RecursiveIterator) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns an RecursiveIterator for the current entry.
     *
     * @throws \LogicException
     * <p>The current entry does not contain a RecursiveIterator</p>
     * @return \RecursiveIterator
     */
    public function getChildren()
    {
        $child = $this->current();

        if ($child instanceof \RecursiveIterator) {
            return $child;
        } else {
            throw new \LogicException(sprintf(
                'The current entry "%s" does not contain a RecursiveIterator.',
                $this->key()
            ));
        }
    }

    /**
     * @return array
     */
    public function get()
    {
        return iterator_to_array($this, true);
    }

    protected function clear()
    {
        $this->array = array();
        $this->size = 0;
    }

    /**
     * @param string $value
     *
     * @return boolean
     */
    protected function fromString($value)
    {
        $this->array = (array) $value;
        $this->size = 1;

        return true;
    }

    /**
     * @param resource $value
     *
     * @return boolean
     */
    protected function fromResource($value)
    {
        $this->array = (array) $value;
        $this->size = 1;

        return true;
    }

    /**
     * @param int $value
     *
     * @return boolean
     */
    protected function fromInt($value)
    {
        $this->array = (array) $value;
        $this->size = 1;

        return true;
    }

    /**
     * @param double $value
     *
     * @return boolean
     */
    protected function fromDouble($value)
    {
        $this->array = (array) $value;
        $this->size = 1;

        return true;
    }

    /**
     * @param bool $value
     *
     * @return boolean
     */
    protected function fromBool($value)
    {
        $this->array = (array) $value;
        $this->size = 1;

        return true;
    }

    /**
     * @param array $value
     *
     * @return boolean
     */
    protected function fromArray($value)
    {
        $this->size = count($value);
        $this->array = $value;

        return true;
    }


    /**
     * @param object $value
     *
     * @return boolean
     */
    protected function fromObject($value)
    {
        if ($value instanceof \Traversable) {
            $value = iterator_to_array($value, true);
        } else {
            $value = array($value);
        }

        return $this->fromArray($value);
    }
}
