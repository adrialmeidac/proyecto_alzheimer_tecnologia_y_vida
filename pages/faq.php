<?php require_once "../middleware/session-public.php"?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas Frecuentes</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/menu.css">   
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
</head>

<body>

    
    <?php include '../includes/header.php'; ?>

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php
    if (!isset($_SESSION["user_id"])) {
        include '../includes/public-menu.php';
    } elseif ($_SESSION["rol"] === "admin") {
        include '../includes/menu-admin.php';
    } else {
        include '../includes/private-menu.php';
    }
    ?>

    
    <?php include '../includes/responsive-menu.php'; ?>

    
    <?php include '../includes/public-banner.php'; ?>

    <h2 class="text-center mt-5">Preguntas Frecuentes</h2>

    <div class="container mt-4 mb-5">

        
        <div class="accordion" id="faqAccordion">

            

            <h3 class="mt-4 mb-3">Sobre el Alzheimer</h3>

            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq1">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                        ¿Qué es el Alzheimer?
                    </button>
                </h2>
                <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Es una enfermedad neurodegenerativa que afecta la memoria, el pensamiento y la conducta. Su avance es progresivo.
                    </div>
                </div>
            </div>

            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq2">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                        ¿Cuáles son los primeros síntomas?
                    </button>
                </h2>
                <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Olvidos frecuentes, desorientación, dificultad para encontrar palabras y cambios en el estado de ánimo.
                    </div>
                </div>
            </div>

            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq3">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                        ¿Tiene cura?
                    </button>
                </h2>
                <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        No existe cura, pero sí tratamientos y terapias que ayudan a ralentizar los síntomas y mejorar la calidad de vida.
                    </div>
                </div>
            </div>

            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq4">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                        ¿Cómo puedo ayudar a un familiar?
                    </button>
                </h2>
                <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Mantén rutinas, adapta el hogar, fomenta actividades seguras y busca apoyo profesional cuando sea necesario.
                    </div>
                </div>
            </div>

            

            <h3 class="mt-5 mb-3">Sobre el uso de la web</h3>

            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq5">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                        ¿Cómo accedo a los tests cognitivos?
                    </button>
                </h2>
                <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Desde el menú privado, en la sección “Tests Cognitivos”. Solo necesitas iniciar sesión para acceder.
                    </div>
                </div>
            </div>

            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq6">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6">
                        ¿Qué hago si olvidé mi contraseña?
                    </button>
                </h2>
                <div id="collapse6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        En la página de inicio de sesión encontrarás la opción “¿Olvidaste tu contraseña?” para recuperarla fácilmente.
                    </div>
                </div>
            </div>

            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq7">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7">
                        ¿Cómo contacto a un profesional?
                    </button>
                </h2>
                <div id="collapse7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        En el menú público encontrarás la sección “Contacta a un profesional”, donde podrás ver especialistas disponibles.
                    </div>
                </div>
            </div>

            
            <div class="accordion-item">
                <h2 class="accordion-header" id="faq8">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8">
                        ¿Puedo descargar material educativo?
                    </button>
                </h2>
                <div id="collapse8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Sí, en la sección “Temática descargable” encontrarás guías, ejercicios y recursos para cuidadores y familiares.
                    </div>
                </div>
            </div>

        </div>

        
        <div class="text-center mt-4">
            <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/index.php'">
                Volver
            </button>
        </div>

    </div>

    
    <?php include '../includes/footer.php'; ?>

    
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
