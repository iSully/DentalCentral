<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Debug\Exception\FlattenException;

class ExceptionController extends Controller
{
    public function showExceptionAction(FlattenException $exception)
    {
        $error = null;
        switch ($exception->getStatusCode()) {
            case 403:
                $error = 'You are not allowed to visit this page';
                break;
            case 404:
                $error = 'Unknown page requested';
                break;
            default:
                $error = sprintf('Unknown error occurred(%s)', $exception->getStatusCode());
                break;
        }

        return $this->render(
            'AppBundle::error.html.twig',
            ['error' => $error, 'exception' => $exception->getMessage()]
        );
    }
}
