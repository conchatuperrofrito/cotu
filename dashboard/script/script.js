$(document).ready(function () {
  // Ocultar todos los artículos excepto el primero
  $(".larg:not(:first)").hide();

  // Manejar el clic en los enlaces del menú de navegación
  $("body").on("click", "nav ul li a", function () {
    var title = $(this).data("title");
    $(".title").children("h2").html(title);

    // Obtener el índice del artículo correspondiente al enlace clicado
    var index = $(this).parent().index();

    // Mostrar el artículo correspondiente y ocultar los demás
    $(".larg").hide().eq(index).show();
  });

  // Manejar el clic en el título de cada artículo para expandir o contraer el contenido
});
