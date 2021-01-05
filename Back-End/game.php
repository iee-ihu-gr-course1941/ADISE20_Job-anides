<?php
require_once 'sql.php';

function status(){
    check_abort();
    header('Content-type: application/json');
    print getGameStatus();
}

function check_abort() {
	global $mysqli;
	
	$sql = "UPDATE `game_status` SET `status` = 'aborted', result = IF(p_turn='r','y','r'), player_turn = NULL WHERE player_turn IS NOT NULL AND last_change < (NOW()-INTERVAL 5 MINUTE) AND `status` = 'started'";
	$mysqli -> query($sql);
}

function getGameStatus(){
    $query = "SELECT * FROM `game_status`";
    $result = sql($query);
    return ($result);
}

function updateGameStatus(){
    global $mysqli;
    $status = json_decode(getGameStatus());
    $new_status = null;
    $new_turn = null;
    
    $query = 'SELECT COUNT(*) AS aborted FROM `players` WHERE `last_action` < (NOW() - INTERVAL 15 MINUTE)';
    $aborted = sqlNotJSON($query, 'aborted');
    
    if ($aborted > 0) {
        $query2 = 'UPDATE `players` SET `username` = NULL, `token` = NULL WHERE `last_action` < (NOW() - INTERVAL 15 MINUTE)';
        $mysqli -> query($query2);
        if ($status['status'] == 'started') {
            $new_status = 'aborted';
        }
    }
    $query1 = 'SELECT COUNT(*) AS counter FROM `players` WHERE `username` IS NOT NULL';
    $result = sql($query1);
    $active_players = $result['counter'];
    
    switch ($active_players) {
        case 0: 
            $new_status = 'not active';
            break;
        case 1:
            $new_status = 'initialized';
            
            break;
        case 2:
            $new_status = 'started';
            if ($status['player_turn'] == null) { // H epilogh tou paikti pou tha paiksei prwtos tha ginei tyxaia
                $random = rand(0,100);
                if (($random % 2) == 0) {
                    $new_turn = 'r';
                } else{
                    $new_turn = 'y';
                }
            }
            break;  
    }
    
    $query4 = "UPDATE game_status SET `status` = '$new_status', `player_turn` = '$new_turn'";
    sql($query4);
    
}

function insert($column, $result, $tilecolour){
    global $mysqli;
    $bool = False;
    $json = json_decode($result, true);
    $insertMove = array();
    $rowIndex = 0;
    $columnIndex = 0;
    
    foreach ($json as $a){
        $insertMove[$a['row']] = $a['tile_colour'];
    }
    
    for ($row = count($insertMove) - 1; $row >= 0; $row--) {
        if($insertMove[$row] == null || $insertMove[$row] == ''){         
            $query = "UPDATE `game_board` SET `tile_colour`= '$tilecolour' WHERE `row` = $row AND `column` = $column";
            $mysqli -> query($query);
            $bool = True;
            $rowIndex = $row;
            $columnIndex = $column;
            $colour = $tilecolour;
            break;
        }
    }
    
    if ($bool) {
        checkWin($rowIndex, $columnIndex);
    } else {
        header("HTTP/1.1 400 Bad Request");
	print json_encode(['errormesg'=>"Column is full."]);
	exit;
    }
}



