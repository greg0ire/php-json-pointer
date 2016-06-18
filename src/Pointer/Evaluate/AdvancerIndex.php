<?php

namespace Remorhaz\JSONPointer\Pointer\Evaluate;

abstract class AdvancerIndex extends Advancer
{


    public function canAdvance()
    {
        return array_key_exists($this->getKey(), $this->getCursor()->getData());
    }


    public function advance()
    {
        $data = &$this
            ->getCursor()
            ->getData()[$this->getKey()];
        $this
            ->getCursor()
            ->setData($data);
        return $this;
    }


    public function write($data)
    {
        $this->getCursor()->getData()[$this->getKey()] = $data;
        return $this;
    }


    public function fail()
    {
        throw new EvaluateException("Array index {$this->getKeyDescription()} is not found");
    }
}
