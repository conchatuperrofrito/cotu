<?php
$update_id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="faviconUnamba.png" type="image/x-icon">
    <title>UNAMBA</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="styleCotizacion.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
    <style>
        .error-border {
            border: 1px solid red;
        }
    </style>
    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
         <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
        }
    }
    ?>
    <header class="cabezeraCotiza">
        <h2> <i class="ri-hotel-line" style=" color: blue;"></i> COTIZACIONES - UNAMBA
            <div>
                <h5>
                    <h5> <a href="../../index.php">UNAMBA</a> / <a href="../../../index.php">Lista de
                            Cotizaciones</a> / <a href="">Enviar
                            Cotización</a>
                    </h5>
                </h5>
            </div>
        </h2>
        <img src="../img/Logotipo-UNAMBA-página-web.png" alt="" style=" color: blue;" class="logoUnamba">
    </header>
    <div class="cabezeraCotiza">
        <div>
            <h3 style="  text-decoration: underline;
                    "> FORMULARIO DE ENVIÓ DE COTIZACIONES</h3>
            <h4> Estimados proveedores, para mayor facilidad se ha puesto a su disposición este formulario, que le
                permitirá
                el
                envío de la oferta económica. Complete sus datos correctamente. Los campos del formulario con * deben
                ser
                llenados obligatoriamente.</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form id="msform" method="post" enctype="multipart/form-data" action="formCotizacionSend.php">
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active">informacion general</li>
                    <li>Social informacion</li>
                    <li>subir propuesta</li>
                </ul>
                <!-- fieldsets -->
                <fieldset>
                    <style>
                    </style>
                    <h2 class="fs-title">informacion general</h2>
                    <h2 class="fs-subtitle" style="color: #167c5a;">ingrese correctamente su información sin ningún tipo
                        de
                        símbolos</h2>
                    <h2 class="fs-subtitle" style="color: #167c5a;">solo puede enviar una propuesta por nº de cotización
                    </h2>
                    <input type="text" name="nombre" placeholder="nombre completo" id="nombreInput"
                        oninput="validarNombre()" required />
                    <span style="color: red;" id="mensajeError"></span>
                    <input type="number" name="DNI" maxlength="8" placeholder="N| DNI" id="dniInput" pattern="[0-9]{8}"
                        title="Ingresa un número de DNI válido de 8 dígitos" oninput="validarDni()" required />
                    <span style="color: red;" id="mensajeErrorDni"></span>
                    <input type="number" name="ruc" maxlength="11" placeholder="n| ruc" id="rucInput"
                        pattern="[0-9]{11}" title="Ingresa un número de RUC válido de 11 dígitos" oninput="validarRuc()"
                        required />
                    <span style="color: red;" id="mensajeErrorRuc"></span> <br>
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Social informacion</h2>
                    <h3 class="fs-subtitle">informacion </h3>
                    <input type="text" name="direccion" placeholder="direccion" />
                    <input type="email" name="correo" placeholder="correo" id="correoInput" oninput="validarCorreo()" />
                    <span style="color: red;" id="mensajeErrorCorreo"></span>
                    <input type="number" name="phone" maxlength="9" placeholder="telefono" id="foneInput"
                        oninput="validarFone()" />
                    <span style="color: red;" id="mensajeErrorFone"></span> <br>
                    <input type="button" name="previous" class="previous action-button-previous" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">subir propuesta</h2>
                    <h3 class="fs-subtitle">solo archivo pdf menor a 40 MB</h3>
                    <h3 class="fs-subtitle" style="color: #167c5a;">formulario incorecto no se enviara </h3>
                    <input type="hidden" name="id" value="<?php echo $update_id; ?>">
                    <input type="file" name="pdfFile" id="pdfFile" accept=".pdf" required>
                    <p id="message"></p>
                    <input type="button" class="previous action-button-previous" value="Previous" />
                    <input type="submit" name="submit" class="submit action-button" value="enviar"
                        onclick="validatePDF()" />
                </fieldset>
            </form>
        </div>
    </div>
    <!-- balidacione -->
    <script>
        function validarNombre() {
            var nombreInput = document.getElementById('nombreInput');
            var mensajeError = document.getElementById('mensajeError');
            var nombre = nombreInput.value.trim();
            // Expresión regular para validar que solo contenga letras y espacios
            var regexNombre = /^[a-zA-Z\s]+$/;
            if (nombre.length < 3 || !regexNombre.test(nombre)) {
                mensajeError.textContent = 'Ingrese un nombre valido';
                nombreInput.classList.add('error-border');
            } else {
                mensajeError.textContent = '';
                nombreInput.classList.remove('error-border');
            }
        }
        function validarRuc() {
            var rucInput = document.getElementById('rucInput');
            var rucError = document.getElementById('mensajeErrorRuc');
            var ruc = rucInput.value.trim();
            // Expresión regular para validar que solo contenga letras y espacios
            var regexRuc = /^[0-9]{11}$/;
            if (ruc.length < 3 || !regexRuc.test(ruc)) {
                rucError.textContent = 'Ingrese un ruc valido';
                rucInput.classList.add('error-border');
            } else {
                rucError.textContent = '';
                rucInput.classList.remove('error-border');
            }
        }
        function validarDni() {
            var dniInput = document.getElementById('dniInput');
            var mensajeErrorDni = document.getElementById('mensajeErrorDni');
            var dni = dniInput.value.trim();
            // Expresión regular para validar que solo contenga letras y espacios
            var regexDni = /^[0-9]{8}$/;

            if (dni.length < 3 || !regexDni.test(dni)) {
                mensajeErrorDni.textContent = 'Ingrese un nº DNI valido';
                dniInput.classList.add('error-border');
            } else {
                mensajeErrorDni.textContent = '';
                dniInput.classList.remove('error-border');
            }
        }
        function validarFone() {
            var foneInput = document.getElementById('foneInput');
            var mensajeErrorFone = document.getElementById('mensajeErrorFone');
            var fone = foneInput.value.trim();
            // Expresión regular para validar que solo contenga letras y espacios
            var regexFone = /^[0-9]{9}$/;
            if (fone.length < 3 || !regexFone.test(fone)) {
                mensajeErrorFone.textContent = 'Ingrese un nº celular valido';
                foneInput.classList.add('error-border');
            } else {
                mensajeErrorFone.textContent = '';
                foneInput.classList.remove('error-border');
            }
        }
        function validarCorreo() {
            var correoInput = document.getElementById('correoInput');
            var mensajeErrorCorreo = document.getElementById('mensajeErrorCorreo');
            var correo = correoInput.value.trim();
            // Expresión regular para validar que solo contenga letras y espacios
            var regexFone = /[^\s@]+@[^\s@]+\.[^\s@]+/;
            if (correo.length < 3 || !regexFone.test(correo)) {
                mensajeErrorCorreo.textContent = 'Ingrese un correo valido';
                correoInput.classList.add('error-border');
            } else {
                mensajeErrorCorreo.textContent = '';
                correoInput.classList.remove('error-border');
            }
        }
    </script>
    <script>
        function validarFormulario() {
            // Validación del nombre
            var nombreInput = document.getElementsByName('nombre')[0];
            const messageElement1 = document.getElementById('message');
            if (nombreInput.value.trim() === '') {
                alert('Por favor, ingresa tu nombre completo.');
                messageElement.textContent = 'Por favor, ingresa tu nombre completo.';
                return false;
            }
            // Validación del DNI
            var dniInput = document.getElementById('dniInput');
            if (!dniInput.checkValidity()) {
                alert('Ingresa un número de DNI válido de 8 dígitos.');
                messageElement.textContent = 'Ingresa un número de DNI válido de 8 dígitos.';

                return false;
            }
            // Validación del RUC
            var rucInput = document.getElementById('rucInput');
            if (!rucInput.checkValidity()) {
                messageElement.textContent = 'Ingresa un número de RUC válido de 11 dígitos.';
                alert('Ingresa un número de RUC válido de 11 dígitos.');
                return false;
            }
            return true;
        }
    </script>
    <script>
        function validatePDF() {
            const fileInput = document.getElementById('pdfFile');
            const messageElement = document.getElementById('message');
            const file = fileInput.files[0];
            if (!file) {
                messageElement.textContent = 'No se ha seleccionado ningún archivo.';
                return;
            }
            if (file.type !== 'application/pdf') {
                messageElement.textContent = 'Por favor, selecciona un archivo PDF.';
                return;
            }
            if (file.size > 40 * 1024 * 1024) {
                messageElement.textContent = 'El archivo excede el tamaño máximo permitido de 40 MB.';
                return;
            }
        }
    </script>
    <div class="cabezeraCotiza">
        <div>
            <h3 style="  text-decoration: underline;
             "> NOTA IMPORTANTE</h3>
            <h4> <i class="ri-article-fill" style=" color: blue;"></i> La oferta económica deberá ser entregada en
                formato digital (PDF). El tamaño máximo del documento
                escaneado es de 40MB.</h4>
            <br>
            <h4><i class="ri-article-fill" style=" color: blue;"></i> la oferta económica deberá de adjuntar
                obligatoriamente los siguientes documentos: DECLARACIÓN JURADA
                (ANEXO 05), RNP VIGENTE , CCI (CUENTA CORRIENTE INTERBANCARIA HABILITADA OBLIGATORIAMENTE BAJO ANULACIÓN
                DE PAGO), CONSULTA RUC , CUENTA CORRIENTE DE DETRACCIÓN (DE SER EL CASO).</h4> <br>
            <h4><i class="ri-article-fill" style=" color: blue;"></i> En la solicitud de cotizaciones deberán de llenar
                las condiciones de COMPRA ubicadas en la parte
                inferior de la solicitud de cotización, con su respectiva Firma y Sello.</h4> <br>
            <h4><i class="ri-article-fill" style=" color: blue;"></i> El envió de las cotizaciones se debe realizar
                antes de la fecha de entrega y acto público.</h4>
        </div>
    </div>
    <footer class="cabezeraCotiza  ">
        <h5> Copyright 2024©
        </h5>
        <h5>
            <a href="https://www.unamba.edu.pe/"> Universidad Nacional Micaela Bastidas de Apurímac
            </a>
        </h5>
    </footer>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="scriptCotizacion.js"></script>

</html>