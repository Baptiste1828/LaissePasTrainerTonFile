<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="profilStyle.css">
</head>
<body>
    <div>
        <img src=<?=$uploadFile?> alt="">
        <h1 id="title">Springfield Wild</h1>
        <h1><?=$data['firstname'] . ' ' . $data['lastname']?></h1>
        <h2><?=$data['age'] . ' ans'?></h2>
    </div>
    <a href=<?="index.php?file=" . $uploadFile?>>Supprimer</a>
</body>
</html>