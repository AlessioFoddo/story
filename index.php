<?php
include("./db.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="./css/background.css">
    <title>Cuori in Cotrasto</title>
</head>
<body>
    <main class="w-75 mx-auto">
        <h1 class="my-5 text-center">Cuori in Contrasto:</h1>
        <h2 class="text-center">Il rifiuto del destino</h2>
        <div class="button">
            <button type="button" class="button-login btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Login
            </button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="./php-actions/login/loginUser.php" method="POST">
                            <div class="mb-3">
                              <label for="username-input" class="form-label">Username</label>
                              <input type="text" class="form-control" id="username-input" aria-describedby="emailHelp" name="username">
                            </div>
                            <div class="mb-3">
                              <label for="password-input" class="form-label">Password</label>
                              <input type="password" class="form-control" id="password-input" name="password">
                            </div>
                            <hr>
                            <div id="emailHelp" class="mb-3 form-text">
                                <p>Se non sei reigstrato, registrati ora <span><a href="./html-pages/sign-up.html">SIGN UP</a></span></p>
                            </div>
                            <button type="submit" class="btn btn-primary">login</button>
                          </form>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>