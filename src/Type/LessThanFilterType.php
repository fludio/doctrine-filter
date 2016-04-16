<?php

namespace BiteCodes\DoctrineFilter\Type;

use BiteCodes\DoctrineFilter\FilterBuilder;

class LessThanFilterType extends AbstractFilterType
{
    public function expand(FilterBuilder $filterBuilder, $value, $table, $field)
    {
        $qb = $filterBuilder->getQueryBuilder();

        return $qb
            ->andWhere($qb->expr()->lt($table . '.' . $field, $filterBuilder->placeValue($value)));
    }
}
