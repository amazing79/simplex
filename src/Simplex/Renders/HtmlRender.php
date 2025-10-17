<?php

namespace Amazing79\Simplex\Simplex\Renders;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HtmlRender implements RenderStrategy
{
    private string $assets_path;
    private array $scripts = [];

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
        $response->setCache([
            'must_revalidate'  => true,
            'no_cache'         => true,
            'no_store'         => true,
            'max_age'          => 600,
            's_maxage'         => 600,
            'last_modified'    => new \DateTime(),
            ]);

        return $response;
    }

    protected function includeAsset(string $asset): string
    {
        return $this->assets_path . $asset;
    }

    protected function makeRelativePath(): string
    {
        $context = Request::createFromGlobals();
        return $context->getBasePath();
    }

    public function loadScript(string $path, string $attributes = ''):void
    {
        $this->scripts[] = ['path' => $path, 'attributes' => $attributes];
    }

    protected function printScripts(): void
    {
        foreach ($this->scripts as $script) {
            echo sprintf("<script src=\"%s\" %s></script>\n", $script['path'], $script['attributes']);
        }
    }

    protected function makeUrl(string $path): string
    {
        return $this->makeRelativePath() . $path;
    }
}