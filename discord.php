<?php
require_once("../config.php")
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

define('OAUTH2_CLIENT_ID', $config["discord"]["client_id"]);
define('OAUTH2_CLIENT_SECRET', $config["discord"]["client_secret"]);

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';

// Start the login process by sending the user to Discord's authorization page
if(empty($_GET["code"])) {
    reauth();
}


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if(get('code')) {

	// Exchange the auth code for a token
	$token = apiRequest($tokenURL, array(
        "grant_type" => "authorization_code",
        'client_id' => OAUTH2_CLIENT_ID,
        'client_secret' => OAUTH2_CLIENT_SECRET,
        'redirect_uri' => 'https://twitchmodsquad.com/discord',
        'code' => get('code')
	));

	if (isset($token->error) || !isset($token->access_token)) {
	reauth();
	}

	$user = apiRequest($apiURLBase, null, null, $token->access_token);

	if (!isset($user->id) || !isset($user->username) || !isset($user->discriminator)) {
	    die("Something went wrong.");
	}

    require_once("../internal/connect.php");

    $userRow = $dus->getUser($user->id);

    $identityId;

    $session = $ss->getSession();
    if ($session !== null && $session["identity_id"] !== $userRow["identity_id"]) {
        $identityId = $session["identity_id"];
    } else if ($userRow === null || $userRow["identity_id"] === null) {
        $identityId = $is->createIdentity($user->username);
    } else {
        $identityId = $userRow["identity_id"];
    }

    if ($userRow === null) {
        $dus->createUser($user->id, $user->username, $user->discriminator, $user->avatar, $identityId);
    } else if ($userRow["identity_id"] != $identityId) {
        $dus->updateIdentity($user->id, $identityId);

        $con->prepare("update discord__user set streamers_updated = false where id = ?;")->execute(array($user->id));
    }

    $session = $ss->getSession();

    if ($session === null || $session["identity_id"] != $identityId) {
        $ss->createSession($identityId);
    }

	header('Location: https://panel.twitchmodsquad.com/');
    exit;
}

function apiRequest($url, $post=FALSE, $headers=array(), $accessToken=null) {
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

	$response = curl_exec($ch);


	if($post)
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

	$headers[] = 'Accept: application/json';

	if($accessToken !== null)
		$headers[] = 'Authorization: Bearer ' . $accessToken;

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$response = curl_exec($ch);
	return json_decode($response);
}

function get($key, $default=NULL) {
	return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function reauth() {
    $params = array(
        'client_id' => OAUTH2_CLIENT_ID,
        'redirect_uri' => 'https://twitchmodsquad.com/discord',
        'response_type' => 'code',
        'scope' => 'identify guilds guilds.join'
    );

    // Redirect the user to Discord's authorization page
    header('Location: https://discord.com/api/oauth2/authorize' . '?' . http_build_query($params));
    die();
}