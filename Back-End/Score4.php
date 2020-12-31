<?php

require_once "Database/dbConnect.php";

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

if ($request[0] == 'board'){
    if ((!isset($request[1])) && ($method == 'GET' || $method == 'POST')){
        board($method);
    } else if (isset($request[2]) && ($method == 'GET' || $method == 'PUT')){
        if ($request[2] >= 0 && $request[2] <= 6){
            boardColumn($method, $request[2]);      
        } else{
            error();
        }
    } else {
        error();
    }
} else if ($request[0] == 'players'){
    
} else if ($request[0] == 'status') {

} else{
    error();
}

// reset/show board function
function board($methodIs){
    global $mysqli;
    if ($methodIs == 'POST'){
        $sql = 'CALL reset_board()';
        $mysqli -> query($sql);
    }
    $result = sql('SELECT * FROM `game_board` WHERE `column` = 3');
    header('Content-type: application/json');
    print $result;
}

// show column/insert move into column function
function boardColumn($methodIs, $column){
    global $mysqli;
    
    $query = 'SELECT * FROM `game_board` WHERE `column` = '.$column;
    $result = sql($query);
    if ($methodIs == 'PUT'){
        $colour = 'r'; // remove this later
        insert($column, $result, $colour);
    }
    
    $result = sql($query);
    header('Content-type: application/json');
    print $result;
    
}

function sql($query){
    global $mysqli;

    $sql = $query;
    $prepare = $mysqli -> prepare($sql);

    $prepare -> execute();
    $result = $prepare -> get_result();

    return json_encode($result->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function error(){
    header("HTTP/1.1 404 Not Found");
    exit;
}

// insert move into game_board function
function insert($column, $result, $tilecolour){
    global $mysqli;
    $json = json_decode($result, true);
    $firstEmptyPosition;
    $insertMove = array();
    foreach ($json as $a){
        $insertMove[$a['row']] = $a['tile_colour'];
    }
    
    for ($row = count($insertMove) - 1; $row >= 0; $row--) {
        if($insertMove[$row] == null || $insertMove[$row] == ''){         
            $query = "UPDATE `game_board` SET `tile_colour`= '".$tilecolour."' WHERE `row` = ".$row." AND `column` = ".$column;
            $mysqli -> query($query);
            break;
        }
    }
}