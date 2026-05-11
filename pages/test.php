<?php require_once "../middleware/session.php"; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tests Cognitivos</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link rel="stylesheet" href="/assets/css/color.css">
    <link rel="stylesheet" href="/assets/css/global.css">
    <link rel="stylesheet" href="/assets/css/header.css">
    <link rel="stylesheet" href="/assets/css/footer.css">
    <link rel="stylesheet" href="/assets/css/menu.css">
    <link rel="stylesheet" href="/assets/css/banner.css">
    <link rel="stylesheet" href="/assets/css/test.css">
</head>

<body>

    
    <?php include "../includes/header.php"; ?> 

    
    <button class="theme-toggle" onclick="toggleTheme()">Modo oscuro</button>

    
    <?php include "../includes/private-menu.php"; ?>

    
    <?php include "../includes/responsive-menu.php"; ?>

    
    <?php include "../includes/private-banner.php"; ?>

    <p class="subtitle">Selecciona un test para comenzar</p>
        
    <div class="text-center mt-3">
        <button class="btn btn-info px-4 py-2" data-bs-toggle="modal" data-bs-target="#modalInstrucciones">
            Ver instrucciones
        </button>
    </div>
    
    
    <main class="container tests-container">

        
        <section class="test-card" onclick="location.href='/pages/test-evaluacion.php?test=memoria'" role="button"
            tabindex="0" aria-label="Test de memoria">
            <h3>🧠 Test de Memoria</h3>
            <p>Evalúa la capacidad de recordar información reciente.</p>
        </section>

        
        <section class="test-card" onclick="location.href='/pages/test-evaluacion.php?test=atencion'" role="button"
            tabindex="0" aria-label="Test de atención">
            <h3>🎯 Test de Atención</h3>
            <p>Mide la concentración y la atención sostenida.</p>
        </section>

        
        <section class="test-card" onclick="location.href='/pages/test-evaluacion.php?test=orientacion'" role="button"
            tabindex="0" aria-label="Test de orientación">
            <h3>🧭 Test de Orientación</h3>
            <p>Evalúa la orientación en tiempo y espacio.</p>
        </section>

    </main>

    
    <div class="text-center mt-4">
        <button class="btn btn-secondary px-4 py-2" onclick="location.href='/pages/dashboard.php'">
            Volver
        </button>
    </div>

    
    <div class="modal fade" id="modalInstrucciones" tabindex="-1" aria-labelledby="modalInstruccionesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalInstruccionesLabel">Instrucciones del Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>

                <div class="modal-body">
                    <p><strong>Antes de comenzar:</strong></p>
                    <ul>
                        <li>Lee cada pregunta con calma.</li>
                        <li>No hay límite de tiempo, pero intenta responder sin distracciones.</li>
                        <li>Selecciona la opción que consideres correcta.</li>
                        <li>Al finalizar, verás tu resultado y recomendaciones.</li>
                    </ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>

            </div>
        </div>
    </div>

    
    <?php include "../includes/footer.php"; ?> 

    
    <script src="/assets/js/theme.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
