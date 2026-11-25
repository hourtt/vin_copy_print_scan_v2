<x-category-layout
    title="Papers"
    heading="Papers"
    subheading="Our store sells high-quality paper that you can use with confidence, with no worry about causing problems for your machine."
    searchId="paper-search"
    searchPlaceholder="Search by paper name strictly…"
    searchAriaLabel="Search paper products"
    :sortOptions="[
        'default' => 'Sort: Default',
        'price_asc' => 'Price: Low → High',
        'price_desc' => 'Price: High → Low',
        'name-asc' => 'Name A → Z',
        'stock-desc' => 'Most in Stock',
    ]"
    sortLabel="Sort paper"
    :items="$items"
    :brands="$brands"
    :products="$products"
    :category="$category ?? null"
    :gridConfig="$gridConfig ?? null"
/>
