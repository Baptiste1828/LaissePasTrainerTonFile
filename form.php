<?php

if (!empty($_GET['file']) && file_exists($_GET['file'])) {
    unlink($_GET['file']);
    header('index.php');
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $uploadDir = 'upload/';
    $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
    $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];
    $maxFileSize = 1000000;

    if ((!in_array($extension, $authorizedExtensions))) {
        $errors[] = 'Veuillez sélectionner une image de type Jpg ou Png ou Gif ou Webp !';
    }

    if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
        $errors[] = "Votre fichier doit faire moins de 1M !";
    }

    $data = array_map('htmlentities', array_map('trim', $_POST));

    if (empty($data['firstname'])) {
        $errors[] = 'Le prénom est obligatoire !';
    }

    if (empty($data['lastname'])) {
        $errors[] = 'Le nom est obligatoire !';
    }

    if (!isset($data['age'])) {
        $errors[] = 'L\'âge est obligatoire !';
    } else if ($data['age'] < 18) {
        $errors[] = 'Il faut avoir au moins 18 ans pour s\'inscrire sur le site !';
    }

    if (empty($errors)) {
        $uploadFile = $uploadDir . uniqid() . '.' . $extension;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        require 'profil.php';
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpringfieldWild</title>
    <link rel="stylesheet" href="formStyle.css">
</head>
<body>
    <ul>
        <?php foreach($errors as $error) : ?>
            <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
    <form action="" method="post" enctype="multipart/form-data">
        <div>
            <label for="firstname">Prénom : </label>
            <input type="text" name="firstname" id="firstname" required>
        </div>
        <div>
            <label for="lastname">Nom : </label>
            <input type="text" name="lastname" id="lastname" required>
        </div>
        <div>
            <label for="age">Age : </label>
            <input type="number" name="age" id="age" min='18' required>
        </div>
        <div>
            <label for="imageUpload">Upload une image de profil : </label>
            <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
            <input type="file" name="avatar" id="imageUpload" required/>
        </div>
        <button name="send">Send</button>
    </form>
</body>
</html>