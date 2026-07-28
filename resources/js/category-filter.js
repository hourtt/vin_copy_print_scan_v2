// 1. Module-level variables
const MAX_CACHE_SIZE = 30;
const responseCache = new Map();
let abortController = null;
let debounceTimer = null;

// 2. State & UI Functions
function getParams() {
    const params = new URLSearchParams(window.location.search);
    return {
        cat: params.get("cat") || "all",
        search: params.get("search") || "",
        sort: params.get("sort") || "default",
    };
}

function syncUI(params) {
    const searchInput = document.querySelector('input[type="search"]');
    const sortSelect = document.getElementById("sort-select");
    const catPills = document.querySelectorAll("#cat-pills .pill");

    if (searchInput && searchInput.value !== params.search) {
        searchInput.value = params.search;
    }

    if (sortSelect && sortSelect.value !== params.sort) {
        sortSelect.value = params.sort;
    }

    if (catPills.length > 0) {
        catPills.forEach((p) => {
            p.classList.remove(
                "active",
                "border-transparent",
                "bg-[#27272a]",
                "text-white",
            );
            p.classList.add(
                "border-[#e4e4e7]",
                "bg-white",
                "text-[#71717a]",
                "hover:border-[#3f3f46]",
                "hover:text-[#3f3f46]",
            );

            if (p.dataset.cat === params.cat) {
                p.classList.add(
                    "active",
                    "border-transparent",
                    "bg-[#27272a]",
                    "text-white",
                );
                p.classList.remove(
                    "border-[#e4e4e7]",
                    "bg-white",
                    "text-[#71717a]",
                    "hover:border-[#3f3f46]",
                    "hover:text-[#3f3f46]",
                );
            }
        });
    }
}

// 3. Fetch Update
async function updateView(params, pushState = true) {
    const url = new URL(window.location.pathname, window.location.origin);
    Object.keys(params).forEach((key) => {
        if (params[key] && params[key] !== "all" && params[key] !== "default" && params[key] !== "") {
            url.searchParams.set(key, params[key]);
        }
    });

    if (abortController) abortController.abort();
    abortController = new AbortController();

    syncUI(params);

    const productGroups = document.getElementById("product-groups");
    const skeletonGrid = document.getElementById("skeleton-grid");
    const emptyState = document.getElementById("empty-state");
    const countNum = document.getElementById("count-num");
    let announcer = document.getElementById("aria-announcer");

    if (productGroups) productGroups.style.opacity = "0";

    let showSkeleton = false;
    const skeletonTimeout = setTimeout(() => {
        showSkeleton = true;
        if (productGroups) productGroups.style.display = "none";
        if (skeletonGrid) skeletonGrid.style.display = "block";
    }, 150);

    try {
        const cacheKey = url.toString();
        let data;

        if (responseCache.has(cacheKey)) {
            clearTimeout(skeletonTimeout);
            data = responseCache.get(cacheKey);
        } else {
            const response = await fetch(url, {
                headers: { "X-Requested-With": "XMLHttpRequest", Accept: "application/json" },
                signal: abortController.signal,
            });
            if (!response.ok) throw new Error(`Network response was not ok: ${response.status}`);
            data = await response.json();
            
            if (responseCache.size >= MAX_CACHE_SIZE) {
                responseCache.delete(responseCache.keys().next().value);
            }
            responseCache.set(cacheKey, data);
        }
        
        clearTimeout(skeletonTimeout);

        if (pushState) window.history.pushState(params, "", url);
        else window.history.replaceState(params, "", url);

        if (productGroups) productGroups.innerHTML = data.html;
        if (countNum) countNum.textContent = data.count;
        
        if (emptyState) emptyState.style.display = data.count === 0 ? "flex" : "none";
        if (productGroups && data.count === 0) {
            productGroups.style.display = "none";
        } else if (productGroups) {
            productGroups.style.display = "block";
        }

        if (skeletonGrid) skeletonGrid.style.display = "none";

        if (productGroups && data.count > 0) {
            productGroups.style.transform = "translateY(10px)";
            productGroups.style.opacity = "0";
            requestAnimationFrame(() => {
                productGroups.style.transition = "opacity 200ms ease, transform 200ms ease";
                productGroups.style.transform = "translateY(0)";
                productGroups.style.opacity = "1";
            });
        }

        if (announcer) announcer.textContent = `List updated. Showing ${data.count} items.`;
    } catch (error) {
        if (error.name === "AbortError") return;
        clearTimeout(skeletonTimeout);
        if (skeletonGrid) skeletonGrid.style.display = "none";
        if (productGroups) {
            productGroups.style.opacity = "1";
            productGroups.style.display = "block";
        }
        if (emptyState) {
            emptyState.style.display = "flex";
            emptyState.innerHTML = `<p class="text-lg text-red-500">Failed to load products. Please try again.</p>`;
            if (productGroups) productGroups.style.display = "none";
        }
    }
}

function setParamAndUpdate(key, value, pushState = true) {
    const params = getParams();
    params[key] = value;
    updateView(params, pushState);
}

function initCategoryFilter() {
    // Setup ARIA announcer if missing
    let announcer = document.getElementById("aria-announcer");
    if (!announcer) {
        announcer = document.createElement("div");
        announcer.id = "aria-announcer";
        announcer.setAttribute("aria-live", "polite");
        announcer.classList.add("sr-only");
        document.body.appendChild(announcer);
    }

    const searchInput = document.querySelector('input[type="search"]');
    const catPills = document.querySelectorAll("#cat-pills .pill");
    const sortSelect = document.getElementById("sort-select");
    const skeletonGrid = document.getElementById("skeleton-grid");
    const productGroups = document.getElementById("product-groups");

    syncUI(getParams());

    if (productGroups) productGroups.style.transition = "opacity 150ms ease";
    if (skeletonGrid) skeletonGrid.style.display = "none";

    // Bind inputs - Using dataset.bound to prevent duplicate listeners on initial load
    if (searchInput && !searchInput.dataset.bound) {
        searchInput.dataset.bound = "true";
        searchInput.addEventListener("input", (e) => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                setParamAndUpdate("search", e.target.value.trim());
            }, 300);
        });
    }

    if (catPills.length > 0) {
        catPills.forEach((pill) => {
            if (!pill.dataset.bound) {
                pill.dataset.bound = "true";
                pill.addEventListener("click", (e) => {
                    const target = e.currentTarget;
                    setParamAndUpdate("cat", target.dataset.cat);
                });
            }
        });
    }

    if (sortSelect && !sortSelect.dataset.bound) {
        sortSelect.dataset.bound = "true";
        sortSelect.addEventListener("change", (e) => {
            setParamAndUpdate("sort", e.target.value);
        });
    }
}

// 4. Lifecycle Event Listeners
document.addEventListener("turbo:load", initCategoryFilter);

// Initial page load fallback
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", initCategoryFilter);
} else {
    initCategoryFilter();
}

// Bind popstate globally ONCE (not inside turbo:load)
window.addEventListener("popstate", (e) => {
    const params = e.state || getParams();
    syncUI(params);
    updateView(params, false);
});
