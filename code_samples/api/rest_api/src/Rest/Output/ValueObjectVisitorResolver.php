<?php declare(strict_types=1);

namespace App\Rest\Output;

use Ibexa\Contracts\Rest\Output\ValueObjectVisitor;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitorResolverInterface;

class ValueObjectVisitorResolver implements ValueObjectVisitorResolverInterface
{
    /** @var array<string, ValueObjectVisitor> */
    private array $visitors;

    private ValueObjectVisitorResolverInterface $valueObjectVisitorResolver;

    /** @param iterable<string, ValueObjectVisitor> $visitors */
    public function __construct(iterable $visitors, ValueObjectVisitorResolverInterface $resolver)
    {
        $this->visitors = [];
        foreach ($visitors as $type => $visitor) {
            $this->visitors[$type] = $visitor;
        }
        $this->valueObjectVisitorResolver = $resolver;
    }

    public function resolveValueObjectVisitor(object $object): ?ValueObjectVisitor
    {
        $className = get_class($object);
        if (isset($this->visitors[$className])) {
            return $this->visitors[$className];
        }

        return $this->valueObjectVisitorResolver->resolveValueObjectVisitor($object);
    }
}
