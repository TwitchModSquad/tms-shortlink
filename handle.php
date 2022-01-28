<?php

$q = $_GET["q"];

if (str_starts_with($q, "i/")) {
    header("Location: https://panel.twitchmodsquad.com/#/records/user//identity/" . substr($q, 2));
} else if (str_starts_with($q, "t/")) {
    header("Location: https://panel.twitchmodsquad.com/#/records/user//twitch/" . substr($q, 2));
} else if (str_starts_with($q, "d/")) {
    header("Location: https://panel.twitchmodsquad.com/#/records/user//discord/" . substr($q, 2));
}