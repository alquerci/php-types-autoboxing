<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Tests\Memory;

use Instinct\Component\TypeAutoBoxing\Memory\Memory;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
class MemoryTest extends \PHPUnit_Framework_TestCase
{
    public function testalloc()
    {
        $value = new \stdClass();

        $address = Memory::alloc($value);

        $value = null;
        $this->assertNull(Memory::get($address));
    }

    public function testget()
    {
        $value = new \stdClass();

        $address = Memory::alloc($value);

        $this->assertSame($value, Memory::get($address));
    }

    public function testfree()
    {
        $value = new \stdClass();

        $address = Memory::alloc($value);
        Memory::free($address);

        $this->assertNull(Memory::get($address));
        $this->assertInstanceOf('stdClass', $value);
    }
}
