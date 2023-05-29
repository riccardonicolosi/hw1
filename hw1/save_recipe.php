<?php
    require_once 'auth.php';
    if (!$userid = checkAuth()) exit;

    edamam();

    function edamam() {
        global $dbconfig, $userid;

        $conn = mysqli_connect($dbconfig['host'], $dbconfig['name'], $dbconfig['user'], $dbconfig['password']);
        
        # Costruisco la query
        $userid = mysqli_real_escape_string($conn, $userid);
        $uri = mysqli_real_escape_string($conn, $_POST['uri']);
        $label = mysqli_real_escape_string($conn, $_POST['label']);
        $mealType = mysqli_real_escape_string($conn, $_POST['mealType']);
        $cuisineType = mysqli_real_escape_string($conn, $_POST['cuisineType']);
        $ingredientLines = mysqli_real_escape_string($conn, $_POST['ingredientLines']);
        $calories = mysqli_real_escape_string($conn, $_POST['calories']);
        $image = mysqli_real_escape_string($conn, $_POST['image']);

        # check if recipe is already present for user
        $query = "SELECT * FROM recipes WHERE user = '$userid' AND uri = '$uri'";
        $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
        # if recipe is already present, do nothing
        if(mysqli_num_rows($res) > 0) {
            echo json_encode(array('ok' => true));
            exit;
        }

        # Eseguo
        $query = "INSERT INTO recipes(user, uri, content) VALUES('$userid','$uri', JSON_OBJECT('uri', '$uri', 'label', '$label', 'mealType', '$mealType', 'cuisineType', '$cuisineType', 'ingredientLines', '$ingredientLines', 'calories', '$calories', 'image', '$image'))";
        error_log($query);
        # Se corretta, ritorna un JSON con {ok: true}
        if(mysqli_query($conn, $query) or die(mysqli_error($conn))) {
            echo json_encode(array('ok' => true));
            exit;
        }

        mysqli_close($conn);
        echo json_encode(array('ok' => false));
    }