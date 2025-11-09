// Custom Filter JavaScript
document.addEventListener("DOMContentLoaded", function () {
    // Show/Hide meta filter based on active filters
    function updateMetaFilterVisibility() {
        const metaFilter = document.querySelector(".meta-filter-shop");
        const hasFilters =
            document.querySelector("#applied-filters .filter-tag") !== null;

        if (metaFilter && hasFilters) {
            metaFilter.style.display = "";
        }
    }

    // Initialize visibility
    updateMetaFilterVisibility();
});
