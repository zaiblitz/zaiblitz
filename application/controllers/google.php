<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Google extends CI_Controller {

    const CLIENT_ID = '902346378039-r7p4mgfkfrvfp9f1csoa06jo0m6qc0cq.apps.googleusercontent.com';
    const CLIENT_SECRET = 'wR9Z0djADKZPzmE22mcuDPsP';
    const REDIRECT_URI = 'http://zairus.com/zaiblitz/google/call_back';

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');         // get base_url
    }

    public function index() {
        session_start();

        require_once(APPPATH.'libraries/google-api-php-client/src/Google/autoload.php');
        $client_secret =  base_url().'media/client_secret.json';

        $client = new Google_Client();
        $client->setAuthConfigFile($client_secret);
        $client->addScope( array('profile', 'email') );

        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            $client->setAccessToken($_SESSION['access_token']);

            // redirect data to getData
            $redirect_uri = base_url().'google/getData';    // direct to getData
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

    public function getData() {
        require_once(APPPATH.'libraries/google-api-php-client/src/Google/autoload.php');
        session_start();

        if(isset( $_SESSION['access_token'])) {
            $token = json_decode($_SESSION['access_token'], true);
            $token = $token['access_token'];
            $url =  "https://www.googleapis.com/oauth2/v1/userinfo?access_token=$token";

            $response = $this->webService($url);
            $response = json_encode($response);
            $response = json_decode($response, true);
            print_r($response);
        }
    }

    function webService($url) {
        $ch = curl_init();
        $options = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL            => $url
        ];
        curl_setopt_array($ch, $options);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        return $response;
    }
}