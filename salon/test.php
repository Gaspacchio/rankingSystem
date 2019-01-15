<!DOCTYPE html>
<html>

<head>
    <title>Board</title>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="stylesheet" type="text/css" media="screen" href="../main.css" />
</head>

<body>
    <h1 class="rankingTitle">
        <?php
            $login = htmlspecialchars($_GET["login"]);
            echo 'Bonjour ' . $login;
        ?>
    </h1>
    <div class="rankingContainer">
        <div class="rankingCard">
            <h2>Les notes</h2>
            <?php
            // Connecting to the MySQL server
                $link = mysqli_connect("localhost", "root", "", "ranking");

            // Check connection
                if($link === false){
                    die("Erreur, impossible de se connecter : " . mysqli_connect_error());
                }

            // Select data from table then calculate average from note table
                $totalNote = "SELECT * FROM tbl_note";
                $queryNote = mysqli_query($link, $totalNote);

                if (!$queryNote) {
                    die ('Erreur SQL : ' . mysqli_error($link));
                }

                echo "<div class='totalNotes'>" . mysqli_num_rows($queryNote) . " notes déjà !</div>";

            // Close connection
                mysqli_close($link);
            ?>
            <?php
            // Connecting to the MySQL server
                $link = mysqli_connect("localhost", "root", "", "ranking");

            // Check connection
                if($link === false){
                    die("Erreur, impossible de se connecter : " . mysqli_connect_error());
            }

            // Select data from table then calculate average from note table
                $note = "SELECT profId, AVG(note) FROM tbl_note GROUP BY profId;";
                $queryNote = mysqli_query($link, $note);

                if (!$queryNote) {
                    die ('Erreur SQL : ' . mysqli_error($link));
                }

            if (mysqli_num_rows($queryNote) > 0) {
                // Loop through values
                while($row = mysqli_fetch_assoc($queryNote)) {
                    // Then display it as a div
                        echo "<div class='card'>" . $row["profId"] . " est noté " . round($row["AVG(note)"]) . "</div>";
                }
            } else {
                echo "<div class='card empty'>Personne n'a de notes pour l'instant</div>";
            }

            // Close connection
                mysqli_close($link);
            ?>
        </div>
        <div class="rankingSubmit">
            <h2>Noter un prof</h2>
            <form action="../script/rank.php" method="POST">
                <select name="prof">
                    <option value="Thierry">Thierry</option>
                    <option value="Olivier">Olivier</option>
                    <option value="Laurent">Laurent</option>
                </select>
                <input type="number" name="note" id="note" placeholder="note" required>
                <?php echo '<input type="text" name="login" id="login" value="' . htmlspecialchars($_GET["login"]) . '" hidden>'?>
                <button type="submit">Noter</button>
                <button type="reset">Remettre à zéro</button>
            </form>
        </div>
    </div>
    <div class="citeContainer">
        <h2>Le tableau des notes</h2>
        <?php
            // Connecting to the MySQL server
                $link = mysqli_connect("localhost", "root", "", "ranking");

            // Check connection
                if($link === false){
                    die("Erreur, impossible de se connecter : " . mysqli_connect_error());
                }

            // Select all data form table tbl_note
                $totalNote = "SELECT * FROM tbl_note ORDER BY login ASC";
                $queryNote = mysqli_query($link, $totalNote);

                if (!$queryNote) {
                    die ('Erreur SQL : ' . mysqli_error($link));
                }

                if (mysqli_num_rows($queryNote) > 0) {
                    // Loop through values
                    while($row = mysqli_fetch_assoc($queryNote)) {
                        // Then display it as a div
                            echo "<div class='table'>" . $row["profId"] . " a été noté " . $row["note"] . " par " . $row["login"] . "</div>";
                    }
                } else {
                    echo "<div class='table empty'>Personne n'a de notes pour l'instant</div>";
                }

            // Close connection
                mysqli_close($link);
            ?>
    </div>
</body>

</html>