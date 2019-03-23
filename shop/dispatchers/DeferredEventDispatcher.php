<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 04.03.2019
 * Time: 0:06
 */

namespace shop\dispatchers;


class DeferredEventDispatcher implements EventDispatcher
{

    private $defer = false;

    private $queue = [];

    private $next;

    public function __construct(SimpleEventDispatcher $next)
    {
        $this->next = $next;
    }

    public function defer()
    {
        $this->defer = true;
    }

    public function dispatch($event): void
    {
        if ($this->defer) {
            $this->queue[] = $event;
        } else {
            $this->next->dispatch($event);
        }
    }

    public function dispatchAll(array $events): void
    {
        foreach ($events as $event) {
            $this->dispatch($event);
        }
    }

    public function release()
    {
        foreach ($this->queue as $i => $event) {
            $this->next->dispatch($event);
            unset($this->queue[$i]);
        }
        $this->defer = false;
    }

    public function clean()
    {
        $this->queue = [];
        $this->defer = false;
    }
}