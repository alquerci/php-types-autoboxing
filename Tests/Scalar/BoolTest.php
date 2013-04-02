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
use Instinct\Component\TypeAutoBoxing\Scalar\Bool;

/**
 * It used to enforce strong typing of the bool type.
 *
 * @author Alexandre Quercia <alquerci@email.com>
 */
class BoolTest extends TypeTestCase
{
    public function getSetAndGet()
    {
        return array(
            array(null, false),
            array(true, true),
            array(false, false),
            array(0, false),
            array(1, true),
            array(123, true),
            array(-123, true),
            array(array(), false),
            array(array("dfd"), true),
            array(0.0, false),
            array(0.123, true),
            array("dtgg", true),
            array("0", false),
            array(new TestObject(), true),
            array(new \SimpleXMLElement("<a></a>"), false),
            array(new \SimpleXMLElement("<a>true</a>"), true),
            array(STDOUT, true),
        );
    }
}
