<?php
namespace App\Builder;
use \App\Builder\NotificationBuilderInterface;
use \App\Builder\NotificationBuilder;

class NotificationDirector
{
    public function build(NotificationBuilderInterface $builderInterface, NotificationBuilder $builder)
    {
        $builderInterface->push($builder->to, $builder->name, $builder->massage);
    }
}
