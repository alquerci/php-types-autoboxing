<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Tests;

use Instinct\Component\TypeAutoBoxing\AutoBoxType;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
class AutoBoxTypeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        TestAutoBox::create($pointer);

        $pointer = true;

        $this->assertInstanceOf('Instinct\Component\TypeAutoBoxing\Tests\TestAutoBox', $pointer);
        $this->assertSame(true, $pointer->get());
    }
}


class TestAutoBox extends AutoBoxType
{
    private $foo;

    public function __construct($value = null)
    {
        $this->foo = $value;
    }

    public function get()
    {
        return $this->foo;
    }

    public function clear()
    {
        $this->foo = null;
    }
}
