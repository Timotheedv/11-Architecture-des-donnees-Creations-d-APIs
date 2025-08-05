<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RatingSubscriber implements EventSubscriberInterface
{
    public function onDoctrineOrmEntityListener($event): void
    {
        // ...
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'doctrine.orm.entity_listener' => 'onDoctrineOrmEntityListener',
        ];
    }
}
