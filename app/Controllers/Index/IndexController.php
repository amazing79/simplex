<?php

namespace App\Controllers\Index;

use Amazing79\Simplex\Simplex\Render;
use Amazing79\Simplex\Simplex\Renders\HtmlLayoutRender;
use Amazing79\Simplex\Simplex\Renders\HtmlRender;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController
{
    public function index(Request $request): Response
    {
        $view = new Render(new HtmlRender());
        return $view->render('index/welcome');
    }

    public function layout(Request $request): Response
    {
        $view = new Render(new HtmlLayoutRender());
        return $view->render('index/layout_example');
    }
}