<?php

$response = array();

$Cn = mysqli_connect("localhost","root","","inventario")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    if (empty($objArray))
    {
        // required field is missing
        $response["success"] = 400;
        $response["message"] = "Faltan Datos entrada";
        echo json_encode($response);
    }
    else{
        $idprod=$objArray['idProd'];
        $nomprod=$objArray['nomProd']; 
        $existe=$objArray['existencia'];
        $precio=$objArray['precio'];
        $result = mysqli_query($Cn,"UPDATE producto SET nomProd='$nomprod',existencia=$existe,precio=$precio WHERE idProd=$idprod");
        if ($result) {   
            $response["success"] = 200;   // El success=200 es que encontro eñ producto
            $response["message"] = "Producto Actualizado";
            // codifica la información en formato de JSON response
            echo json_encode($response);
        } else {
                $response["success"] = 406;  
                $response["message"] = "El Producto no se actualizo";
                echo json_encode($response);
        }
    }
} else {
    // required field is missing
    $response["success"] = 400;
    $response["message"] = "Faltan Datos entrada";
    echo json_encode($response);
}
mysqli_close($Cn);
?>
