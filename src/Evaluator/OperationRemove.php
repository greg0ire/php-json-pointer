<?php

namespace Remorhaz\JSON\Pointer\Evaluator;

use Remorhaz\JSON\Data\WriterInterface;
use Remorhaz\JSON\Pointer\Locator\Locator;
use Remorhaz\JSON\Pointer\Locator\Reference;

/**
 * Implements 'remove' operation compliant with RFC-6902.
 */
class OperationRemove extends Operation
{

    protected $writer;


    public function __construct(Locator $locator, WriterInterface $writer)
    {
        parent::__construct($locator);
        $this->writer = $writer;
    }


    public function perform()
    {
        if (empty($this->locator->getReferenceList())) {
            throw new EvaluatorException("Data root can't be removed");
        }
        parent::perform();
        if ($this->writer->isElement()) {
            $this->writer->removeElement();
        } elseif ($this->writer->isProperty()) {
            $this->writer->removeProperty();
        } else {
            throw new LogicException("Failed to remove data at '{$this->locator->getText()}'");
        }
        return $this;
    }


    protected function applyReference(Reference $reference)
    {
        if ($this->writer->isArray()) {
            if ($reference->getType() != $reference::TYPE_INDEX) {
                throw new EvaluatorException(
                    "Invalid index '{$reference->getKey()}' at '{$reference->getPath()}''"
                );
            }
            $index = (int) $reference->getKey();
            $this->writer->selectElement($index);
            if (!$this->writer->hasData()) {
                throw new EvaluatorException("No element #{$index} at '{$reference->getPath()}'");
            }
        } elseif ($this->writer->isObject()) {
            $property = (string) $reference->getKey();
            $this->writer->selectProperty($property);
            if (!$this->writer->hasData()) {
                throw new EvaluatorException("No property '{$property}' at '{$reference->getPath()}'");
            }
        } else {
            throw new EvaluatorException("Scalar data at '{$reference->getPath()}'");
        }
        return $this;
    }
}
