<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Tests\Composite;


use Instinct\Component\TypeAutoBoxing\Composite\Storage;

use Instinct\Component\TypeAutoBoxing\Tests\TestObject;
use Instinct\Component\TypeAutoBoxing\Tests\TypeTestCase;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
class StorageTest extends TypeTestCase
{
    public function getSetAndGet()
    {
        $testObject = new TestObject();

        return array(
            array(null, array()),
            array(true, array(true)),
            array(false, array(false)),
            array(0, array(0)),
            array(1, array(1)),
            array(123, array(123)),
            array(-123, array(-123)),
            array(array(), array()),
            array(array("dfd"), array("dfd")),
            array(0.0, array(0.0)),
            array(0.123, array(0.123)),
            array("dtgg", array('dtgg')),
            array("0", array('0')),
            array($testObject, array($testObject)),
            array(new \SimpleXMLElement("<a></a>"), array()),
            array(new \SimpleXMLElement("<a>true</a>"), array()),
            array(STDOUT, array(STDOUT)),
        );
    }
}
