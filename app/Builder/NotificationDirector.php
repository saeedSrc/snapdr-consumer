<?php
namespace App\Builder;

class NotificationDirector
{
    public function build(NotificationBuilderInterface $builderInterface, NotificationBuilder $builder)
    {
        $builderInterface->push($builder->to, $builder->name, $builder->massage);
    }
}
