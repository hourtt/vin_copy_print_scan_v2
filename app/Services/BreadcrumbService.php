<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class BreadcrumbService
{
    private const SESSION_KEY = 'breadcrumb_stack';

    public function push(string $label, string $url): void
    {
        $stack = Session::get(self::SESSION_KEY, []);
        $currentPath = parse_url($url, PHP_URL_PATH);

        foreach ($stack as $index => $entry) {
            $entryPath = parse_url($entry['url'], PHP_URL_PATH);
            if ($entryPath === $currentPath) {
                $stack = array_slice($stack, 0, $index + 1);
                $stack[count($stack) - 1]['url'] = $url;
                Session::put(self::SESSION_KEY, $stack);
                return;
            }
        }

        $stack[] = ['label' => $label, 'url' => $url];
        if (count($stack) > 5) {
            $stack = array_slice($stack, -5);
        }

        Session::put(self::SESSION_KEY, $stack);
    }

    public function getStack(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function getForListing(string $currentLabel, string $currentUrl): array
    {
        $stack = $this->getStack();
        $items = [
            ['label' => 'Home', 'url' => route('dashboard')],
        ];

        $currentPath = parse_url($currentUrl, PHP_URL_PATH);
        $preceding = [];

        foreach ($stack as $entry) {
            $entryPath = parse_url($entry['url'], PHP_URL_PATH);
            if ($entryPath === $currentPath) {
                break;
            }
            $preceding[] = $entry;
        }

        foreach ($preceding as $entry) {
            $items[] = ['label' => $entry['label'], 'url' => $entry['url']];
        }

        $items[] = ['label' => $currentLabel, 'url' => null];

        return $items;
    }

    public function getForCart(bool $fromIcon = false): array
    {
        $items = [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
        ];

        if (!$fromIcon) {
            $stack = $this->getStack();
            if (!empty($stack)) {
                $last = end($stack);
                $items[] = ['label' => $last['label'], 'url' => $last['url']];
            }
        }

        $items[] = ['label' => 'Shopping Cart', 'url' => null];

        return $items;
    }

    public function reset(): void
    {
        Session::forget(self::SESSION_KEY);
    }
}
