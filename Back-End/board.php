<?php
require_once 'sql.php';

// show/reset board
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

// show specific column
function boardColumn($methodIs, $column){
    global $mysqli;

    $query = 'SELECT * FROM `game_board` WHERE `column` = '.$column;
    $result = sql($query);
    if ($methodIs == 'PUT'){
        $colour = 'r';// na to sbiso auto
        insert($column, $result, $colour);
    }
    $resultFinal = sql($query);
    header('Content-type: application/json');
    print $resultFinal;
}
