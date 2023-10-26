const debounce = (mainFunction, delay) => {
  let timer;

  return function (...args) {
    clearTimeout(timer);
    timer = setTimeout(() => {
      mainFunction(...args);
    }, delay);
  };
};

function searchAlbum() {
  const searchInput = document.getElementById("search");
  const input = searchInput.value;

  const xhr = new XMLHttpRequest();
  let url = window.location.href;
  if (url.includes("albumAdmin")) {
    url = url.replace("albumAdmin", "albumXhr");
  } else {
    if (!url.includes("albumXhr")) {
      url = url.replace("album", "albumXhr");
    }
  }

  let currentUrl = new URL(url);

  currentUrl.searchParams.set("search", input);

  let newUrl = currentUrl.href;

  xhr.open("GET", newUrl, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const response = JSON.parse(xhr.responseText);
      const totalPage = response["totalPage"];
      const is_admin = response["is_admin"];
      const data = response["data"];

      if (is_admin === "0") {
        newUrl = newUrl.replace("albumXhr", "album");
      } else {
        newUrl = newUrl.replace("albumXhr", "albumAdmin");
      }

      const albumCardContainer = document.getElementById("album-card-container");

      albumCardContainer.innerHTML = "";

      window.history.pushState({ query: input }, "", newUrl);

      JSON.parse(data).forEach((album) => {
        if (is_admin === "0") {
          albumCardContainer.innerHTML += `
          <a href="/album/${album["album_id"]}" class="album-card">
            <div class="album-info-container">
                <img src="storage/${album["cover_filename"]}" alt="album cover image" class="album-cover-image"/>
                <div class="album-name">${album["album_name"]}</div>
                <div class="artist-name">${album["artist"]}</div>
            </div>
        </a>
            `;
        } else {
           albumCardContainer.innerHTML += `
          <a href="/albumAdmin/${album["album_id"]}" class="album-card">
            <div class="album-info-container">
                <img src="storage/${album["cover_filename"]}" alt="album cover image" class="album-cover-image"/>
                <div class="album-name">${album["album_name"]}</div>
                <div class="artist-name">${album["artist"]}</div>
            </div>
        </a>
            `;
        }
      });

      paginationContainer = document.getElementById("pagination-container");
      paginationContainer.innerHTML = "";

      // get current url
      let currentUrl = new URL(window.location.href);

      currentPage = 1;
      if (Number(totalPage) > 0) {
        currentUrl.searchParams.set("page", "1");
        let newUrl = currentUrl.href;

        paginationContainer.innerHTML += `
        <a href="${newUrl}" class="pagination-item current"> 
            1
        </a>
        `
        if (1 < (Number(totalPage)-1)) {
            paginationContainer.innerHTML += `
            <a href="${newUrl.replace("1", "2")}" class="pagination-item">
            Next
            </a>
            `
        }

        paginationContainer.innerHTML += `
        <a href="${newUrl.replace("1", totalPage)}" class="pagination-item">
            Last
        </a>
        `
      }


    } else {
      console.error("Terjadi kesalahan dalam melakukan pencarian.");
    }
  };

  xhr.send();
}

let debounceTimeout;

document.addEventListener("DOMContentLoaded", function () {
  const searchInput = document.getElementById("search");

  const debouncedSearchAlbum = debounce(searchAlbum, 300);

  searchInput.addEventListener("keyup", function (e) {
    if (debounceTimeout) {
      clearTimeout(debounceTimeout);
    }
    debounceTimeout = setTimeout(() => {
      debouncedSearchAlbum();
    }, 300);
  });
});