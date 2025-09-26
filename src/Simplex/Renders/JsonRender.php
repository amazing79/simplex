<?php

namespace Amazing79\Simplex\Simplex\Renders;

use Symfony\Component\HttpFoundation\JsonResponse;

class JsonRender implements RenderStrategy
{
    private int $statusCode;

    public function __construct(int $statusCode = 200)
    {

        $this->statusCode = $statusCode;
    }
    public function render(string $template = '', array $parameters = []): JsonResponse
    {
        $data = [];
        $data['data'] = $parameters;
        $data['code'] = $this->statusCode;
        return new JsonResponse($data, $this->statusCode);
    }
}