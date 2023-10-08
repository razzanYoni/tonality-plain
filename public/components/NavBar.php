<?php
require_once ROOT_DIR . "src/cores/Application.php";

use cores\Application;

function NavBar($currentPage): string
{
    $username = Application::$app->loggedUser->getUsername();

    $albumLink = '<li><a href=';
    $albumLinkTemp = '/album';
    $playlistLink = '';
    $additionalAdminNavLinks = '';

    if (Application::$app->loggedUser->isAdmin()) {
        $userLink = '';
        if ($currentPage === "Users") {
            $userLink .= '<li><a href="/users" style="font-weight: bold;">Users</a></li>';
        } else {
            $userLink .= '<li><a href="/users">Users</a></li>';
        }
        $additionalAdminNavLinks .= $userLink;
        $albumLinkTemp = '/albumAdmin';
    } else {
        if ($currentPage === "Playlists") {
            $playlistLink .= '<li><a href="/playlist" style="font-weight: bold;">Playlists</a></li>';
        } else {
            $playlistLink .= '<li><a href="/playlist">Playlists</a></li>';
        }
    }

    $albumLink .= "$albumLinkTemp";
    if ($currentPage === "Albums") {
        $albumLink .= ' style="font-weight: bold;"';
    }
    $albumLink .= '>Albums</a></li>';

    $value = '';
    if (isset($_GET['search'])) {
        $value = $_GET['search'];
    }

    return <<<"EOT"
        <nav class="navbar">
          <div class="left-navbar-items">
            <img class="logo" src="/public/assets/icons/logo.svg" alt="Tonality Logo" />
            <span class="tonality-text">Tonality</span>
            <ul class="nav-links">
                $albumLink
                $playlistLink
                $additionalAdminNavLinks
            </ul>
          </div>
          <div class="right-navbar-items">
            <div class="search-bar right-side">
              <input type="text" placeholder="What do you want to listen to?" id="search" value="$value" autofocus onfocusin="goToLastValue()"/>
            </div>
            <div class="username">$username</div>
            <a href="/logout" class="logout">Log Out</a>
          </div>
        </nav>
    EOT;
}
