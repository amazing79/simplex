<?php

namespace Amazing79\Simplex\Simplex\Renders;

use Symfony\Component\HttpFoundation\Response;

class HtmlLayoutRender extends HtmlRender implements RenderStrategy
{
    protected string $content;

    public function __construct()
    {
        parent::__construct();
    }

    public function render (string $template = '', array $parameters = []): Response
    {
        extract($parameters, EXTR_SKIP);
        ob_start();
        //primero se carga el template, el cual luego lo renderiza el layout en su propiedad content
        include sprintf(APP_ROOT .'/app/Views/%s.php', $template);
        $this->content = ob_get_clean();
        //incluyo el layout
        include APP_ROOT .'/app/Views/layout/layout.php';
        $layout = ob_get_clean();
        $response = new Response($layout);
        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }
}
