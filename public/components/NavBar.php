    <?php
    require_once ROOT_DIR . "src/cores/Application.php";
    use cores\Application;
    function NavBar() {
        $username = Application::$app->loggedUser->getUsername();
        $html = <<<"EOT"
            <div class="navbar">
                <div class="logo">
                    <img src="logo.png">
                    <span>Tonality</span>
                    <ul class="nav-links">
                        <li><a href="/album">Album</a></li>
                        <li><a href="/playlist">Playlist</a></li>
                    </ul>
                </div>
                <div class="user-info">
                    <div class="search-bar right-side">
                        <input type="text" placeholder="What do you want to listen to">
                    </div>
                    <span class="right-side">$username</span>
                    <a href="/logout" class="right-side logout">Log Out</a>
                </div>
            </div>
        EOT;

        return $html;
    }
    ?>
