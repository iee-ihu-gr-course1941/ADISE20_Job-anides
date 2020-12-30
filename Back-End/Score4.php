<?php

require_once "Database/dbConnect.php";
//global $request;
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

if ($request[0] == 'board'){
    if ((!isset($request[1])) && ($method == 'GET' || $method == 'POST')){
        board($method);
    } else if (isset($request[2]) && ($method == 'GET' || $method == 'PUT')){
        boardColumn($methodIs, $request[2]);
    } else {
        error();
    }
} else if ($request[0] == 'players'){
    
} else if ($request[0] == 'status') {

} else{
    error();
}

// Συνάρτηση εμφάνισης και επαναφοράς του board.
function board($methodIs){
    global $mysqli;
    if ($methodIs == 'POST'){
        $sql = 'CALL reset_board()';
        $mysqli -> query($sql);
    }
    sql('SELECT * FROM game_board');
}

function boardColumn($methodIs, $column){
    global $mysqli;
    // Εδώ θα μπει η κίνηση, πρόσθεσε τον κώδικα αργότερα.
    if ($methodIs == 'PUT'){
        echo "put";
    }
    
    $query = 'SELECT * FROM game_board WHERE column = ' + $column;
    sql($query);
}

function sql($query){
    global $mysqli;

    $sql = $query;
    $prepare = $mysqli -> prepare($sql);

    $prepare -> execute();
    $result = $prepare -> get_result();

    header('Content-type: application/json');
    return json_encode($result->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function error(){
    header("HTTP/1.1 404 Not Found");
    exit;
}