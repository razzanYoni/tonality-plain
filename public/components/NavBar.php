<?php
function NavBar() {
    $html = <<<"EOT"
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
    EOT;

    return $html;
}
?>
