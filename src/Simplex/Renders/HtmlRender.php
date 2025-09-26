<?php

namespace Amazing79\Simplex\Simplex\Renders;

use Symfony\Component\HttpFoundation\Response;

class HtmlRender implements RenderStrategy
{
    private string $assets_path;

    public function __construct()
    {
        $this->assets_path = isset($_ENV['APP_PATH']) ? $_ENV['APP_PATH'] .'/assets': '/assets';
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
}