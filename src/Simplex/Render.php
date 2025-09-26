<?php

namespace Amazing79\Simplex\Simplex;

use Amazing79\Simplex\Simplex\Renders\RenderStrategy;
use Symfony\Component\HttpFoundation\Response;

class Render
{
    public function __construct(private readonly RenderStrategy $strategy)
    {
    }

    public function render(string $template, array $parameters = []): Response
    {
        return $this->strategy->render($template, $parameters);
    }
}