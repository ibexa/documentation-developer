<?php declare(strict_types=1);

namespace App\Rest\Output;

use Ibexa\Contracts\Rest\Output\ValueObjectVisitor;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitorResolverInterface;

class ValueObjectVisitorResolver implements ValueObjectVisitorResolverInterface
{
    /** @var array<string, ValueObjectVisitor> */
    private array $visitors;

    /** @param iterable<string, ValueObjectVisitor> $visitors */
    public function __construct(iterable $visitors, private readonly ValueObjectVisitorResolverInterface $valueObjectVisitorResolver)
    {
        $this->visitors = [];
        foreach ($visitors as $type => $visitor) {
            $this->visitors[$type] = $visitor;
        }
    }

    public function resolveValueObjectVisitor(object $object): ?ValueObjectVisitor
    {
        $className = $object::class;

        return $this->visitors[$className] ?? $this->valueObjectVisitorResolver->resolveValueObjectVisitor($object);
    }
}
