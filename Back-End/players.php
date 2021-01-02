<?php
require_once 'sql.php';

function allPlayersDetails(){
    $result = sql('SELECT * FROM `players`');
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
    //UPDATE `players` SET `username`='ttest' WHERE `player_colour` = 'y'
    $query = "UPDATE `players` SET `username`= '$input' WHERE `player_colour` = '$colour'";
    $mysqli -> query($query);
}

