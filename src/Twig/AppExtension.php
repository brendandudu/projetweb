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

    /**
     * Retourne "isActive" si la route courante égale celle passée en paramètre (utile pour surligner les liens)
     */
    public function setActiveIfRouteEquals(string $route): string
    {
        if ($this->request->get('_route') === $route) {
            return "isActive";
        }

        return "";
    }
}