<?php
$sql = connect();
$query = $sql->prepare("SELECT * FROM usuario WHERE email = ?;");
$query->bind_param("s", $_SESSION['email']);
$query->execute();
$result_query = $query->get_result();
$result_array = $result_query->fetch_all(MYSQLI_ASSOC);
$nome = $result_array[0]['nome'];
$foto_path = $result_array[0]['foto_path'];
?>

<header class="ações-servidor col-span-12 h-16 bg-[#040401] grid grid-cols-3 justify-items-center content-center">
    <div class="user">
        <div class="flex items-center md:order-2">
            <button type="button" class="flex mr-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-[#00bf63]" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                <span class="sr-only">Abrir menu de usuário</span>
                <img class="w-8 h-8 rounded-full" src="<?php echo $foto_path; ?>" alt="user photo">
            </button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow" id="user-dropdown">
                <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900"><?php echo $nome; ?></span>
                    <span id="sepae_email" class="block text-sm  text-gray-500 truncate"><?php echo $_SESSION['email'] ?></span>
                </div>
                <ul class="py-2" aria-labelledby="user-menu-button">
                    <li>
                        <form method="post"><input type="submit" name="logout" class="block px-4 py-2 text-sm text-gray-700 active:hover:bg-gray-100 m-auto" value="Logout"></form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="">
        <p class="text-white" id="time"></p>
    </div>
    <a href="index.php">
        <div class="">
            <img src="static/sepais_logo.png" class="sm:h-6 h-4">
        </div>
    </a>
</header>