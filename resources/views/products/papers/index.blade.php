<x-category-layout
    title="ក្រដាសរ៉ាម (Papers)"
    heading="ក្រដាស (Papers)"
    subheading="ហាងរបស់យើងខ្ញុំមានលក់នូវ ក្រដាសដែលមានគុណភាពល្អ ប្រើយ៉ាងមានទំនុកចិត្ត មិនព្រួយបារម្ភអំពីការធ្វើឲ្យម៉ាស៊ីនមានបញ្ហា"
    searchId="paper-search"
    searchPlaceholder="Search by paper name strictly…"
    searchAriaLabel="Search paper products"
    :sortOptions="[
        'default' => 'Sort: Default',
        'price-asc' => 'Price: Low → High',
        'price-desc' => 'Price: High → Low',
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
