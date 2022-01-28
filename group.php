<?php

if (!isset($group)) {
    die("Missing group variable. group should not be called directly.");
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Group List</title>

    <!-- generated -->
    <link rel="apple-touch-icon" sizes="57x57" href="https://tms.to/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="https://tms.to/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="https://tms.to/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="https://tms.to/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="https://tms.to/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="https://tms.to/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="https://tms.to/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="https://tms.to/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="https://tms.to/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="https://tms.to/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://tms.to/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="https://tms.to/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://tms.to/icon/favicon-16x16.png">
    <link rel="manifest" href="https://tms.to/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#a970ff">
    <meta name="msapplication-TileImage" content="https://tms.to/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#a970ff">
    <!-- -->

    <link rel="stylesheet" href="assets/css/group.css">
</head>
<body>
    <div class="wrapper">
        <h1>TMS Group List</h1>
        <?php
            foreach ($group as $user) {
                echo '<div class="user">
                    <img src="'.$user["profile_image_url"].'" alt="Profile picture for '.$user["display_name"].'" />
                    <h2>'.$user["display_name"].'</h2>
                </div>';
            }
        ?>
    </div>
</body>
</html>