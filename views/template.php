<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Bayon&family=Bungee+Inline&family=Bungee+Shade&family=Diplomata&family=Jacques+Francois+Shadow&family=Monoton&family=Rampart+One&family=Shizuru&family=Train+One&family=Vast+Shadow&family=Zen+Tokyo+Zoo&display=swap" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <title><?= $array['title'] . " - Tonsores "; ?> </title>
    </head>
    <body>

    <?php   
        
        include_once "components/navbar.php";
        
        include_once $array['page'].".php";    

        include_once "components/footer.php";

    ?>

        
    </body>
</html>
