<?php

namespace Amazing79\Simplex\Simplex;

use Amazing79\Simplex\Simplex\Events\KernelEvents;
use Amazing79\Simplex\Simplex\Events\RequestEvent;
use Amazing79\Simplex\Simplex\Events\ResponseEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Framework
{
    public function __construct(
        private EventDispatcherInterface    $dispatcher,
        private UrlMatcherInterface         $matcher,
        private ControllerResolverInterface $controllerResolver,
        private ArgumentResolverInterface   $argumentResolver,
    ) {
    }

    public function handle(Request $request): Response
    {
        $this->matcher->getContext()->fromRequest($request);

        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));
            $this->dispatcher->dispatch(new RequestEvent($request), KernelEvents::Request->value);
            $controller = $this->controllerResolver->getController($request);
            $arguments = $this->argumentResolver->getArguments($request, $controller);

            $response = call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $exception) {
            $response = new Response($exception->getMessage(), Response::HTTP_NOT_FOUND);
            $this->dispatcher->dispatch(new ResponseEvent($response, $request), KernelEvents::NotFound->value);
            return $response;
        } catch (AccessDeniedHttpException $exception) {
            $response = new Response($exception->getMessage(), Response::HTTP_FORBIDDEN);
            $this->dispatcher->dispatch(new ResponseEvent($response, $request), KernelEvents::NotAuthorized->value);
            return $response;
        } catch (\Exception $exception) {
            $response = new Response($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            $this->dispatcher->dispatch(new ResponseEvent($response, $request), KernelEvents::kernelException->value);
            return $response;
        }
        // dispatch a response event
        $this->dispatcher->dispatch(new ResponseEvent($response, $request), KernelEvents::Response->value );

        return $response;
    }
}