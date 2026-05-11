<?php

if (!isset($_SESSION["rol"]) || !in_array($_SESSION["rol"], ["paciente", "familiar", "cuidador", "admin"])) {
    return;
}
?>

<div class="top-banner private" role="banner">
    <img src="/assets/images/banner-interior_1.png" alt="Banner interior Alzheimer">

    <h1 class="titulo-banner">
        Hola, 
        <?php echo htmlspecialchars($_SESSION["nombre"] ?? ""); ?>
    </h1>
</div>
