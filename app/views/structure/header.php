<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Registro</title>
    <link href="<?php echo $this->siteUrl("css/bootstrap-icons.css"); ?>" rel="stylesheet">
    <link href="<?php echo $this->siteUrl("css/bootstrap.css"); ?>" rel="stylesheet">
    <link href="<?php echo $this->siteUrl("css/styles.css"); ?>" rel="stylesheet">
    <?php
        $controllerName = $_SESSION["currentController"];
        if (file_exists("../public/js/$controllerName.js")) {
    ?>
    <link href="<?php echo $this->siteUrl("css/$controllerName.css"); ?>" rel="stylesheet">
    <?php } ?>
</head>
<body>
<?php if (!isset($data['sidebarOff'])) {
    $this->view("structure/sidebar");
} ?>
<?php if (isset($_SESSION["alertClass"]) && isset($_SESSION["alertMessage"])) { ?>
    <div class="alert alert-<?php echo $_SESSION["alertClass"]; ?> custom-alert alert-dismissible fade show" role="alert">
        <?php echo $_SESSION["alertMessage"]; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
    </div>
<?php
    unset($_SESSION["alertClass"]);
    unset($_SESSION["alertMessage"]);
}
?>