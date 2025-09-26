<?php

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\PropertyInfo\Type;

final class DistanceFilter extends AbstractFilter
{
    protected function filterProperty(
        string $property,
        $value,
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        ?Operation $operation = null,
        array $context = []
    ): void {}

    public function getDescription(string $resourceClass): array
    {
        return [
            'lat' => [
                'property' => null,
                'type' => Type::BUILTIN_TYPE_FLOAT,
                'required' => false
            ],
            'lng' => [
                'property' => null,
                'type' => Type::BUILTIN_TYPE_FLOAT,
                'required' => false
            ],
            'distance' => [
                'property' => null,
                'type' => Type::BUILTIN_TYPE_FLOAT,
                'required' => false
            ],
        ];
    }
}