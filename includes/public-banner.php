<?php
// Si el usuario está loggeado, NO mostrar banner público
if (isset($_SESSION["rol"])) {
    return;
}
?>

<div class="top-banner" role="banner">
    <img src="/assets/images/banner_index_1.png" alt="Banner principal Alzheimer">
</div>
