<?php

function sql($query){
    global $mysqli;

    $sql = $query;
    $prepare = $mysqli -> prepare($sql);

    $prepare -> execute();
    $result = $prepare -> get_result();

    return json_encode($result->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

