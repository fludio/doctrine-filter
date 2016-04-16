<?php

namespace BiteCodes\DoctrineFilter\Type;

use BiteCodes\DoctrineFilter\FilterBuilder;

class GreaterThanEqualFilterType extends AbstractFilterType
{
    public function expand(FilterBuilder $filterBuilder, $value, $table, $field)
    {
        $qb = $filterBuilder->getQueryBuilder();

        return $qb
            ->andWhere($qb->expr()->gte($table . '.' . $field, $filterBuilder->placeValue($value)));
    }
}
