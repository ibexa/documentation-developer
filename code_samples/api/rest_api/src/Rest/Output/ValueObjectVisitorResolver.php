<?php declare(strict_types=1);

namespace App\Rest\Output;

use Ibexa\Contracts\Rest\Output\ValueObjectVisitor;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitorResolverInterface;

class ValueObjectVisitorResolver implements ValueObjectVisitorResolverInterface
{
    private array $visitors;

    private ValueObjectVisitorResolverInterface $valueObjectVisitorResolver;

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
