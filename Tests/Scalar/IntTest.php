<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Tests\Scalar;


use Instinct\Component\TypeAutoBoxing\Tests\TestObject;
use Instinct\Component\TypeAutoBoxing\Tests\TypeTestCase;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
class IntTest extends TypeTestCase
{
    public function getSetAndGet()
    {
        return array(
            array(null, 0),
            array(true, 1),
            array(false, 0),
            array(0, 0),
            array(1, 1),
            array(123, 123),
            array(-123, -123),
            array(array(), new \UnexpectedValueException($this->formatSetMethodExceptionMessage('array'))),
            array(array("dfd"), new \UnexpectedValueException($this->formatSetMethodExceptionMessage('array'))),
            array(0.0, 0),
            array(0.123, 0),
            array("dtgg", 0),
            array("10dtgg", 10),
            array("0", 0),
            array(new TestObject(), new \UnexpectedValueException($this->formatSetMethodExceptionMessage('object'))),
            array(new \SimpleXMLElement("<a></a>"), new \UnexpectedValueException($this->formatSetMethodExceptionMessage('object'))),
            array(new \SimpleXMLElement("<a>true</a>"),new \UnexpectedValueException($this->formatSetMethodExceptionMessage('object'))),
            array(STDOUT, new \UnexpectedValueException($this->formatSetMethodExceptionMessage('resource'))),
        );
    }
}
