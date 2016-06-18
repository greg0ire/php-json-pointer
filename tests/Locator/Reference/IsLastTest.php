<?php

namespace Remorhaz\JSONPointer\Test\Locator\Reference;

use Remorhaz\JSONPointer\Locator\Reference;

class IsLastTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @expectedException \Remorhaz\JSONPointer\Locator\Reference\Exception
     */
    public function testAccessingUninitializedIsLastThrowsException()
    {
        Reference::factory()->isLast();
    }


    /**
     * @expectedException \LogicException
     */
    public function testAccessingUninitializedIsLastThrowsSplException()
    {
        Reference::factory()->isLast();
    }


    public function testMarkAsLast()
    {
        $reference = Reference::factory()->markAsLast();
        $this->assertTrue($reference->isLast(), "Failed to set last reference flag in reference");
        return $reference;
    }


    /**
     * @param Reference $reference
     * @depends testMarkAsLast
     */
    public function testMarkAsNotLast(Reference $reference)
    {
        $reference->markAsNotLast();
        $this->assertFalse($reference->isLast(), "Failed to clear last reference flag in reference");
    }


    /**
     * @expectedException \Remorhaz\JSONPointer\Locator\Reference\Exception
     */
    public function testSetNotBooleanLastThrowsException()
    {
        Reference::factory()->setIsLast(0);
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testSetNotBooleanLastThrowsSplException()
    {
        Reference::factory()->setIsLast(0);
    }
}
