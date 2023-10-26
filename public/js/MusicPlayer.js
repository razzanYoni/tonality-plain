function playAudio(srcAudio) {
    const audioPlayer = document.getElementById("audio_player")
    const extension = srcAudio.split('.').pop();
    audioPlayer.innerHTML = `<source src="/${srcAudio}" type="audio/${extension}" id="source_audio">`
    audioPlayer.load()

    if (audioPlayer.paused) {
        audioPlayer.play()
    } else {
        audioPlayer.pause();
    }
}