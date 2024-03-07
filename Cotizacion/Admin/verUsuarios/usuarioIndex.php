<!-- traba inicio   -->

<main>
    <style>
        /* Estilo para pantallas más grandes que 1200px */
        @import url('https://fonts.googleapis.com/css2?family=Changa:wght@200..800&family=Saira+Condensed:wght@200&display=swap');

        @media (min-width: 1200px) {
            .container {
                max-width: 1400px;
            }
        }

        .actualizarboton {
            width: 100px;
            border-radius: 0px;
            margin-bottom: 5px;
            background-color: #6dedff;
            color: black;
        }

        .actualizarboton:hover {
            background-color: black;
            color: #6dedff;
        }

        .eliminarboton {
            border-radius: 0px;
            width: 100px;
            background-color: black;
            color: #6dedff;
        }

        .eliminarboton:hover {
            background-color: white;
            color: black;
        }

        .og-contianer {
            font-family: "Changa", sans-serif;
            font-optical-sizing: auto;
        }

        .registropagina {
            display: flex;
            justify-content: space-between;
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


        .autoLinea {
            display: flex;
        }
    </style>
    <div class="container py-4 text-center">
        <div class="og-contianer">
            <div class="row g-4 cabezerafilter">

                <!-- <div class="col-5"></div> -->
                <!-- buscador  -->
                <div class="col-5" style="display: none; justify-content: space-evenly;">
                    <select class="" id="optiona" placeholder="Tipo">
                        <option value="" selected="">Tipo todos</option>
                        <option name="Vienes" value="Vienes">Vienes</option>
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

                <!-- aqui iva el ganination  -->

            </div>
            <div class="row py-4">
                <div class="registropagina">
                    <div class="autoLinea">
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

                    <div class="autoLinea">
                        <div class="col-auto">
                            <label for="campo" class="col-form-label">Buscar: </label>
                        </div>
                        <div class="col-auto">
                            <input type="text" name="campo" id="campo" class="form-control">
                        </div>
                    </div>
                </div>


                <br>
                <br>
                <div class="col">

                    <table class="table table-sm table-bordered table-striped">
                        <thead style="background-color: #ffdc002e;
                          color: #033c77;
                          ">

                            <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i> Nro.
                                DNI </th>
                            <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                                CORREO</th>
                            <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                                ESTADO</th>
                            <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                                NOMBRE</th>

                            <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                                TELEFONO
                            </th>
                            <th class="sort asc"><i class="ri-expand-height-line" style=" color: red;"></i>
                                TIPO
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
<footer class="cabezeraCotiza  ">
    <h5> Copyright 2024©
    </h5>
    <h5>
        <a href="https://www.unamba.edu.pe/"> Universidad Nacional Micaela Bastidas de Apurímac
        </a>
    </h5>
</footer>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
    integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>