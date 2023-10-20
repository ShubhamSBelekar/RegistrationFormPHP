<?php
    header("Access-Control-Allow-Origin: http://localhost:5173");   
    header("Access-Control-Allow-Methods: GET, POST");
    header("Access-Control-Allow-Headers: Content-Type");
    try{
        $conn = new mysqli("localhost","root","","reglogdb");
        if(mysqli_connect_error()){
            echo mysqli_connect_error();
            exit();
        }else{
            $eData = file_get_contents("php://input");
            $dData = json_decode($eData,true);
            $user = $dData["user"]; 
            $pass = $dData["pass"];
            $name = $dData["name"];
            if($user !="" && $pass != "" && $name != ""){
             
             $hashedPassword = password_hash($pass, PASSWORD_BCRYPT);
                $sql = "CALL stp_CreateUsers('$user', '$hashedPassword','$name')";
                $res = mysqli_query($conn,$sql);
                if(mysqli_num_rows($res)!=0){
                    $result = "1";
                }else{
                    $result = "2";
                }
            }else{
                $result = "";
            }
            $conn->close();
            $response[] = array("result"=> $result);
            echo(json_encode($response));
        }
    } catch(Exception $e){
        $response[] = array("result"=> "");
        echo(json_encode($response));
    }
?>