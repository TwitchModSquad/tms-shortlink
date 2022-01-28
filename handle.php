<?php
require_once("../internal/connect.php");

$q = $_GET["q"];

if (str_starts_with($q, "i/")) {
    header("Location: https://panel.twitchmodsquad.com/#/records/user//identity/" . substr($q, 2));
    exit();
} else if (str_starts_with($q, "t/")) {
    header("Location: https://panel.twitchmodsquad.com/#/records/user//twitch/" . substr($q, 2));
    exit();
} else if (str_starts_with($q, "d/")) {
    header("Location: https://panel.twitchmodsquad.com/#/records/user//discord/" . substr($q, 2));
    exit();
}

$getShortlink = $con->prepare("select id, name, longlink, created_id from shortlink where shortlink = ? or id = ?;");
$getShortlink->execute(array($q, $q));

$name = null;
$group = null;
$creator = null;

if ($getShortlink->rowCount() > 0) {
    $sl = $getShortlink->fetch(PDO::FETCH_ASSOC);
    $name = $sl["name"];

    if ($sl["longlink"] == null) {
        $getGroup = $con->prepare("select tu.*, live.start_time from shortlink__group as slg join twitch__user as tu on tu.id = slg.user_id left join live on live.identity_id = tu.identity_id and live.end_time is null where shortlink_id = ? order by tu.display_name asc;");
        $getGroup->execute(array($sl["id"]));

        $group = array();
        while ($user = $getGroup->fetch(PDO::FETCH_ASSOC)) {
            array_push($group, $user);
        }

        $getCreator = $con->prepare("select * from twitch__user where identity_id = ?;");
        $getCreator->execute(array($sl["created_id"]));

        if ($getCreator->rowCount() > 0) {
            $creator = $getCreator->fetch(PDO::FETCH_ASSOC);
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