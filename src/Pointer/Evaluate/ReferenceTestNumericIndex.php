<?php

namespace Remorhaz\JSONPointer\Pointer\Evaluate;

class ReferenceTestNumericIndex extends ReferenceAdvanceable
{


    protected function performNonExisting()
    {
        $result = false;
        return $this->setResult($result);
    }
}
