<?php
// Connecting to the MySQL server
    $link = mysqli_connect("localhost", "root", "", "ranking");

// Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

// Storing form values into PHP variables
    $profId = $_POST["prof"];
    $note = $_POST["note"];
    $login = $_POST["login"];

// Inserting these values into the MySQL table we created above
    $sql = "INSERT INTO tbl_note (profId, note, login) VALUES ('$profId', '$note', '$login')";
    
    if(mysqli_query($link, $sql)){
        header('Location: ../salon/index.php?login=' . $login);
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    }

// Close connection
    mysqli_close($link);
?> 