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
        $class = $this->getTestedClass();

        if ($expected instanceof \Exception) {
            $this->setExpectedException(get_class($expected), $expected->getMessage());
        }

        $object = new $class($value);

        $this->assertSame($expected, $object->get());
    }

    protected function formatSetMethodExceptionMessage($type, $class = null)
    {
        if ($class === null) {
            $class = $this->getTestedClass();
        }

        return sprintf(
            'The value of type "%s" could not be converted to "%s".',
            $type,
            $class
        );
    }

    private function getTestedClass()
    {
        return str_replace(array('Tests\\', 'Test'), '', get_called_class());
    }
}

class TestObject
{
}
