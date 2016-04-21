<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/Twitter/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');         // get base_url
    }

    // https://github.com/sohaibilyas/twitter-api-php/blob/master/index.php
    // https://www.youtube.com/watch?v=t5hD96EYAtU
    public function index() {
        session_start();

        if(!isset($_SESSION['access_token'])) {
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
            $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => CONSUMER_REDIRECT));
            $_SESSION['oauth_token'] = $request_token['oauth_token'];
            $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
            $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
            redirect($url);
        } else {
            $access_token = $_SESSION['access_token'];
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,
                $access_token['oauth_token'], $access_token['oauth_token_secret']);
            $user = $connection->get("account/verify_credentials");

            print_r(json_decode(json_encode($user), true) );exit;
        }
    }

    public function call_back() {
        session_start();

        if (isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) && $_REQUEST['oauth_token'] == $_SESSION['oauth_token']) {
            $request_token = [];
            $request_token['oauth_token'] = $_SESSION['oauth_token'];
            $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
            $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
            $_SESSION['access_token'] = $access_token;

            // redirect user back to index page
            redirect( base_url().'twitter/');
        }
    }

    public function getData() {
        session_start();

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