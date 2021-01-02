<?php
require_once 'sql.php';

function getGameStatus(){
    $query = "SELECT * FROM `game_status`";
    $result = sql($query);
    header('Content-type: application/json');
    print $result;
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

function checkWin($row, $column){
    $counter = 1;
    
}