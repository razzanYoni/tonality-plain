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
      const response = JSON.parse(xhr.response);
      const page = response["page"];
      const totalPage = response["totalPage"];
      const is_admin = response["is_admin"];
      const data = response["data"];

      console.log(is_admin);
      if (is_admin === "0") {
        newUrl = newUrl.replace("albumXhr", "album");
      } else {
        newUrl = newUrl.replace("albumXhr", "albumAdmin");
      }
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

  searchInput.addEventListener("keyup", function (e) {
    if (debounceTimeout) {
      clearTimeout(debounceTimeout);
    }
    debounceTimeout = setTimeout(() => {
      debouncedSearchAlbum();
    }, 300);
  });
});

function goToLastValue(
) {
  var val = document.getElementById('search').value;
  document.getElementById('search').value = '';
  document.getElementById('search').value = val;
}