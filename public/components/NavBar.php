<?php
require_once ROOT_DIR . "src/cores/Application.php";

use cores\Application;

function NavBar(): string
{
    $username = Application::$app->loggedUser->getUsername();

    $additionalAdminNavLinks = '';
    if (Application::$app->loggedUser->isAdmin()) {
        $additionalAdminNavLinks = <<<"EOT"
            <li><a href="/playlist">Users</a></li>
            EOT;
    }

    return <<<"EOT"
        <nav class="navbar">
          <div class="left-navbar-items">
            <img class="logo" src="/public/assets/icons/logo.svg" alt="Tonality Logo" />
            <span class="tonality-text">Tonality</span>
            <ul class="nav-links">
              <li><a href="/album">Albums</a></li>
              <li><a href="/playlist">Playlists</a>
              $additionalAdminNavLinks
            </ul>
          </div>
          <div class="right-navbar-items">
            <div class="search-bar right-side">
              <input type="text" placeholder="What do you want to listen to?" />
            </div>
            <div class="username">$username</div>
            <a href="/logout" class="logout">Log Out</a>
          </div>
        </nav>
    EOT;
}
