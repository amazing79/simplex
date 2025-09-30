<?php

namespace Amazing79\Simplex\Simplex\Renders;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HtmlRender implements RenderStrategy
{
    private string $assets_path;

    public function __construct()
    {
        $relative_path = $this->makeRelativePath() ?? $_ENV['APP_PATH'];
        $this->assets_path = $relative_path . '/assets';
    }
    public function render(string $template = '', array $parameters = []): Response
    {
        extract($parameters, EXTR_SKIP);
        ob_start();
        include sprintf(APP_ROOT .'/app/Views/%s.php', $template);
        $response = new Response(ob_get_clean());
        $response->headers->set('Content-Type', 'text/html');
        return $response;
    }

    private function includeAsset(string $asset): string
    {
        return $this->assets_path . $asset;
    }

    private function makeRelativePath(): string
    {
        $context = Request::createFromGlobals();
        return $context->getBasePath();
    }
}