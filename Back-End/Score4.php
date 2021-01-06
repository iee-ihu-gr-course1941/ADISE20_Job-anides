<?php

require_once "Database/dbConnect.php";
require_once 'board.php';
require_once 'game.php';
require_once 'players.php';
require_once 'sql.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
$input = json_decode(file_get_contents('php://input'),true);

if ($request[0] == 'board') {
    if ((!isset($request[1])) && ($method == 'GET' || $method == 'POST')) {
        board($method);
    } else if ($request[1] == 'column' && ($method == 'GET' || $method == 'PUT') ){
        if ($request[2] >= 0 && $request[2] <= 6){
            boardColumn($method, $request[2], $input['pcolor']);      
        } else {
            error();
        }
    } else {
        error();
    }
} 

else if ($request[0] == 'players') {
    if (!isset($request[1])){
        if ($method == 'GET') {
            allPlayersDetails();
        } else {
            error();
        }
    } else if ($request[1] == 'r' || $request[1] == 'y') {
        if ($method == 'GET'){
            playerName($request[1]);
        } else if ($method == 'PUT') {
            setPlayerName($request[1], $input);
        } else {
            error();
        }
    } else {
        error();
    }
} 

else if ($request[0] == 'status' && $method == 'GET') {
    status();
}

else {
    error();
}

//-----------------------------------------------------------------


function error(){
    print 'error.';
    header("HTTP/1.1 404 Not Found");
    exit;
}





