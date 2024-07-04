<?php
session_start();
include('secure.php');
secure_page();
if ($_SESSION['funcao'] == "portaria") {
    header('Location: portaria.php');
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: login.php');
}

if (isset($_GET["recado_id"])) {
    $sql = connect();
    $query = $sql->prepare("SELECT * FROM recado WHERE id = ?;");
    $query->bind_param("i", $_GET["recado_id"]);
    $query->execute();
    $result_query = $query->get_result();
    $recado = $result_query->fetch_all(MYSQLI_ASSOC);
} else {
    header('Location: index.php');
}

# função de horário em tempo real
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sepais | Editar recado</title>
    <?php include("includes.php"); ?>
</head>

<body class="grid grid-cols-12 gap-x-1">
    <?php include("navbar.php"); ?>
    <section id="main" class="col-span-8 sm:col-span-10 overflow-x-auto col-start-1 sm:col-start-2 col-end-13 sm:col-end-12">
        <div id="recado" class="mx-auto w-3/4 mt-4">
            <h2 class="mb-4 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">Editar recado</h2>
            <form id="form_valida" method="post" action="insert/insert_recado.php">
                <div>
                    <input type="hidden" name="username" value="<?php echo $recado[0]["sepae_username"]; ?>">
                    <input type="hidden" name="id" value="<?php echo $recado[0]["id"]; ?>">
                    <label for="titulo" class="block my-2 text-sm font-medium text-gray-900">Título</label>
                    <input type="text" name="titulo" id="titulo" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5" value="<?php echo('[ERRATA] ' . $recado[0]["titulo"]); ?>" readonly>
                </div>
                <div>
                    <p class="block my-2 text-sm font-medium text-gray-900">Recado</p>
                    <textarea id="recado" name="recado" rows="6" class="p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500" required><?php echo($recado[0]["recado"]); ?></textarea>
                </div>
                <div>
                    <label for="validade" class="block my-2 text-sm font-medium text-gray-900">Validade</label>
                    <input type="date" name="validade" id="validade" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-50 p-2.5" value="<?php echo $recado[0]["validade"]; ?>">
                    <p class="text-gray-600"><small>*Deixe vazio caso o recado não tenha validade</small></p>
                    <input type="submit" id="enviar-recado" class="bg-gradient-to-r from-[#00BF63] to-[#016D39] mt-6 bg-[#016D39] shadow-[0_9px_0_rgb(1,109,57)] hover:shadow-[0_4px_0px_rgb(1,109,57)] ease-out hover:translate-y-1 transition-all text-white rounded-lg font-bold px-5 py-2.5 text-center fixed bottom-8 left-[25%] right-[25%]"
                    value="Enviar errata">
                </div>
            </form>
        </div>
    </section>
</body>
<script src="scripts/script.js"></script>
<script src="scripts/snackbar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/flowbite.min.js"></script>

</html>