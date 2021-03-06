<?php

/*
 * (c) Alexandre Quercia <alquerci@email.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Instinct\Component\TypeAutoBoxing\Tests\Memory;

use Instinct\Component\TypeAutoBoxing\Memory\GarbageCollector;

/**
 * @author Alexandre Quercia <alquerci@email.com>
 */
class GarbageCollectorTest extends \PHPUnit_Framework_TestCase
{
    public function test__construct()
    {
    }

    public function testenable()
    {
    }

    public function testdisable()
    {
    }

    public function testregister()
    {
    }

    public function testcollect()
    {
        GarbageCollector::collect();

        $a = array();
        $coll = array(&$a);
        GarbageCollector::register($coll);

        $a['self'] = $a;
        unset($a);

        $this->assertSame(1, GarbageCollector::collect());
    }

    public function testdoCollect()
    {
    }

    public function testrefCount()
    {
        $r = new \ReflectionClass('Instinct\Component\TypeAutoBoxing\Memory\GarbageCollector');
        $m = $r->getMethod('refcount');
        if (!$m instanceof \ReflectionMethod) {
            return;
        }
        $m->setAccessible(true);

        $this->assertSame(1, $m->invokeArgs(null, array(&$this)));
    }
}
