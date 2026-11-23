<x-category-layout
    title="Ink Cartridges"
    heading="ទឹកថ្នាំ (Ink Cartridges)"
    subheading="ទឹកថ្នាំគ្រប់ប្រភេទ ធានាតម្លៃ និងគុណភាព សម្រាប់ម៉ាស៊ីនរបស់លោកអ្នក"
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
