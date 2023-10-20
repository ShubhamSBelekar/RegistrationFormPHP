
<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
$iss ="localhost";
$iat =time();
$nbf =$iat +10;
$exp =$iat +30;
$aud ="myusers";
try{
    $user_arr_data=array(
        "id" =>"1",
        "user" =>"sss",
        "pass" =>"sadsa"
    );
    $payload_info = array(
        "iss"=>$iss,
        "iat"=>$iat,
        "nbf"=>$nbf,
        "exp"=>$exp,
        "aud"=>$aud,
        "data"=> $user_arr_data
    );
    $secret_key = "testKey115";
    $token =  JWT::encode($payload_info,$secret_key,"HS256");
    $response[] = array("result"=> "ss","token"=>$token);
    echo json_encode($response);
}catch(Exception $e){
    echo($e);

}

?>