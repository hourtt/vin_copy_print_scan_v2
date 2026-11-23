<?php

namespace App\Enums;

use Illuminate\Database\Eloquent\Builder;

enum ProductSort: string
{
    case Recommended = 'recommended';
    case Newest = 'newest';
    case PriceAsc = 'price_asc';
    case PriceDesc = 'price_desc';
    case PriceAscKebab = 'price-asc';
    case PriceDescKebab = 'price-desc';
    case YearDesc = 'year-desc';
    case NameAsc = 'name-asc';
    case StockDesc = 'stock-desc';
    case Default = 'default';

    /**
     * Normalize any incoming string (kebab or snake) to canonical Sort or default.
     */
    public static function fromString(?string $sort): self
    {
        if (empty($sort)) {
            return self::Recommended;
        }

        return self::tryFrom($sort) ?? self::Recommended;
    }

    /**
     * Allowed values for validation.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Apply the sort order to an Eloquent query.
     */
    public function apply(Builder $query): Builder
    {
        return match ($this) {
            self::PriceAsc, self::PriceAscKebab => $query->orderBy('price', 'asc'),
            self::PriceDesc, self::PriceDescKebab => $query->orderBy('price', 'desc'),
            self::YearDesc => $query->orderBy('created_at', 'desc'),
            self::NameAsc => $query->orderBy('name', 'asc'),
            self::StockDesc => $query->orderBy('stock', 'desc'),
            self::Newest => $query->orderBy('created_at', 'desc'),
            self::Recommended, self::Default => $query->latest('id'),
        };
    }
}
