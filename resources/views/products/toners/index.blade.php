<x-category-layout
    title="Toners"
    heading="Toners"
    subheading="Reliable, high-yield cartridges to keep your workspace flowing without interruption."
    searchId="toner-search"
    searchPlaceholder="Search toner models..."
    searchAriaLabel="Search toners"
    :sortOptions="[
        'default' => 'Sort: Default',
        'price-asc' => 'Price: Low → High',
        'price-desc' => 'Price: High → Low',
        'name-asc' => 'Name A → Z',
    ]"
    sortLabel="Sort toners"
    :items="$items"
    :brands="$brands"
    :products="$products"
    :category="$category ?? null"
    :gridConfig="$gridConfig ?? null"
/>
