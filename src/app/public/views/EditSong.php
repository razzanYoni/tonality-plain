<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/FormDetail.js"></script>
    <link rel="stylesheet" href="../css/FormDetail.css">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <title>Form</title>
</head>
<body>
    <div class="form-container">
        <h1>Edit Song</h1>
        <div class="form-list">
            <div class="song-quest">
                <div class="form-label">Album Name</div>
                <form>
                    <input type="text">
                </form>
            </div>
            <div class="song-quest">
                <div class="form-label">Artist</div>
                <form>
                    <input type="text">
                </form>
            </div>
            <div class="song-quest">
                <div class="form-label">Genre</div>
                <form>
                    <input type="text">
                </form>
            </div>
            <div class="song-quest">
                <div class="form-label">Release Date</div>
                <form>
                    <input type="date" value="2001-01-01">
                </form>
            </div>
            <div class="song-quest">
                <div class="form-label">Audio File</div>
                <form>
                    <input type="file" id="input-file" accept="audio/*">
                    <label for="input-file" class="custom-file-upload" id="file-label">Choose An Audio File</label>
                </form>
            </div>
            <div class="song-quest">
                <div class="form-label">Album</div>
                <form>
                    <input type="text">
                </form>
            </div>
            <div class="cancel-submit">
                <button class="cancel-btn">Cancel</button>
                <button class="add-btn">Add Song</button>
            </div>
        </div>
    </div>
</body>
</html>
