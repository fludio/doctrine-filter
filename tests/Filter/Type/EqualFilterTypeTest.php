<?php

namespace BiteCodes\DoctrineFilter\Tests\Filter\Type;

use BiteCodes\DoctrineFilter\FilterBuilder;
use BiteCodes\DoctrineFilter\Type\EqualFilterType;
use BiteCodes\DoctrineFilter\Tests\Dummy\Entity\Post;
use BiteCodes\DoctrineFilter\Tests\Dummy\LoadFixtures;
use BiteCodes\DoctrineFilter\Tests\Dummy\TestCase;
use BiteCodes\DoctrineFilter\Tests\Dummy\Traits\TestFilterTrait;

class EqualFilterTypeTest extends TestCase
{
    use LoadFixtures, TestFilterTrait;

    public function getFilterDefinition()
    {
        return function (FilterBuilder $builder) {
            $builder
                ->add('title', EqualFilterType::class)
                ->add('content', EqualFilterType::class)
                ->add('isPublished', EqualFilterType::class);
        };
    }

    /** @test */
    public function it_returns_an_entity_if_the_search_value_is_exactly_the_same()
    {
        $posts = $this->em->getRepository(Post::class)->filter($this->filter, [
            'title' => 'Post title with Tag 1'
        ]);

        $this->assertCount(1, $posts);
        $this->assertEquals('Post title with Tag 1', $posts[0]->getTitle());
    }

    /** @test */
    public function it_returns_no_results_if_there_is_no_entity_with_the_exact_value()
    {
        $posts = $this->em->getRepository(Post::class)->filter($this->filter, [
            'title' => 'Another title'
        ]);

        $this->assertCount(0, $posts);
    }

    /** @test */
    public function it_works_with_boolean_values()
    {
        $posts = $this->em->getRepository(Post::class)->filter($this->filter, [
            'isPublished' => false
        ]);

        $this->assertCount(1, $posts);

        $posts = $this->em->getRepository(Post::class)->filter($this->filter, [
            'isPublished' => true
        ]);

        $this->assertCount(0, $posts);
    }

    /** @test */
    public function case_sensitivity_can_be_turned_off()
    {
        $this->filter->defineFilter(function (FilterBuilder $builder) {
            $builder
                ->add('title', EqualFilterType::class, ['case_sensitive' => false]);
        });

        $posts = $this->em->getRepository(Post::class)->filter($this->filter, [
            'title' => 'post title with TAG 1'
        ]);

        $this->assertCount(1, $posts);
        $this->assertEquals('Post title with Tag 1', $posts[0]->getTitle());
    }
}
