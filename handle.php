<?php
require_once("../internal/connect.php");

$q = $_GET["q"];

if (str_starts_with($q, "i/")) {
    header("Location: https://panel.twitchmodsquad.com/#/records/user//identity/" . substr($q, 2));
} else if (str_starts_with($q, "t/")) {
    header("Location: https://panel.twitchmodsquad.com/#/records/user//twitch/" . substr($q, 2));
} else if (str_starts_with($q, "d/")) {
    header("Location: https://panel.twitchmodsquad.com/#/records/user//discord/" . substr($q, 2));
}

$getShortlink = $con->prepare("select id, longlink from shortlink where shortlink = ? or id = ?;");
$getShortlink->execute(array($q, $q));

$group = null;

if ($getShortlink->rowCount() > 0) {
    $sl = $getShortlink->fetch(PDO::FETCH_ASSOC);

    if ($sl["longlink"] == null) {
        $getGroup = $con->prepare("select tu.* from shortlink__group as slg join twitch__user as tu on tu.id = slg.user_id where shortlink_id = ? order by tu.display_name asc;");
        $getGroup->execute(array($sl["id"]));

        $group = array();
        while ($user = $getGroup->fetch(PDO::FETCH_ASSOC)) {
            array_push($group, $user);
        }
        
        require("group.php");
    } else {
        header("Location: " . $sl["longlink"]);
        die('<a href="'.$sl["longlink"].'">Header failed. Click here.</a>');
    }
} else {
    http_response_code(404);
    die("404 No shortlink found :(");
}