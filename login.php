// login.php
<?php
require 'vendor/autoload.php';
$config = require 'config.php';

use League\OAuth2\Client\Provider\Github;

$provider = new Github([
    'clientId'     => $config['clientID'],
    'clientSecret' => $config['clientSecret'],
    'redirectUri'  => $config['redirectUri'],
]);

if (!isset($_GET['code'])) {
    $authorizationUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: ' . $authorizationUrl);
    exit;
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
    unset($_SESSION['oauth2state']);
    exit('Invalid state');
}
