<?php

namespace App\Helpers;

class MenuHelper
{
    private static function matches(array|string $routes): bool
    {
        foreach ((array) $routes as $route) {
            if (request()->routeIs($route)) {
                return true;
            }
        }
        return false;
    }

    public static function active(array|string $routes, string $class = 'active'): string
    {
        return self::matches($routes) ? $class : '';
    }

    public static function activeOpen(array|string $routes): string
    {
        return self::matches($routes) ? 'active open' : '';
    }

    public static function activeTab(string $route, string $tab, string $class = 'active'): string
    {
        if (!request()->routeIs($route)) {
            return '';
        }

        return request('tab', 'overview') === $tab ? $class : '';
    }

}
