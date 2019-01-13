<?php

namespace App\Twig;

use App\Helpers\MoneyDecorator;
use App\Helpers\WeightDecorator;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
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
            new TwigFilter('money', [$this, 'money']),
            new TwigFilter('lb', [$this, 'lb']),
            new TwigFilter('kg', [$this, 'kg']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'moneyDecorator']),
        ];
    }

    public function money($amount)
    {
        return (new MoneyDecorator($amount))->toString();
    }

    public function lb($weight)
    {
        return (new WeightDecorator($weight))->toLbString();
    }

    public function kg($weight)
    {
        return (new WeightDecorator($weight))->toKgGString();
    }

    public static function getSubscribedServices()
    {
        return [
            // add services instead of __constructor to improve performance
            // then use them $this->container->get() ...
        ];
    }
}
