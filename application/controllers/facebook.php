<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Facebook extends CI_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->helper('url');         // get base_url
    }


    public function index() {
        session_start();

        require_once(APPPATH.'libraries/Facebook/autoload.php');
        $fb = new Facebook\Facebook([
            'app_id' => FACEBOOK_APP_ID,
            'app_secret' => FACEBOOK_APP_SECRET,
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl('http://zairus.com/zaiblitz/facebook/call_back', $permissions);

        echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
    }

    public function call_back() {
        session_start();

        require_once(APPPATH.'libraries/Facebook/autoload.php');

        $fb = new Facebook\Facebook([
            'app_id' => FACEBOOK_APP_ID,
            'app_secret' => FACEBOOK_APP_SECRET,
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            if( isset($_SESSION['localhost_app_token']) ) {
                $accessToken = $_SESSION['localhost_app_token'];
            } else {
                $accessToken = $helper->getAccessToken();
            }
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        if( isset($accessToken)) {
            if( isset( $_SESSION['localhost_app_token'])) {
                $fb->setDefaultAccessToken($_SESSION['localhost_app_token']);
            } else {
                // getting short-lived access token
                $_SESSION['localhost_app_token'] = (string) $accessToken;

                // OAuth 2.0 client handler
                $oAuth2Client = $fb->getOAuth2Client();

                // Exchanges a short-lived access token for a long-lived one
                $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['localhost_app_token']);

                $_SESSION['localhost_app_token'] = (string) $longLivedAccessToken;

                // setting default access token to be used in script
                $fb->setDefaultAccessToken($_SESSION['localhost_app_token']);
            }

            try {

            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                session_destroy();
                // redirecting user back to app login page
                header("Location: ./");
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }

            /*
             * GET BASIC INFO
             */
            $response = $fb->get('/me?fields=id,name,email,first_name,last_name', $accessToken);


            $me = $response->getGraphUser();
            echo "<img src='https://graph.facebook.com/".$me->getProperty('id')."/picture?type=large'><br/>";
            echo "Full Name: ".$me->getProperty('name')."<br>";
            echo "First Name: ".$me->getProperty('first_name')."<br>";
            echo "Last Name: ".$me->getProperty('last_name')."<br>";
            echo "Email: ".$me->getProperty('email')."<br>";
            echo "Facebook .ID: <a href='https://www.facebook.com/".$me->getProperty('id')."' target='_blank'>".$me->getProperty('id')."</a>";

        } else {
            header('Location: http://zairus.com/work/facebook_auth/');
        }
    }
}