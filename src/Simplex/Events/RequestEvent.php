<?php

namespace Amazing79\Simplex\Simplex\Events;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class RequestEvent extends Event
{
    public function __construct(
        private readonly Request $request,
    ) {
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}