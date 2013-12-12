<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Tests;

use Instinct\Component\TypeAutoBoxing\Memory\Memory;

use Instinct\Component\TypeAutoBoxing\Type\Types;

use Instinct\Component\TypeAutoBoxing\Type\Boolean;

use Instinct\Component\TypeAutoBoxing\AutoBoxer as Ptr;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
class AutoBoxerTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        new Ptr(null, $foo);

        $this->assertInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $foo);

        $foo = null;
    }

    public function testLeftValue()
    {
        new Ptr(null, $foo);

        $foo = true;

        $this->assertInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $foo);
        $this->assertSame(true, $foo->getValue());

        $foo = null;
    }

    public function testRightValue()
    {
        new Ptr(null, $foo);

        $bar = true;
        $foo = $bar;

        $this->assertInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $foo);
        $this->assertNotInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $bar);
        $this->assertTrue($bar);
        $this->assertTrue($foo->getValue());
        $this->assertNotSame($bar, $foo);

        $foo = null;
    }

    public function testLeftValueWithInitialization()
    {
        new Ptr(null, $foo, false);

        $foo = true;

        $this->assertInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $foo);
        $this->assertTrue($foo->getValue());

        $foo = null;
    }

    public function testRightValueWithInitialization()
    {
        new Ptr(null, $foo, false);

        $bar = true;
        $foo = $bar;

        $this->assertInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $foo);
        $this->assertNotInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $bar);
        $this->assertTrue($bar);
        $this->assertTrue($foo->getValue());
        $this->assertNotSame($bar, $foo);

        $foo = null;
    }

    public function testLeftValueWithFixedType()
    {
        new Ptr(Types::BOOLEAN, $foo);

        $foo = true;

        $this->assertInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $foo);
        $this->assertSame(true, $foo->getValue());

        $foo = null;
    }

    public function testFunction()
    {
        new Ptr(Types::BOOLEAN, $foo, true);

        $self = $this;
        $closure = function ($foo) use ($self) {
            new Ptr(Types::BOOLEAN, $bar, $foo);

            $self->assertInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $bar);
            $self->assertSame(true, $bar->getValue());

            $bar = false;

            $self->assertInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $bar);
            $self->assertSame(false, $bar->getValue());

            $bar = null;
        };

        $closure($foo);

        $self->assertInstanceOf('Instinct\Component\TypeAutoBoxing\AutoBoxer', $foo);
        $self->assertSame(true, $foo->getValue());

        $foo = null;
    }
}
