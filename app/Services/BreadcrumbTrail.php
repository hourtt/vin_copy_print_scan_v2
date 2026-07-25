<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class BreadcrumbTrail
{
    private const SESSION_KEY = 'breadcrumb_stack';

    public function getStack(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    public function push(string $label, string $url): void
    {
        $stack = $this->getStack();

        if (!empty($stack)) {
            $top = end($stack);
            if ($top['label'] === $label) {
                return;
            }
        }

        $stack[] = [
            'label' => $label,
            'url'   => $url,
        ];

        Session::put(self::SESSION_KEY, $stack);
    }

    public function pop(): ?array
    {
        $stack = $this->getStack();
        if (empty($stack)) {
            return null;
        }

        $popped = array_pop($stack);
        Session::put(self::SESSION_KEY, $stack);

        return $popped;
    }

    public function reset(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public function top(): ?array
    {
        $stack = $this->getStack();
        if (empty($stack)) {
            return null;
        }

        return end($stack);
    }

    public function resolveForCategory(string $categoryLabel, string $categoryUrl): array
    {
        $this->push($categoryLabel, $categoryUrl);
        $stack = $this->getStack();

        $items = [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
        ];

        if (!empty($stack)) {
            $top = end($stack);
            $items[] = ['label' => $top['label'], 'url' => null];
        } else {
            $items[] = ['label' => $categoryLabel, 'url' => null];
        }

        return $items;
    }

    public function resolveForCart(): array
    {
        $stack = $this->getStack();
        $items = [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
        ];

        if (!empty($stack)) {
            $top = end($stack);
            $items[] = ['label' => $top['label'], 'url' => $top['url']];
            $items[] = ['label' => 'Checkout', 'url' => null];
        } else {
            $items[] = ['label' => 'Shopping Cart', 'url' => null];
        }

        return $items;
    }

    public function resolveForCatalog(): array
    {
        $this->reset();

        return [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Product Catalog', 'url' => null],
        ];
    }

    public function resolveForProduct(string $productName): array
    {
        $stack = $this->getStack();
        $items = [
            ['label' => 'Dashboard', 'url' => route('dashboard')],
        ];

        if (!empty($stack)) {
            $top = end($stack);
            $items[] = ['label' => $top['label'], 'url' => $top['url']];
        }

        $items[] = ['label' => $productName, 'url' => null];

        return $items;
    }
}
