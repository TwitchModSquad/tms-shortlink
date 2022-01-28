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

    <link rel="stylesheet" href="assets/css/group.css">
</head>
<body>
    <h1>TMS Group List</h1>
    <?php
        foreach ($group as $user) {
            echo '<div class="user">
                <img src="'.$user["profile_image_url"].'" alt="Profile picture for '.$user["display_name"].'" />
                <h2>'.$user["display_name"].'</h2>
            </div>';
        }
    ?>
</body>
</html>