<?php

namespace App\Twig;

use App\Helpers\MoneyDecorator;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MoneyExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('money', [$this, 'moneyDecorator']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'moneyDecorator']),
        ];
    }

    public function moneyDecorator($amount)
    {
        return (new MoneyDecorator($amount))->toString();
    }

    public static function getSubscribedServices()
    {
        return [
            // add services instead of __constructor to improve performance
            // then use them $this->container->get() ...
        ];
    }
}
