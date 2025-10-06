<?php
/**
 * @var \Amazing79\Simplex\Simplex\Renders\HtmlLayoutRender $this
 */
?>

<!DOCTYPE html>
<html lang="es-AR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simplex Framework</title>
    <link href="<?= $this->includeAsset('/css/app.css') ?>" rel="stylesheet" type="text/css" />
    <link href="<?= $this->includeAsset('/favicon.ico') ?>" rel="icon">
    <?php $this->printScripts(); ?>
</head>
<body>
    <header class="header">
        <nav>
            <h1>Layout Example</h1>
        </nav>
    </header>
    <div class="container">
        <main class="main">
            <?= $this->content ?>
        </main>
    </div>
    <footer class="footer">
        <p> Simplex Framework - <?= date('Y') ?></p>
    </footer>
</body>
</html>