<?php

namespace Amazing79\Simplex\Simplex\Events;

enum KernelEvents: string
{
    case Response = 'kernel.response';
    case NotFound = 'kernel.not_found';
    case Request = 'kernel.request';
    case Redirect = 'kernel.redirect';
    case kernelException = 'kernel.exception';
    case NotAuthorized = 'kernel.not_authorized';
}
