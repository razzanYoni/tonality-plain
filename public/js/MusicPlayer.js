document.addEventListener("DOMContentLoaded", function () {
    const musicPlayer = document.getElementById("musicPlayer");
    const songTitles = document.querySelectorAll(".song-title");

    let currentSongId = null;

    songTitles.forEach(function (songTitle) {
      songTitle.addEventListener("click", function () {
        const songId = songTitle.getAttribute("data-song-id");
        const audioFilename = songTitle.getAttribute("data-audio-filename");

        if (songId === currentSongId) {
          if (musicPlayer.paused) {
            musicPlayer.src = audioFilename;
            musicPlayer.play();
          } else {
            musicPlayer.pause();
          }
        } else {
            musicPlayer.pause();
            musicPlayer.src = audioFilename;
            musicPlayer.play();
            currentSongId = songId;
        }
      });
    });
  });
