<?php

namespace Remorhaz\JSONPointer\Pointer\Evaluate;

class ReferenceTestProperty extends ReferenceAdvanceable
{


    protected function createAdvancer()
    {
        return AdvancerProperty::factory();
    }


    protected function performNonExisting()
    {
        $result = false;
        return $this->setResult($result);
    }
}
