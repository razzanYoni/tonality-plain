<?php
function NavBar() {
    echo <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="/public/css/NavBar.css">
        <title>Tonality</title>
    </head>
    <body>
        <div class="navbar">
            <div class="logo">
                <img src="logo.png">
                <span>Tonality</span>
                <ul class="nav-links">
                    <li><a href="#">Album</a></li>
                    <li><a href="#">Playlist</a></li>
                </ul>
            </div>
            <div class="user-info">
                <div class="search-bar right-side">
                    <input type="text" placeholder="What do you want to listen to">
                </div>
                <span class="right-side">Username</span>
                <a href="#" class="right-side logout">Log Out</a>
            </div>
        </div>
    </body>
    </html>
HTML;
}
?>
