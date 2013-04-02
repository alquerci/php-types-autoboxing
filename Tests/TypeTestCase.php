<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Tests;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
class TypeTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider getSetAndGet
     */
    public function testSetAndGet($value, $expected)
    {
        $class = str_replace(array('Tests\\', 'Test'), '', get_called_class());

        if ($expected instanceof \Exception) {
            $this->setExpectedException(get_class($expected), $expected->getMessage());
        }

        $object = new $class($value);

        $this->assertSame($expected, $object->get());
    }
}

class TestObject
{
}
