<?php

namespace Simplex\Tests;

use Amazing79\Simplex\Simplex\Framework;
use Amazing79\Simplex\Simplex\Render;
use Amazing79\Simplex\Simplex\Renders\HtmlRender;
use App\Controllers\Index\IndexController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ArgumentResolverInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class FrameworkTest extends TestCase
{
    public function testNotFoundHandling(): void
    {
        $framework = $this->getFrameworkForException(new ResourceNotFoundException());

        $response = $framework->handle(new Request());

        $this->assertEquals(404, $response->getStatusCode());
    }

    private function getFrameworkForException($exception): Framework
    {
        $matcher = $this->createMock(Routing\Matcher\UrlMatcherInterface::class);

        $matcher
            ->expects($this->once())
            ->method('match')
            ->willThrowException($exception)
        ;
        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->willReturn($this->createMock(Routing\RequestContext::class))
        ;
        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $controllerResolver = $this->createMock(ControllerResolverInterface::class);
        $argumentResolver = $this->createMock(ArgumentResolverInterface::class);

        return new Framework($dispatcher, $matcher, $controllerResolver, $argumentResolver);
    }

    public function testErrorHandling(): void
    {
        $framework = $this->getFrameworkForException(new \RuntimeException());

        $response = $framework->handle(new Request());

        $this->assertEquals(500, $response->getStatusCode());
    }

    public function testControllerResponse(): void
    {
        $matcher = $this->createMock(Routing\Matcher\UrlMatcherInterface::class);

        $matcher
            ->expects($this->once())
            ->method('match')
            ->willReturn([
                '_route' => '/',
                '_controller' => [new IndexController(), 'index'],
            ])
        ;
        $matcher
            ->expects($this->once())
            ->method('getContext')
            ->willReturn($this->createMock(Routing\RequestContext::class))
        ;
        $dispatcher = $this->createMock(EventDispatcherInterface::class);
        $controllerResolver = new ControllerResolver();
        $argumentResolver = new ArgumentResolver();

        $framework = new Framework($dispatcher, $matcher, $controllerResolver, $argumentResolver);

        $response = $framework->handle(new Request());

        $this->assertEquals(200, $response->getStatusCode());
        $render = new Render(new HtmlRender());
        $this->assertEquals($render->render('index/index')->getContent(), $response->getContent());
    }
}
