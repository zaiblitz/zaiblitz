<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/Twitter/autoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter extends CI_Controller {

    const CONSUMER_KEY = '';
    const CONSUMER_SECRET = '';
    const REDIRECT_URI = '';

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
            $connection = new TwitterOAuth(self::CONSUMER_KEY, self::CONSUMER_SECRET);
            $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => self::REDIRECT_URI));
            $_SESSION['oauth_token'] = $request_token['oauth_token'];
            $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
            $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
            echo $url;
        } else {
            $access_token = $_SESSION['access_token'];
            $connection = new TwitterOAuth(self::CONSUMER_KEY, self::CONSUMER_SECRET,
                $access_token['oauth_token'], $access_token['oauth_token_secret']);
            $user = $connection->get("account/verify_credentials");
            echo $user->screen_name;
        }
    }

    public function call_back() {
        session_start();

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