<?php

namespace App\Rest\Output;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitorDispatcher as BaseValueObjectVisitorDispatcher;
use Ibexa\Contracts\Rest\Output\Visitor;

class ValueObjectVisitorDispatcher extends BaseValueObjectVisitorDispatcher
{
    private array $visitors;

    private BaseValueObjectVisitorDispatcher $valueObjectVisitorDispatcher;

    private Visitor $outputVisitor;

    private Generator $outputGenerator;

    public function __construct(iterable $visitors, BaseValueObjectVisitorDispatcher $valueObjectVisitorDispatcher)
    {
        $this->visitors = [];
        foreach ($visitors as $type => $visitor) {
            $this->visitors[$type] = $visitor;
        }
        $this->valueObjectVisitorDispatcher = $valueObjectVisitorDispatcher;
    }

    public function setOutputVisitor(Visitor $outputVisitor)
    {
        $this->outputVisitor = $outputVisitor;
        $this->valueObjectVisitorDispatcher->setOutputVisitor($outputVisitor);
    }

    public function setOutputGenerator(Generator $outputGenerator)
    {
        $this->outputGenerator = $outputGenerator;
        $this->valueObjectVisitorDispatcher->setOutputGenerator($outputGenerator);
    }

    public function visit($data)
    {
        $className = get_class($data);
        if (isset($this->visitors[$className])) {
            return $this->visitors[$className]->visit($this->outputVisitor, $this->outputGenerator, $data);
        }
        return $this->valueObjectVisitorDispatcher->visit($data);
    }
}
