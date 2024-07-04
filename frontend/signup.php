<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | SEPAIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- <script src="scripts/removeWaterMark.js"></script> -->
    <link rel="icon" type="image/x-icon" href="static/favicon.ico" />
</head>

<body>
    <form method="post" action="insert/insert_cadastro.php">
        <section class="bg-gray-50">
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <a href="#" class="flex items-center text-2xl font-semibold text-gray-900">
                    <img class="mr-2 h-36" src="static/sepais_logo2.png" alt="logo">
                </a>
                <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                            Fazer cadastro
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="#">
                            <div>
                                    <label for="category" class="block mb-2 text-sm font-medium text-gray-900">Função</label>
                                    <select required name="funcao" id="category" class="select-funcao bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                                        <option disabled selected="">Selecionar função</option>
                                        <option value="sepae">Sepae</option>
                                        <option value="portaria">Portaria</option>
                                    </select>
                            </div>
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nome completo</label>
                                <input type="text" name="name" id="name" placeholder="Nereu da Silva Filho" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="nereu.filho@ifpr.edu.br" required>
                            </div>
                            <div>
                                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Sua senha</label>
                                <input type="password" name="senha" id="senha" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" required>
                            </div>
                            <div class="flex items-center justify-between">
                                <button disabled type="submit" name="submit" class="confirmar-cadastro w-full text-white bg-green-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Cadastrar-se</button>
                            </div>
                            <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                                Já tem uma conta? <a href="login.php" class="font-medium text-green-700 hover:underline">Fazer login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <script>
        $('.select-funcao').change(function () {
            $(".confirmar-cadastro").prop("disabled", false);
        });
    </script>
</body>

</html>