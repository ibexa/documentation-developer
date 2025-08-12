<?php declare(strict_types=1);

namespace App\Rest\Output;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitorDispatcher as BaseValueObjectVisitorDispatcher;
use Ibexa\Contracts\Rest\Output\Visitor;

class ValueObjectVisitorDispatcher // extends BaseValueObjectVisitorDispatcher TODO: Rewrite this example in  https://issues.ibexa.co/browse/IBX-8190
{
    private array $visitors;

    private Visitor $outputVisitor;

    private Generator $outputGenerator;

    public function __construct(
        iterable $visitors,
        private readonly BaseValueObjectVisitorDispatcher $valueObjectVisitorDispatcher
    ) {
        $this->visitors = [];
        foreach ($visitors as $type => $visitor) {
            $this->visitors[$type] = $visitor;
        }
    }

    public function setOutputVisitor(Visitor $outputVisitor): void
    {
        $this->outputVisitor = $outputVisitor;
        $this->valueObjectVisitorDispatcher->setOutputVisitor($outputVisitor);
    }

    public function setOutputGenerator(Generator $outputGenerator): void
    {
        $this->outputGenerator = $outputGenerator;
        $this->valueObjectVisitorDispatcher->setOutputGenerator($outputGenerator);
    }

    public function visit($data)
    {
        $className = $data::class;
        if (isset($this->visitors[$className])) {
            return $this->visitors[$className]->visit($this->outputVisitor, $this->outputGenerator, $data);
        }

        return $this->valueObjectVisitorDispatcher->visit($data);
    }
}
