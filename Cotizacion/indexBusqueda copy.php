<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Buscar datos en tiempo real con PHP, MySQL y AJAX">
    <meta name="author" content="Stifler">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="img/faviconUnamba.png" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <title>COT-UNAMBA</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="styleIndex.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="cssBusquedaDosBoostrap.css">
    <link rel="stylesheet" href="cssBusquedaBootrap.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />

</head>

<body>
    <!-- load  start-->
    <style>
        /* Estilos para la imagen de carga */
        #imagen-carga {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
    </style>
    <img id="imagen-carga" src="Loading_2.gif" alt="Cargando...">


    <script>
        // Función para mostrar la imagen de carga
        function mostrarImagenCarga() {
            document.getElementById('imagen-carga').style.display = 'block';
        }

        // Función para ocultar la imagen de carga
        function ocultarImagenCarga() {
            document.getElementById('imagen-carga').style.display = 'none';
        }

        // Evento de carga de la página
        window.addEventListener('load', function () {
            // Ocultar la imagen de carga cuando la página se haya cargado completamente
            ocultarImagenCarga();
        });

        // Evento de descarga de la página (antes de que se recargue)
        window.addEventListener('beforeunload', function () {
            // Mostrar la imagen de carga antes de recargar la página
            mostrarImagenCarga();
        });
    </script>
    <!-- load  fin-->
    <h8 id="securityUserDetected main:user" class="ms-tx" itemid="as -de -e-e">->usted tiene buena conexion
    </h8>
    <main>
        <header><img src="img/banner.jpg" alt=""></header>
        <style>
            /* Estilo para pantallas más grandes que 1200px */
            @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&family=Saira+Condensed:wght@200&display=swap');

            @media (min-width: 1200px) {
                .container {
                    max-width: 1400px;
                }
            }

            .og-contianer {
                font-family: "Changa", sans-serif;
                font-optical-sizing: auto;
            }

            .registropagina {
                display: flex;
                justify-content: flex-start;
            }

            .cabezerafilter {
                display: flex;
                justify-content: flex-end;
            }

            .custom-select {
                width: 200px;
                /* Ancho personalizado */
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 16px;
            }

            /* Estilo para las opciones */
            .custom-select option {
                background-color: #fff;
                /* Color de fondo */
                color: #333;
                /* Color del texto */
            }

            /* Estilo para el select cuando está desplegado */
            .custom-select:focus {
                outline: none;
                /* Eliminar el contorno al enfocar */
                border-color: #007bff;
                /* Cambiar el color del borde al enfocar */
                box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                /* Efecto de sombra al enfocar */
            }

            .cabezeraCotiza {
                /* margin-top: 10px; */
                margin-left: 150px;
                margin-right: 150px;
                display: flex;
                justify-content: space-between;

            }
        </style>
        <div class="container py-4 text-center">
            <h3 class="titulo" style="color: #0c6cccc7;  margin-bottom: 25px;">LISTA DE COTIZACIONES y SERVICIOS
            </h3>

            <div class="og-contianer">
                <div class="row g-4 cabezerafilter">

                    <!-- <div class="col-5"></div> -->
                    <!-- buscador  -->
                    <div class="col-5" style="display: flex; justify-content: space-evenly;">
                        <select class="" id="optiona" placeholder="Tipo">
                            <option value="" selected="">Tipo todos</option>
                            <option name="bienes" value="bienes">bienes</option>
                            <option name="servicios" value="servicios">servicios</option>
                        </select>
                        <select class="" id="optionb" placeholder="dependencia">
                            <option value="" selected="">dependencia todos</option>
                            <option name="Unamba-Imagen" value="Unamba-Imagen">Unamba-Imagen</option>
                            <option name="Unamba-RRH" value="Unamba-RRH">Unamba-RRH</option>
                            <option name="Unamba-PTT" value="Unamba-PTT">Unamba-PTT</option>
                            <option name="Unamba-Imagen" value="Unamba-Imagen">Unamba-Imagen</option>
                            <option name="Unamba-Tesorería" value="Unamba-Tesorería">Unamba-Tesorería</option>
                            <option name="Unamba-Planificación" value="Unamba-Planificación">Unamba-Planificación
                            </option>
                            <option name="Unamba-Proyeccion" value="Unamba-Proyeccion">Unamba-Proyeccion</option>
                            <option name="Unamba-Calidad" value="Unamba-Calidad">Unamba-Calidad</option>
                            <option name="Unamba-Desarrollo" value="Unamba-Desarrollo">Unamba-Desarrollo</option>
                            <option name="Unamba-Investigación" value="Unamba-Investigación">Unamba-Investigación
                            </option>
                            <option name="Unamba-Comunicaciones" value="Unamba-Comunicaciones">Unamba-Comunicaciones
                            </option>
                            <option name="Unamba-Producción" value="Unamba-Producción">Unamba-Producción
                            </option>
                            <option name="Unamba-Abastecimiento" value="Unamba-Abastecimiento">Unamba-Abastecimiento
                            </option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="campo" class="col-form-label">Buscar: </label>
                    </div>
                    <div class="col-auto">
                        <input type="text" name="campo" id="campo" class="form-control">
                    </div>
                    <!-- aqui iva el ganination  -->

                </div>
                <div class="row py-4">
                    <div class="registropagina">
                        <div class="col-auto">
                            <label for="num_registros" class="col-form-label">Mostrar: </label>
                        </div>
                        <div class="col-auto">
                            <select name="num_registros" id="num_registros" class="form-select">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>

                        <div class="col-auto">
                            <label for="num_registros" class="col-form-label">registros </label>
                        </div>
                    </div>

                    <br>
                    <br>
                    <div class="col">

                        <table class="table table-sm table-bordered table-striped">
                            <thead style="background-color: #ffdc002e;
                          color: #033c77;
                          ">


                                <th class="sort asc"><i class="ri-contract-up-down-line" style=" color: red;"></i>Nro.
                                    COTIZACIÓN </th>
                                <th class="sort asc"><i class="ri-arrow-drop-down-fill" style=" color: green;"></i>
                                    COTIZACIÓN</th>
                                <th class="sort asc"><i class="ri-arrow-drop-down-fill" style=" color: green;"></i>
                                    DEPENDENCIA</th>
                                <th class="sort asc"><i class="ri-arrow-drop-down-fill" style=" color: green;"></i>
                                    DESCRIPCIÓN</th>
                                <th class="sort asc"><i class="ri-arrow-drop-down-fill" style=" color: green;"></i>
                                    FECHA
                                    PLAZO</th>
                                <th class="sort asc"><i class="ri-arrow-drop-down-fill" style=" color: green;"></i>
                                    OPCIONES
                                </th>

                            </thead>
                            <!-- El id del cuerpo de la tabla. -->
                            <tbody id="content" style="
                        color: #033c77;
                          ">
                                <!-- <h1>hola mundo</h1> -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <label id="lbl-total"></label>
                    </div>
                    <div class="col-6" id="nav-paginacion"></div>
                    <input type="hidden" id="pagina" value="1">
                    <input type="hidden" id="orderCol" value="0">
                    <input type="hidden" id="orderType" value="asc">
                </div>
            </div>
        </div>
    </main>

    <script>

        //es la obtencion de los elemtos al evento keyup del buscador
        getData()
        //es la obtencion evento keyup a buscador
        document.getElementById("campo").addEventListener("keyup", function () {
            getData()
        }, false)
        document.getElementById("optiona").addEventListener("change", function () {
            getData();
        }, false);
        document.getElementById("optionb").addEventListener("change", function () {
            getData();
        }, false);

        //es la obtencion de change a mostrar de la lista
        document.getElementById("num_registros").addEventListener("change", function () {
            getData()
        }, false)
        /* Peticion AJAX */
        function getData() {


            // el valor del campo 
            let input = document.getElementById("campo").value
            let inputa = document.getElementById("optiona").value
            console.log(inputa)
            let inputb = document.getElementById("optionb").value
            console.log(inputb)
            // el valor del registro a mostrar 
            let num_registros = document.getElementById("num_registros").value
            //contenido de la tabla
            let content = document.getElementById("content")
            // tabla pagina
            let pagina = document.getElementById("pagina").value
            // tabla ordenamiento
            let orderCol = document.getElementById("orderCol").value
            // tabla ordenamiento
            let orderType = document.getElementById("orderType").value
            if (pagina == null) {
                pagina = 1
            }

            let url = "busqueda.php"

            let formaData = new FormData()
            formaData.append('campo', input)
            formaData.append('optiona', inputa)
            formaData.append('optionb', inputb)

            formaData.append('registros', num_registros)
            formaData.append('pagina', pagina)
            formaData.append('orderCol', orderCol)
            formaData.append('orderType', orderType)

            fetch(url, {
                method: "POST",
                body: formaData
            }).then(response => response.json())
                .then(data => {
                    content.innerHTML = data.data
                    document.getElementById("lbl-total").innerHTML = 'Mostrando ' + data.totalFiltro +
                        ' de ' + data.totalRegistros + ' registros'
                    document.getElementById("nav-paginacion").innerHTML = data.paginacion
                }).catch(err => console.log(err))
        }
        function nextPage(pagina) {
            document.getElementById('pagina').value = pagina
            getData()
        }

        let columns = document.getElementsByClassName("sort")
        let tamanio = columns.length
        for (let i = 0; i < tamanio; i++) {
            columns[i].addEventListener("click", ordenar)
        }

        function ordenar(e) {
            let elemento = e.target

            document.getElementById('orderCol').value = elemento.cellIndex

            if (elemento.classList.contains("asc")) {
                document.getElementById("orderType").value = "asc"
                elemento.classList.remove("asc")
                elemento.classList.add("desc")
            } else {
                document.getElementById("orderType").value = "desc"
                elemento.classList.remove("desc")
                elemento.classList.add("asc")
            }
            getData()
        }

    </script>
    <style>
        .li {
            display: none;
        }



        .fecha-pasada {
            background-color: #c5eee340;
        }

        .fecha-pasada td button {
            display: none;

        }

        .fecha-pasada td a {
            display: none;

        }

        .fuuter {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <footer class="cabezeraCotiza  ">
        <h5> Copyright 2024©
        </h5>
        <h5>
            <a href="https://www.unamba.edu.pe/"> Universidad Nacional Micaela Bastidas de Apurímac
            </a>

        </h5>

    </footer>
    <div class="fuuter">
        <div>
            <h7 class="GO-FT" id="gen-ip">
                -> ip.regET ?
                $ip = $_SERVER['USER'];
                $current = file_get_contents($file);
        </div>
        <div>
            <a href="../dashboard/admin_login.php" target="_blank">soy admin</a>
        </div>

        </h7>
    </div>

    <img id="imagen-carga" src="Loading_2.gif" alt="Cargando...">

</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>


</html>