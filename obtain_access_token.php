<?php
        include 'define.php';

        require_once __DIR__ . '/src/facebook/autoload.php';


        //fb credentials array
        $creds = array(
            'app_id'=> FACEBOOK_APP_ID,
            'app_secret'=> FACEBOOK_APP_SECRET,
            'default_graph_version'=> 'v3.2',
            'persistence_data_handler'=> 'session'
        );

        //create fb objects
        $facebook = new Facebook\Facebook( $creds );

        //helper
        $helper = $facebook->getRedirectLoginHelper();

        //Oauth object
        $oAuth2Client = $facebook->getOAuth2Client();


        if(isset( $_GET['code'] ) ){ // get access token
            try{
                $accessToken = $helper->getAccessToken();
            } catch( Facebook\Exceptions\FacebookResponseException $e){
                echo 'Graph return an error' . $e->getMessage;
            } catch( Facebook\Exceptions\FacebookSDKException $e){
                echo 'Facebook sdk return an error' . $e->getMessage;
            }

            echo '<h1>Short Lived Access Token</h1>';
            print_r( (string)$accessToken );
        }else{ //display login url
            $permissions = ['public_profile', 'instagram_basic', 'pages_show_list'];
            $loginUrl = $helper->getLoginUrl( FACEBOOK_REDIRECT_URI, $permissions);

            echo '<a href="' . $loginUrl . '">
                Login With Facebook
                </a>';
        }

