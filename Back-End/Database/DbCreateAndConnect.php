<?php
$host='localhost';
$db = 'projectdb';
require_once "db_upass.php";

$user=$DB_USER;
$pass=$DB_PASS;

// Σύνδεση στην βάση.
if(gethostname()=='users.iee.ihu.gr') {
	$mysqli = new mysqli($host, $user, $pass, $db,null,'/home/staff/asidirop/mysql/run/mysql.sock');
} else {
        $mysqli = new mysqli($host, $user, $pass, $db);
}

// Έλεγχος για πρόβλημα σύνδεσης.
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . 
    $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

// Διαγραφή πίνακα, αν υπάρχει.
$sql1 = "DROP TABLE IF EXISTS default_game_board";
if ($mysqli->query($sql1) === TRUE) {
  echo "New record created successfully<br />";
} else {
  echo "Error: " . $sql . "<br>" . $mysqli->error;
}

// Δημιουργία του default πίνακα του παιχνιδιού που θα χρησιμοποιείται όταν ξεκινάει ένα καινούργιο παιχνίδι.
$sql2 = "CREATE TABLE `default_game_board` ( 
    `row` tinyint(1) NOT NULL, 
    `column` tinyint(1) NOT NULL, 
    `tile_colour` ENUM('r', 'y', 'w') DEFAULT NULL, 
    PRIMARY KEY(`row`,`column`) 
)";
if ($mysqli->query($sql2) === TRUE) {
  echo "New record created successfully<br />";
} else {
  echo "Error: " . $sql . "<br>" . $mysqli->error;
}

// Αρχικοποίηση του default πίνακα.
for ($i = 0; $i < 6; $i++){
    for ($j = 0; $j < 7; $j++){
        $sql = "INSERT INTO `default_game_board`(`row`, `column`, `tile_colour`) VALUES ($i,$j,'w');";
        if ($mysqli->query($sql) === TRUE) {
            echo "$i $j New record created successfully";
        } else {
            echo "Error on row $i, column $j: " . $sql . "<br>" . $mysqli->error;
        }
        echo "<br />";
    }
}

// Διαγραφή του κύριου πίνακα του παιχνιδιού, αν υπάρχει.
$sql3 = "DROP TABLE IF EXISTS game_board";
if ($mysqli->query($sql3) === TRUE) {
  echo "New record created successfully<br />";
} else {
  echo "Error: " . $sql . "<br>" . $mysqli->error;
}

// Δημιουργία του κύριου πίνακα στον οποίο θα αποθηκεύεται η κατάσταση του παιχνιδιού.
$sql4 = "CREATE TABLE `game_board` ( 
    `row` tinyint(1) NOT NULL, 
    `column` tinyint(1) NOT NULL, 
    `tile_colour` ENUM('r', 'y', 'w') DEFAULT NULL, 
    PRIMARY KEY(`row`,`column`) 
    );";
if ($mysqli->query($sql4) === TRUE) {
  echo "New record created successfully<br />";
} else {
  echo "Error: " . $sql . "<br>" . $mysqli->error;
}

$mysqli->close();
?>
