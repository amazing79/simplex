<?php

namespace Amazing79\Simplex\Index\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class IndexController
{
    public function index(Request $request): Response
    {
        return new Response('Hello world! Bienvenido a Simplex!');
    }
}