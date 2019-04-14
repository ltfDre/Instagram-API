<?php

require "settings.php";
@ $Instagram = new InstagramAPI($settings);

class InstagramAPI{
    var $clientID = "b2f5256a865f430e93901171d9e8673f";
    var $clientSecret = "38c44fe0cd5045399d8e9a4f09a8da58 ";
    var $redirectURL = "http://localhost/Instagram/callback.php";

    public function __construct($settings = array()){
        $this->$clientID = $settings ['clientID'];
        $this->$clientSecret = $settings ['clientSecret'];
        $this->$redirectURL = $settings ['redirectURL'];
    }

    public function getAccessTokenAndUserDetails($code){
      $postFields = array(
        "client_id" => $this-> clientID,
        "client_secret" => $this-> clientSecret,
        "grant_type" => $this-> authorization_code,
        "redirect_uri" => $this->redirectURL,
        "code" => $code
      );

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, "https://api.instagram.com/oauth/access_token");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
      $response = curl_exec($ch);
      curl_close($ch);

      return json_decode($response, true);
    }

    public function getLoginURL(){
        return "https://api.instagram.com/oauth/authorize/?client_id=".$this->clientID."&redirect_uri=".$this->redirectURL."&response_type=code";
    }
}
?>