

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="/src/app/public/js/FormDetail.js"></script>
    <link rel="stylesheet" href="/src/app/public/css/FormDetail.css" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Inter" rel="stylesheet">
    <title>Form</title>
</head>
<body>
    <div class="form-container">
        <h1>Add New Album</h1>
        <div class="form-list">
            <div class="album-quest">
                <div class="form-label">Album Name</div>
                <form>
                    <input type="text">
                </form>
            </div>
            <div class="album-quest">
                <div class="form-label">Artist</div>
                <form>
                    <input type="text">
                </form>
            </div>
            <div class="album-quest">
                <div class="form-label">Genre</div>
                <form>
                    <input type="text">
                </form>
            </div>
            <div class="album-quest">
                <div class="form-label">Cover Photo</div>
                <form>
                    <input type="file" id="input-file" accept="image/*">
                    <label for="input-file" class="custom-file-upload" id="file-label">Choose Your Album Cover</label>
                </form>
            </div>
            <div class="album-quest">
                <div class="form-label">Release Year</div>
                <form>
                    <input type="date" value="2001-01-01">
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
