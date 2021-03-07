<?php

namespace App\Twig;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    protected $request;

    public function __construct(RequestStack $requestStack)
    {
        $this->request = $requestStack->getCurrentRequest();
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('setActive', [$this, 'setActiveIfRouteEquals']),
        ];
    }

    public function setActiveIfRouteEquals(String $route): string
    {
        if($this->request->get('_route') === $route){
            return "isActive";
        }

        return "";
    }
}