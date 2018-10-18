<?php

namespace App\Twig;

use App\Helpers\MoneyDecorator;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MoneyExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
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
}
