<?php
$response = array();
$Cn = mysqli_connect("localhost","root","","inventario")or die ("server no encontrado");
mysqli_set_charset($Cn,"utf8");
// Checa que le esté llegando por el método POST el idProd
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $objArray = json_decode(file_get_contents("php://input"),true);
    $idprod=$objArray['idProd'];
    $result = mysqli_query($Cn,"SELECT idProd,nomProd,existencia,precio from producto WHERE idProd = $idprod");

    if (!empty($result)) {
        if (mysqli_num_rows($result) > 0) {

            $result = mysqli_fetch_array($result);
           	$producto = array();

            $producto["idProd"] = $result["idProd"];
		    $producto["nomProd"] = $result["nomProd"];
    		$producto["existencia"] = $result["existencia"];
    		$producto["precio"]=$result["precio"];
   
           $response["success"] = 200;   // El success=200 es que encontro el producto
           $response["message"] = "Producto encontrado";
           $response["producto"] = array();

           array_push($response["producto"], $producto);

           // codifica la información en formato de JSON response
           echo json_encode($response);
        } else {
            // No Encontro el producto
            $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
            $response["message"] = "Producto no encontrado";
            echo json_encode($response);
        }
    } else {
        $response["success"] = 404;  //No encontro información y el success = 0 indica no exitoso
        $response["message"] = "Producto no encontrado";
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 400;
    $response["message"] = "Faltan Datos entrada";
    echo json_encode($response);
}
mysqli_close($Cn);
?>
