<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Category Slug Aliases
    |--------------------------------------------------------------------------
    |
    | Maps alternative, plural, or legacy category slugs to their canonical
    | slug in the database.
    |
    */
    'slug_aliases' => [
        'printers' => 'printers',
        'printer' => 'printers',
        'toners' => 'toners',
        'toner' => 'toners',
        'inks' => 'ink-cartridges',
        'ink' => 'ink-cartridges',
        'papers' => 'papers',
        'paper' => 'papers',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Settings
    |--------------------------------------------------------------------------
    |
    | TTL durations (in seconds) and canonical cache keys.
    |
    */
    'cache' => [
        'homepage_curated_ttl' => 3600,
        'catalog_categories_ttl' => 43200,
        'category_brands_ttl' => 43200,

        'keys' => [
            'homepage_curated' => 'homepage_curated_products',
            'catalog_categories' => 'catalog_categories_list',
            'category_brands_prefix' => 'category_brands_',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Category Grid Presentation Configs
    |--------------------------------------------------------------------------
    |
    | Display configurations for AJAX and embedded category grids, indexed
    | by CategoryType enum value.
    |
    */
    'grid_defaults' => [
        'paper' => [
            'groupBy' => 'category_id',
            'headingRelation' => 'category',
            'headingFallback' => 'Uncategorized',
            'subLabelRelation' => 'category',
            'subLabelFallback' => 'Paper',
            'compatKey' => 'compatibility',
            'badgeCase' => 'uppercase',
        ],
        'ink' => [
            'groupBy' => 'brand_id',
            'headingRelation' => 'brand',
            'headingFallback' => 'Other',
            'subLabelRelation' => 'brand',
            'subLabelFallback' => 'Ink',
            'compatKey' => 'spec:Compatible Printers',
            'badgeCase' => 'capitalize',
        ],
        'printer' => [
            'groupBy' => 'brand_id',
            'headingRelation' => 'brand',
            'headingFallback' => 'Other',
            'subLabelRelation' => 'brand',
            'subLabelFallback' => 'Printer',
            'compatKey' => 'compatibility',
            'badgeCase' => 'uppercase',
        ],
        'toner' => [
            'groupBy' => 'brand_id',
            'headingRelation' => 'brand',
            'headingFallback' => 'Other',
            'subLabelRelation' => 'brand',
            'subLabelFallback' => 'Toner',
            'compatKey' => 'compatibility',
            'badgeCase' => 'uppercase',
        ],
        'default' => [
            'groupBy' => 'brand_id',
            'headingRelation' => 'brand',
            'headingFallback' => 'Other',
            'subLabelRelation' => 'brand',
            'subLabelFallback' => 'Product',
            'compatKey' => 'compatibility',
            'badgeCase' => 'uppercase',
        ],
    ],
];
