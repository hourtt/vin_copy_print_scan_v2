<x-category-layout
    title="Ink Cartridges"
    heading="Ink Cartridges"
    subheading="All types of ink, with guaranteed price and quality, for your machine."
    searchId="toner-search"
    searchPlaceholder="Search ink cartridges..."
    searchAriaLabel="Search ink cartridges"
    :sortOptions="[
        'default' => 'Sort: Default',
        'price-asc' => 'Price: Low → High',
        'price-desc' => 'Price: High → Low',
        'name-asc' => 'Name A → Z',
    ]"
    sortLabel="Sort ink cartridges"
    :items="$items"
    :brands="$brands"
    :products="$products"
    :category="$category ?? null"
    :gridConfig="$gridConfig ?? null"
/>
