<?php
    include 'auth.php';

    if (checkAuth()) {
        header('Location: home.php');
        exit;
    }

    if (!empty($_POST["username"]) && !empty($_POST["password"]) )
    {
        $error = array();
        $conn = mysqli_connect($dbconfig['host'], $dbconfig['name'], $dbconfig['user'], $dbconfig['password']) or die(mysqli_error($conn));

        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $query = "SELECT * FROM users WHERE username = '".$username."'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));;
        
        if (mysqli_num_rows($res) > 0) {
            $entry = mysqli_fetch_assoc($res);
            if (password_verify($_POST['password'], $entry['password'])) {
                //Inizio sessione
                $_SESSION["_agora_username"] = $entry['username'];
                $_SESSION["_agora_user_id"] = $entry['id'];
                header("Location: home.php");
                mysqli_free_result($res);
                mysqli_close($conn);
                exit;
            }
        }
        //Se è stata trovata una sola corrispondenza
        $error = "username e/o password errati.";
    }
    else if (isset($_POST["username"]) || isset($_POST["password"])) {
        //Se solo uno dei due corrisponde
        $error = "Inserisci username e password.";
    }

?>

<html>
    <head>
        <link rel='stylesheet' href='login.css'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="icon.png">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">         
        <meta charset="utf-8">

        <title>Accedi - Lookin'4Food</title>
    </head>
    <body>
        <div id="logo">
            Lookin'4Food
        </div>
        <main class="login">
        <section class="main">
            <h1>Per continuare accedi a L4F</h1>
            <?php
                // Verifica la presenza di errori
                if (isset($error)) {
                    echo "<p class='error'>$error</p>";
                }
                
            ?>
            <form name='login' method='post'>
                <!-- Seleziono il valore di ogni campo sulla base di quelli inviati via POST -->
                <div class="username">
                    <label for='username'>username</label>
                    <input type='text' name='username' <?php if(isset($_POST["username"])){echo "value=".$_POST["username"];} ?>>
                </div>
                <div class="password">
                    <label for='password'>password</label>
                    <input type='password' name='password' <?php if(isset($_POST["password"])){echo "value=".$_POST["password"];} ?>>
                </div>
                <div class="submit-container">
                    <div class="login-button">
                        <input type='submit' value="Accedi">
                    </div>
                </div>
            </form>
            <div class="signup"><h4>Non hai ancora un account?</h4></div>
            <div class="signup-btn-container"><a class="signup-btn" href="signup.php">Iscriviti a Lookin'4Food</a></div>
        </section>
        </main>
    </body>
</html>