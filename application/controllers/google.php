<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Google extends CI_Controller {

    const CLIENT_ID = '902346378039-r7p4mgfkfrvfp9f1csoa06jo0m6qc0cq.apps.googleusercontent.com';
    const CLIENT_SECRET = 'wR9Z0djADKZPzmE22mcuDPsP';
    const REDIRECT_URI = 'http://zairus.com/zaiblitz/google/call_back';

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');         // get base_url
    }

    public function index() {
        require_once(APPPATH.'libraries/google-api-php-client/src/Google/autoload.php');

        session_start();
        $client_secret =  base_url().'media/client_secret.json';

        $client = new Google_Client();
        $client->setAuthConfigFile($client_secret);
        $client->addScope( array('profile', 'email') );

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);

            // redirect data to test
            $redirect_uri = base_url().'google/test';    // direct to index
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        } else {
            $redirect_uri = base_url().'google/call_back';
            echo '<a href="' . htmlspecialchars($redirect_uri) . '">Login with Google!</a>';
        }
    }

    public function call_back() {
        require_once(APPPATH.'libraries/google-api-php-client/src/Google/autoload.php');

        session_start();
        $client_secret =  base_url().'media/client_secret.json';

        $client = new Google_Client();
        $client->setAuthConfigFile($client_secret);
        $client->setRedirectUri( base_url().'google/call_back' );
        $client->addScope( array('profile', 'email') );

        if (! isset($_GET['code'])) {
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect_uri = base_url().'google';    // direct to index
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
    }

    public function test() {

        require_once(APPPATH.'libraries/google-api-php-client/src/Google/autoload.php');
        session_start();

        // https://www.googleapis.com/oauth2/v1/userinfo?access_token={accessToken}


        $client = new Google_Client();
        $client->setClientId(self::CLIENT_ID);
        $client->setClientSecret(self::CLIENT_SECRET);
        $client->setRedirectUri(self::REDIRECT_URI);
        $client->setScopes('email');

        $plus = new Google_Service_Plus($client);
        if( isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect_uri = base_url().'google/test';    // direct to this page
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);

            $me = $plus->people->get('me');

            $id = $me['id'];
            $name =  $me['displayName'];
            $email =  $me['emails'][0]['value'];
            $profile_image_url = $me['image']['url'];
            $cover_image_url = $me['cover']['coverPhoto']['url'];
            $profile_url = $me['url'];

            echo 'ID: '.$id.'<br/>';
            echo 'Email: '.$email.'<br/>';
            echo 'Name: '.$name.'<br/>';
            echo  "<img src='$profile_image_url'>";
        } else {
            $auth_url = $client->createAuthUrl();
        }
    }
}