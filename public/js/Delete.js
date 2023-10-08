function deleteAlbum(albumId) {

    var xhr = new XMLHttpRequest();
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

function deleteSongFromAlbum(songId, albumId) {

    var xhr = new XMLHttpRequest();
    xhr.open("DELETE", "/albumAdmin/" + albumId + "/deleteSong/" + songId, true    );
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.href = "/albumAdmin/" + albumId;
        } else {
            console.error("Terjadi kesalahan dalam menghapus lagu.");
        }
    }
    xhr.send(null);
}

function deleteSongFromPlaylist(songId, playlistId) {
    var xhr = new XMLHttpRequest();
    xhr.open("DELETE", "/playlist/" + playlistId + "/deleteSong/" + songId, true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.href = "/playlist/" + playlistId;
        } else {
            console.error("Terjadi kesalahan dalam menghapus lagu.");
        }
    }
    xhr.send(null);
}

function deletePlaylist(playlistId) {

    var xhr = new XMLHttpRequest();
    xhr.open("DELETE", "/playlist/" + playlistId + "/deletePlaylist", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.href = "/playlist";
        } else {
            console.error("Terjadi kesalahan dalam menghapus playlist.");
        }
    }
    xhr.send(null);
}

function deleteUser(userId) {

    var xhr = new XMLHttpRequest();
    xhr.open("DELETE", "/users/" + userId + "deleteUser", true);
    xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    xhr.onload = function () {
        if (xhr.status === 200) {
            window.location.href = "/users";
        } else {
            console.error("Terjadi kesalahan dalam menghapus user.");
        }
    }
    xhr.send(null);
}