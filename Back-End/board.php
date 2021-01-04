<?php
require_once 'sql.php';

// show/reset board
function board($methodIs){
    global $mysqli;
    if ($methodIs == 'POST'){
        $sql = 'CALL reset_board()';
        $mysqli -> query($sql);
    }
    $result = sql('SELECT * FROM `game_board`');
    header('Content-type: application/json');
    print $result;
}

// show specific column
function boardColumn($methodIs, $column, $input){
    global $mysqli;

    $query = 'SELECT * FROM `game_board` WHERE `column` = '.$column;
    $result = sql($query);
    if ($methodIs == 'PUT'){
        insert($column, $result, $input);
    }
    $resultFinal = sql($query);
    header('Content-type: application/json');
    print $resultFinal;
}
