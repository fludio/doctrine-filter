<?php

namespace Fludio\DoctrineFilter\Tests\Dummy\Entity;

use Doctrine\ORM\EntityRepository;
use Fludio\DoctrineFilter\Filter\Traits\EntityFilterTrait;

class TransportRepo extends EntityRepository
{
    use EntityFilterTrait;
}