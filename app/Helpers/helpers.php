<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Str;
use App\Helpers\MenuHelper;

if (!function_exists('menu_active')) {
    function menu_active(array|string $routes, string $class = 'active'): string
    {
        return MenuHelper::active($routes, $class);
    }
}

if (!function_exists('menu_active_open')) {
    function menu_active_open(array|string $routes): string
    {
        return MenuHelper::activeOpen($routes);
    }
}


if (!function_exists('page_active')) {
    function page_active(string $slug): bool
    {
        return request()->routeIs('pages.show') && request('slug') === $slug;
    }
}

if (!function_exists('page_title')) {
    function page_title(?string $title = null): string
    {
        $appName = config('app.name');

        return $title
            ? "{$title} – {$appName}"
            : $appName;
    }
}


