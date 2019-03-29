<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 02.03.2019
 * Time: 20:51
 */

namespace shop\dispatchers;


use yii\di\Container;

class SimpleEventDispatcher implements EventDispatcher
{

    private $container;

    private $listeners;

    public function __construct(Container $container, array $listeners)
    {
        $this->container = $container;
    }

    public function dispatch($event): void
    {
        $eventName = get_class($event);
        if (array_key_exists($eventName, $this->listeners)) {
            foreach ($this->listeners[$eventName] as $listenerClass) {
                $listenerHandler = $this->resolveListenerHandler($listenerClass);
                $listenerHandler($event);
            }
        }
    }

    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    private function resolveListenerHandler($class)
    {
        return [$this->container->get($class), 'handle'];
    }
}