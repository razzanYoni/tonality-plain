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
  const currentUrl = new URL(window.location.href);
  currentUrl.searchParams.set("query", input);

  const newUrl = currentUrl.href;

  xhr.open("GET", newUrl, true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      // const response = JSON.parse(xhr.responseText);

      window.history.pushState({ query: input }, "", newUrl);
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

  searchInput.addEventListener("keydown", function (e) {
    if (e.key === "Enter") {
      if (debounceTimeout) {
        clearTimeout(debounceTimeout);
      }
      debounceTimeout = setTimeout(() => {
        debouncedSearchAlbum();
      }, 300);
    }
  });
});
