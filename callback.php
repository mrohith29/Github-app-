// callback.php
<?php
require 'vendor/autoload.php';
$config = require 'config.php';

use League\OAuth2\Client\Provider\Github;

$provider = new Github([
    'clientId'     => $config['clientID'],
    'clientSecret' => $config['clientSecret'],
    'redirectUri'  => $config['redirectUri'],
]);

if (!empty($_GET['error'])) {
    exit('Got error: ' . $_GET['error']);
} elseif (empty($_GET['code'])) {
    exit('No code found');
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
} else {
    // Get an access token using the authorization code grant.
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);

    // Get the user’s details
    try {
        $user = $provider->getResourceOwner($token);
        $userDetails = $user->toArray();

        // Do something with the user details
        echo '<pre>';
        print_r($userDetails);
        echo '</pre>';

    } catch (Exception $e) {
        exit('Failed to get user details: ' . $e->getMessage());
    }
}
