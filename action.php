<?php
header('Content-Type: application/json');
include "./WaitList.php";
$actions = new WaitList();

$allowed_origins = [
    'http://localhost:4321',
    'http://example.com',
    'https://another-domain.com'
];

if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
    header('Access-Control-Allow-Credentials: true');
} else {
    header('Access-Control-Allow-Origin: http://localhost:4321'); 
}

header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if($_SERVER['REQUEST_METHOD'] == 'OPTIONS')
{
    http_response_code(response_code: 200);
    exit();
}
if (isset($_POST['action']) && $_POST['action'] == "insertwaitlist") {
    $email = $_POST["email"];
    $project = $_POST["project"];
    $ip = $_SERVER['REMOTE_ADDR'];
     try {
        $camposdb = "email, ip, project";
        $valores = "?, ?, ?";
        $bind = "sss";
        $data_camp = array($email, $ip, $project);
        $insertUser = $actions->postInsert('waitlist', $camposdb, $valores, $bind, $data_camp);
        if($insertUser){
            $response = array(
                "success" => true,
                "message" => $insertUser
            );
        }else{
            $response = array(
                "success" => false,
                "message" => 'Error to insert waitlist user'
            );
        }
        
     } catch (\Throwable $th) {
        $response = array(
            "success" => false,
            "message" => 'Erro in catch: '.$th
        );
     }
    $json_res = json_encode($response);
    echo $json_res;
}