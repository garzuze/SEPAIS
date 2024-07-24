<?php
session_start();
include('../secure.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SEPAIS</title>
    <link rel="icon" type="image/x-icon" href="static/favicon.ico" />
    <script src="scripts/snackbar.js"></script>
    <link rel="stylesheet" href="styles/snackbar.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- <script src="scripts/removeWaterMark.js"></script> -->
</head>

<body>
<section class="bg-gray-50">
<snackbar></snackbar>
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a href="#" class="flex items-center text-2xl font-semibold text-gray-900">
        <img class="mr-2 h-36" src="../static/sepais_logo2.png" alt="logo">
        </a>
    <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                Faça login na sua conta
            </h1>
            <form class="space-y-4 md:space-y-6" action="../api/login.php" method="post">
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Seu email</label>
                    <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="nereu.filho@ifpr.edu.br" required>
                </div>
                <div>
                    <label for="senha" class="block mb-2 text-sm font-medium text-gray-900">Sua senha</label>
                    <input type="password" name="password" id="senha" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                </div>
                    <button type="submit" name="submit" class="w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Login</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Não tem uma conta ainda? <a href="signup.php" class="font-medium text-green-700 hover:underline">Fazer cadastro</a>
                    </p>
            </form>
        </div>
    </div>
</div>
</section>
<script>
    $(document).ready(function () {
        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
            return false;
        };
        var encontrado = getUrlParameter('encontrado');
        if(!encontrado == ""){
            let snackbar = new SnackBar();
                snackbar.make("message", [
                    "Dados inválidos!",
                    null,
                    "top",
                    "right"
                ], 4000);
            var yourCurrentUrl = window.location.href.split('?')[0]; 
            window.history.replaceState({}, '', yourCurrentUrl );
        }
    });
    </script>
</body>

</html>