<?php
session_start();
include('secure.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
<section class="bg-gray-50">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center text-2xl font-semibold text-gray-900">
          <img class="mr-2 h-36" src="static/sepais_logo2.png" alt="logo">
      </a>
      <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                  Faça login na sua conta
              </h1>
              <form class="space-y-4 md:space-y-6" action="validate.php" method="post">
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Seu email</label>
                      <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="nereu.filho@ifpr.edu.br" required>
                  </div>
                  <div>
                      <label for="senha" class="block mb-2 text-sm font-medium text-gray-900">Sua senha</label>
                      <input type="password" name="senha" id="senha" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                  </div>
                  <div class="flex items-center justify-between">
                  <button type="submit" name="submit" class="w-full text-white bg-green-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Login</button>
              </form>
          </div>
      </div>
  </div>
</section>
</body>

</html>