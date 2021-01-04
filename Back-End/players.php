<?php
require_once 'sql.php';

function allPlayersDetails(){
    $result = sql('SELECT `username`, `player_colour` FROM `players`');
    header('Content-type: application/json');
    print $result;
}

function playerName($colour){
    $query = "SELECT `username` FROM `players` WHERE `player_colour` = '$colour'";
    $result = sql($query);
    header('Content-type: application/json');
    print $result;
}

// Na testareis an douleuei
function setPlayerName($colour, $input){
    global $mysqli;
    if(!isset($input['username'])) {
	header("HTTP/1.1 400 Bad Request");
	print json_encode(['errormesg'=>"No username given."]);
	exit;
    }   
    
    $username=$input['username'];
    $sql = "SELECT COUNT(*) AS counter FROM `players` WHERE `player_colour` = '$colour' AND `username` IS NOT NULL";
    $result = sql($sql);
    if ($result[0]['counter'] > 0) {
        header("HTTP/1.1 400 Bad Request");
	print json_encode(['errormesg'=>"Player $colour is already set. Please select another color."]);
	exit;
    }
    
    $query = "UPDATE `players` SET `username`= '$input', `token` = MD5(CONCAT('$input', NOW())) WHERE `player_colour` = '$colour'";
    $mysqli -> query($query);
    
    updateGameStatus();
    $query1 = "SELECT * FROM `players` WHERE `player_colour` = '$colour'";
    $result1 = sql($query1);
    header('Content-type: application/json');
    print $result1;
}

