document.getElementById("postForm").onsubmit = function(e) {
    e.preventDefault();

    const titulo = document.getElementById("titulo").value;
    const contenido = document.getElementById("contenido").value;

    console.log("Nueva publicación creada:");
    console.log("Título:", titulo);
    console.log("Contenido:", contenido);

    alert("¡Publicación creada con éxito!");

    // En Laravel, aquí se enviará por POST a la base de datos
    location.href = "foro.php";
};