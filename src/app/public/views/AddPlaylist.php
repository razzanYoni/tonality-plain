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
        <h1>Add New Playlist</h1>
        <div class="form-list">
            <div class="playlist-quest">
                <div class="form-label">Playlist Name</div>
                <form>
                    <input type="text">
                </form>
            </div>
            <div class="playlist-quest">
                <div class="form-label">Description</div>
                <form>
                    <input type="text">
                </form>
            </div>
            <div class="playlist-quest">
                <div class="form-label">Cover Photo</div>
                <form>
                    <input type="file" id="input-file" accept="image/*">
                    <label for="input-file" class="custom-file-upload" id="file-label">Choose Your Playlist Cover</label>
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
