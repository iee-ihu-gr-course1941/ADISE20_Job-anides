<?php

require_once "Database/dbConnect.php";

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);
$requestTypeA = array_shift($request);

if ($requestType == 'board'){
    request_board(array_shift($request), $method);    
} else if ($requestType == 'players'){
    
} else if ($requestType == 'status') {

} else{
    header("HTTP/1.1 404 Not Found");
    exit;
}

function request_board($requestType, $methodType){
    switch ($requestType){
        case 'piece' :
            break;
        
        case '' || null :
            if ($methodType == 'GET' || $methodType == 'POST')
                board();
            
            else 
                header("HTTP/1.1 404 Not Found");
            
            break;
            
        default :
            header("HTTP/1.1 404 Not Found");
            break;
    }
}


// Να τεστάρω αν δουλεύει
function board($methodType){
    if ($methodType == 'POST'){
        $sql = 'CALL reset_board()';
        $msqli -> query($sql0);
    }
    $mysqli;
    $sql = 'SELECT * FROM game_board';
    $prepare = $mysqli -> prepare($sql);

    $prepare -> execute();
    $result = $prepare -> get_result();

    header('Content-type: application/json');
    print json_encode($result->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}





        