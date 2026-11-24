<x-category-layout
    title="Printers"
    heading="Printers"
    subheading="Find the perfect printer for your home or office"
    searchId="printer-search"
    searchPlaceholder="Search by name, model, description…"
    searchAriaLabel="Search printers"
    :sortOptions="[
        'default' => 'Sort: Default',
        'price-asc' => 'Price: Low → High',
        'price-desc' => 'Price: High → Low',
        'year-desc' => 'Newest Model First',
        'name-asc' => 'Name A → Z',
        'stock-desc' => 'Most in Stock',
    ]"
    sortLabel="Sort printers"
    :items="$items"
    :brands="$brands"
    :products="$products"
    :category="$category ?? null"
    :gridConfig="$gridConfig ?? null"
/>
