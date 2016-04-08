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
//        session_start(); session_destroy();exit;
        require_once(APPPATH.'libraries/google-api-php-client/src/Google/autoload.php');

        session_start();

        $client_secret =  base_url().'media/client_secret.json';

        $client = new Google_Client();
        $client->setAuthConfigFile($client_secret);
        $client->addScope('https://www.googleapis.com/auth/userinfo.profile');
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            $drive_service = new Google_Service_Drive($client);
            $files_list = $drive_service->files->listFiles(array())->getItems();
            echo json_encode($files_list);
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
        $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

        if (! isset($_GET['code'])) {
            $auth_url = $client->createAuthUrl();
            header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
        } else {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect_uri = base_url().'google/getData';
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
    }


    public function getData() {
        require_once(APPPATH.'libraries/google-api-php-client/src/Google/autoload.php');

        $client = new Google_Client();
        $client->setClientId(self::CLIENT_ID);
        $client->setClientSecret(self::CLIENT_SECRET);
        $client->setRedirectUri(self::REDIRECT_URI);
        $client->setScopes('email');

        $plus = new Google_Service_Plus($client);

        /*
         * PROCESS
         *
         * A. Pre-check for logout
         * B. Authentication and Access token
         * C. Retrive Data
         */

        /*
         * A. PRE-CHECK FOR LOGOUT
         *
         * Unset the session variable in order to logout if already logged in
         */
        if (isset($_REQUEST['logout'])) {

            session_unset();
        }

        /*
         * B. AUTHORIZATION AND ACCESS TOKEN
         *
         * If the request is a return url from the google server then
         *  1. authenticate code
         *  2. get the access token and store in session
         *  3. redirect to same url to eleminate the url varaibles sent by google
         */


        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token'] = $client->getAccessToken();
            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
        }
        else {
            echo "<script>alert(\"here 1 \")</script>";
        }

        /*
         * C. RETRIVE DATA
         *
         * If access token if available in session
         * load it to the client object and access the required profile data
         */
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);
            $me = $plus->people->get('me');

            // Get User data
            $id = $me['id'];
            $name =  $me['displayName'];
            $email =  $me['emails'][0]['value'];
            $profile_image_url = $me['image']['url'];
            $cover_image_url = $me['cover']['coverPhoto']['url'];
            $profile_url = $me['url'];

        }
        else {
            $authUrl = $client->createAuthUrl();
        }

    }
}