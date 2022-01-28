<?php
require_once("/var/www/tmsqd.co/internal/twitch.php");
require_once("/var/www/tmsqd.co/internal/connect.php");

if (!empty($_GET['code'])) {

    require("/var/www/tmsqd.co/internal/grabaccesscode.php");
    
} else {
    // Get an authorize URL with some scope (here the one to allow the app to change the stream title and game)
    $authorizeURL = $authAPI->getAuthorizeURL($redirectURI, ['user:read:email']);
    
    // Redirect the user to the authorize page
    header('Location: '. $authorizeURL);
}
