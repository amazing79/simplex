<?php

namespace App\Controllers\Welcome;

use Amazing79\Simplex\Simplex\Render;
use Amazing79\Simplex\Simplex\Renders\HtmlRender;
use App\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WelcomeController extends BaseController
{
    public function welcome (Request $request): Response
    {
        $view = new Render(new HtmlRender());
        return $view->render('index/welcome');
    }

}