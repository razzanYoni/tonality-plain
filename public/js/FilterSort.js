document.addEventListener("DOMContentLoaded", function () {
    const filterSelect = document.querySelector(".filter");
    const sortSelect = document.querySelector(".sort");
    const descSelect = document.querySelector(".desc");

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

    function updateURL(filter, sort, desc) {
        let url = new URL(window.location.href);

        url.searchParams.delete("genre");
        url.searchParams.delete("sort");
        url.searchParams.delete("is_desc");

        if (filter !== "Genre") {
            url.searchParams.set("genre", filter);
        }

        if (sort !== "Sort") {
            url.searchParams.set("sort", sort === "Release Date" ? "release_date" : "album_name");
        }

        if (desc !== "Order") {
            url.searchParams.set("is_desc", desc === "Ascending" ? "asc" : "desc");
        }

        const xhr = new XMLHttpRequest();
        xhr.open("GET", url.href, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                window.history.pushState({}, "", url.href);
                window.location.reload();
            } else {
                console.error("Terjadi kesalahan dalam melakukan permintaan.");
            }
        };
        xhr.send();
    }
});
