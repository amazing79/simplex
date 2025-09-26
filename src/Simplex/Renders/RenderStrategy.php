<?php

namespace Amazing79\Simplex\Simplex\Renders;

interface RenderStrategy
{
    public function render(string $template = '', array $parameters = []);
}