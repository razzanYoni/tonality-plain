function deleteAlbum(albumId) {

    var xhr = new XMLHttpRequest();
    console.log(albumId);
    xhr.open("DELETE", "/albumAdmin/" + albumId + "/deleteAlbum", true    );
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.href = "/albumAdmin";
        } else {
            console.error("Terjadi kesalahan dalam menghapus album.");
        }
    }
    xhr.send(null);
}