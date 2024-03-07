<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="index.php" method="POST">
        <label for="dato">DATO: </label><input type="text" name="dato" id="dato">
        <input type="submit" name="encriptar" value="encriptar">
        <input type="submit" name="desencriptar" value="desencriptar">
    </form>
    <?php

    $continue = "m3m0c0d3";

    function encrypt($string, $ik)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $ikchar = substr($ik, ($i % strlen($ik)) - 1, 1);
            $char = chr(ord($char) + ord($ikchar));
            $result .= $char;
        }
        return base64_encode($result);
    }

    function decrypt($string, $ik)
    {
        $result = '';
        $string = base64_decode($string);
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $ikchar = substr($ik, ($i % strlen($ik)) - 1, 1);
            $char = chr(ord($char) - ord($ikchar));
            $result .= $char;
        }
        return $result;
    }

    if (isset($_POST["encriptar"])) {
        $dato = $_POST["dato"];
        echo $resultado = encrypt($dato, $continue);

    } elseif (isset($_POST["desencriptar"])) {
        $dato = $_POST["dato"];
        echo $resultado = decrypt($dato, $continue);
    }

    ?>
</body>

</html>