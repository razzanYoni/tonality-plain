document.addEventListener("DOMContentLoaded", function () {
    // Get the select elements
    const filterSelect = document.querySelector(".filter");
    const sortSelect = document.querySelector(".sort");
    const descSelect = document.querySelector(".desc");

    // Add event listeners for changes in the selects
    filterSelect.addEventListener("change", function () {
        const filter = filterSelect.value;
        const sort = sortSelect.value;
        const desc = descSelect.value;
        updateURL(filter, sort, desc);
    });

    sortSelect.addEventListener("change", function () {
        const filter = filterSelect.value;
        const sort = sortSelect.value;
        const desc = descSelect.value;
        updateURL(filter, sort, desc);
    });

    descSelect.addEventListener("change", function () {
        const filter = filterSelect.value;
        const sort = sortSelect.value;
        const desc = descSelect.value;
        updateURL(filter, sort, desc);
    });

    // Function to update the URL
    function updateURL(filter, sort, desc) {
        // Get the current URL
        let url = new URL(window.location.href);

        // Clear existing parameters related to filter, sort, and desc
        url.searchParams.delete("genre");
        url.searchParams.delete("sort");
        url.searchParams.delete("is_desc");

        // Add filter parameter
        if (filter !== "Genre") {
            url.searchParams.set("genre", filter);
        }

        // Add sort parameter
        if (sort !== "Sort") {
            url.searchParams.set("sort", sort === "Release Date" ? "release_date" : "album_name");
        }

        // Add desc parameter
        if (desc !== "Order") {
            url.searchParams.set("is_desc", desc === "Ascending" ? "asc" : "desc");
        }

        // Create an XMLHttpRequest
        const xhr = new XMLHttpRequest();
        xhr.open("GET", url.href, true);

        // Define the callback function when the request is complete
        xhr.onload = function () {
            if (xhr.status === 200) {
                window.history.pushState({}, "", url.href);
                window.location.reload();
            } else {
                console.error("Terjadi kesalahan dalam melakukan permintaan.");
            }
        };
        // Send the request
        xhr.send();
    }
});
