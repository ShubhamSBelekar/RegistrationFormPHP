

<?php
require 'vendor/autoload.php';
use Firebase\JWT\JWT;

    header("Access-Control-Allow-Origin: http://localhost:5173");   
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Headers: Content-Type");
    try{
        $r="";
        $conn = new mysqli("localhost","root","","reglogdb");
        if(mysqli_connect_error()){
            echo mysqli_connect_error();
            exit();
        }else{
            $eData = file_get_contents("php://input");
            $dData = json_decode($eData,true);
            $user = $dData["user"]; 
            $pass = $dData["pass"];
            if($user !="" && $pass != ""){
                $sql = "CALL stp_CheckUsers('$user')";
                
                $res = mysqli_query($conn,$sql);
                while ($row = mysqli_fetch_assoc($res)) {
                    $passhashed= $row['pass']; // Accessing column1
                    if(password_verify($pass, $passhashed)){
                        $r ="1";
                    }
                }
                if($r=="1"){
                    $result = "1";
                   
                }else{
                    $result = "2";
                }
            }else{
                $result = "";
            }
            if($result=="1"){
     
                $iss ="localhost";
                $iat =time();
                $nbf =$iat +10;
                $exp =$iat +30;
                $aud ="myusers";
                try{
                    $user_arr_data=array(
                        "id" =>"1",
                        "user" =>$user,
                        "pass" =>$pass
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
                    $response[] = array("result"=> $result,"token"=>$token);
                }catch(Exception $e){
                    echo($e);
                }
            }else{
                $response[] = array("result"=> $result);
            }
            $conn->close();
            echo(json_encode($response));
        }
    }catch(Exception $e){
        $response[] = array("result"=> "");
        echo(json_encode($response));
    }
   

?>