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
    $status = sqlNotJSON("SELECT * FROM `game_status`");
    $new_status = null;
    $new_turn = null;

    $query = 'SELECT COUNT(*) AS aborted FROM `players` WHERE `last_action` < (NOW() - INTERVAL 15 MINUTE)';
    $aborted = sqlNotJSON($query, 'aborted');
    
    if ($aborted > 0) {        
        $query2 = 'UPDATE `players` SET `username` = NULL, `token` = NULL WHERE `last_action` < (NOW() - INTERVAL 15 MINUTE)';
        $mysqli -> query($query2);
        if ($status[0]['status'] == 'started') {
            $new_status = 'aborted';
        }
    }
    $query1 = 'SELECT COUNT(*) AS counter FROM `players` WHERE `username` IS NOT NULL';    
    $result = sqlNotJSON($query1);
    $active_players = $result[0]['counter'];
    
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
    if (isset($new_turn)) {
        $query4 = "UPDATE game_status SET `status` = '$new_status', `player_turn` = '$new_turn'";
        
    } else {
        $query4 = "UPDATE game_status SET `status` = '$new_status', `player_turn` = $new_turn";
    }
    $query4 = "UPDATE game_status SET `status` = '$new_status', `player_turn` = $new_turn";
    $mysqli -> query($query4);    
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
        checkWin($rowIndex, $columnIndex, $tilecolour);
    } else {
        header("HTTP/1.1 400 Bad Request");
	print json_encode(['errormesg'=>"Column is full."]);
	exit;
    }
}

function checkWin($row, $column, $tilecolour){
    $counter = 1;
    $cellsChecked = 0;
    if (($row >= 0 && $row <= 5) && ($column >= 0 && $column <= 6)){
        $board = sqlNotJSON('SELECT * FROM `game_board`');
        for ($cell = 0; $cell < count($board); $cell++){
            if ($board[$cell]['row'] == $row && $board[$cell]['column'] == $column){
                checkUpDown($row, $column, $tilecolour, $counter, $board);
                checkLeftRight($row, $column, $tilecolour, $counter, $board);
            }
            $cellsChecked++;
        }  
    }
}

function checkUpDown($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){
        checkUp($row, $column, $tilecolour, $counter, $board);
    } else {
        return;
    }
    
    if ($counter < 4){
        checkDown($row, $column, $tilecolour, $counter, $board);
    } else {
        return;
    }
}

function checkLeftRight($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){
        checkLeft($row, $column, $tilecolour, $counter, $board);
    } else {
        return;
    }
    
    if ($counter < 4){
        checkRight($row, $column, $tilecolour, $counter, $board);
    } else {
        return;
    }
}

// apo aristera katw mexri deksia panw elegxos
function checkDiagonalDownLeftUpRight($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){
        checkDownLeft($row, $column, $tilecolour, $counter, $board);
    } else {
        return;
    }
    
    if ($counter < 4){
        checkUpRight($row, $column, $tilecolour, $counter, $board);
    } else {
        return;
    }
}

function checkDiagonalUpLeftDownRight($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){
        checkUpLeft($row, $column, $tilecolour, $counter, $board);
    } else {
        return;
    }
    
    if ($counter < 4){
        checkDownRight($row, $column, $tilecolour, $counter, $board);
    } else {
        return;
    }
}

// Anadromikos elegxos twn thesewn panw apo ekeinh thn thesi sthn opoia egine h eisagwgh
function checkUp($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){ // aparaithtos elegxos gia ton termatismo ths anadromhs
        if ($row > 0 && $row <= 5){ // $row > 0 giati an einai iso me to 0 shmainei oti einai sthn prwth grammh
            for ($cell = 0; $cell < count($board); $cell++){
                if ($board[$cell]['row'] == ($row - 1) && $board[$cell]['column'] == $column){
                    if ($board[$cell]['tile_colour'] == $tilecolour){
                        $counter++;
                        checkUp($row - 1, $column, $tilecolour, $counter, $board);
                        break;
                    } else {
                        break;
                    }
                }
            } 
        } else {
            return;
        }
    }
    else {
        return;
    }
}

function checkDown($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){ // aparaithtos elegxos gia ton termatismo ths anadromhs
        if ($row >= 0 && $row < 5){ // $row < 5 giati an einai iso me to 5 shmainei oti einai sthn teleutaia grammh
            for ($cell = 0; $cell < count($board); $cell++){
                if ($board[$cell]['row'] == ($row + 1) && $board[$cell]['column'] == $column){
                    if ($board[$cell]['tile_colour'] == $tilecolour){
                        $counter++;
                        checkDown($row + 1, $column, $tilecolour, $counter, $board);
                        break;
                    } else {
                        break;
                    }
                }
            } 
        } else {
            return;
        }
    }
    else {
        return;
    }
}

function checkLeft($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){ // aparaithtos elegxos gia ton termatismo ths anadromhs
        if ($column > 0 && $column <= 6){ 
            for ($cell = 0; $cell < count($board); $cell++){
                if ($board[$cell]['row'] == $row && $board[$cell]['column'] == ($column - 1)){
                    if ($board[$cell]['tile_colour'] == $tilecolour){
                        $counter++;
                        checkLeft($row, $column - 1, $tilecolour, $counter, $board);
                        break;
                    } else {
                        break;
                    }
                }
            } 
        } else {
            return;
        }
    }
    else {
        return;
    }
}

function checkRight($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){ // aparaithtos elegxos gia ton termatismo ths anadromhs
        if ($column >= 0 && $column < 6){ 
            for ($cell = 0; $cell < count($board); $cell++){
                if ($board[$cell]['row'] == $row && $board[$cell]['column'] == ($column + 1)){
                    if ($board[$cell]['tile_colour'] == $tilecolour){
                        $counter++;
                        checkLeft($row, $column + 1, $tilecolour, $counter, $board);
                        break;
                    } else {
                        break;
                    }
                }
            } 
        } else {
            return;
        }
    }
    else {
        return;
    }
}

function checkDownLeft($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){ // aparaithtos elegxos gia ton termatismo ths anadromhs
        if (($column > 0 && $column <= 6) && ($row >= 0 && $row < 5)){ 
            for ($cell = 0; $cell < count($board); $cell++){
                if ($board[$cell]['row'] == ($row + 1) && $board[$cell]['column'] == ($column - 1)){
                    if ($board[$cell]['tile_colour'] == $tilecolour){
                        $counter++;
                        checkLeft($row + 1, $column - 1, $tilecolour, $counter, $board);
                        break;
                    } else {
                        break;
                    }
                }
            } 
        } else {
            return;
        }
    }
    else {
        return;
    }
}

function checkUpRight($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){ // aparaithtos elegxos gia ton termatismo ths anadromhs
        if (($column >= 0 && $column < 6) && ($row > 0 && $row <= 5)){ 
            for ($cell = 0; $cell < count($board); $cell++){
                if ($board[$cell]['row'] == ($row - 1) && $board[$cell]['column'] == ($column + 1)){
                    if ($board[$cell]['tile_colour'] == $tilecolour){
                        $counter++;
                        checkLeft($row - 1, $column + 1, $tilecolour, $counter, $board);
                        break;
                    } else {
                        break;
                    }
                }
            } 
        } else {
            return;
        }
    }
    else {
        return;
    }
}

function checkUpLeft($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){ // aparaithtos elegxos gia ton termatismo ths anadromhs
        if (($column > 0 && $column <= 6) && ($row > 0 && $row <= 5)){ 
            for ($cell = 0; $cell < count($board); $cell++){
                if ($board[$cell]['row'] == ($row - 1) && $board[$cell]['column'] == ($column - 1)){
                    if ($board[$cell]['tile_colour'] == $tilecolour){
                        $counter++;
                        checkLeft($row - 1, $column - 1, $tilecolour, $counter, $board);
                        break;
                    } else {
                        break;
                    }
                }
            } 
        } else {
            return;
        }
    }
    else {
        return;
    }
}

function checkDownRight($row, $column, &$tilecolour, &$counter, &$board){
    if ($counter < 4){ // aparaithtos elegxos gia ton termatismo ths anadromhs
        if (($column >= 0 && $column < 6) && ($row >= 0 && $row < 5)){ 
            for ($cell = 0; $cell < count($board); $cell++){
                if ($board[$cell]['row'] == ($row + 1) && $board[$cell]['column'] == ($column + 1)){
                    if ($board[$cell]['tile_colour'] == $tilecolour){
                        $counter++;
                        checkLeft($row + 1, $column + 1, $tilecolour, $counter, $board);
                        break;
                    } else {
                        break;
                    }
                }
            } 
        } else {
            return;
        }
    }
    else {
        return;
    }
}