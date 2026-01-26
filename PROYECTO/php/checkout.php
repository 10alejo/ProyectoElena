<?php

if (isset($_GET['plan'])) {

    $plan_id = htmlspecialchars($_GET['plan']);
}

else {

    $plan_id = 'basico';
}

$nombre_plan = "";
$precio = 0.00;

// Depende del plan ponemos un precio diferente, y el nombre del plan segun lo que escoja el usuario

switch ($plan_id) {

    case 'avanzado':

        $nombre_plan = "Plan Avanzado";
        $precio = 15.00;
        break;

    case 'ultimate':

        $nombre_plan = "Plan Pro AllGim";
        $precio = 19.99;
        break;

    case 'basico':
        
        default:
        $nombre_plan = "Plan Principiante";
        $precio = 10.00;
        break;
}

$precioMostrar = number_format($precio, 2);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago de Membresía</title>
    <link rel="icon" href="../php/mostrar_foto.php?nombre=logo" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/estiloCheckout.css">
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="row payment-card">

                    <div class="col-md-5 left-side">

                        <img src="../php/mostrar_foto.php?nombre=logo" alt="Logo Gym"
                            class="img-fluid rounded-circle mb-4"
                            style="width: 180px; height: 180px; object-fit: cover; border: 5px solid rgba(255,255,255,0.3); box-shadow: 0 4px 15px rgba(0,0,0,0.2); background: white;"
                            onerror="this.style.display='none'">

                        <h4>Resumen de Compra</h4>

                        <div class="mt-4 p-3 w-100" style="background: rgba(255,255,255,0.1); border-radius: 10px;">
                            <p class="small mb-1 opacity-75 text-uppercase">Estás adquiriendo:</p>
                            <h3 class="fw-bold mb-0"><?php echo $nombre_plan; ?></h3>
                        </div>

                        <div class="mt-5">
                            <p class="small mb-0 opacity-75">Total a pagar</p>
                            <h2 class="fw-bold display-5">€<?php echo $precioMostrar; ?></h2>
                        </div>
                    </div>

                    <div class="col-md-7 right-side">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="text-primary mb-0">Pago con Tarjeta</h3>
                            <i class="fa fa-credit-card fa-2x text-muted"></i>
                        </div>

                        <hr class="text-muted mb-4">

                        <form action="" method="POST">
                            <input type="hidden" name="monto_final" value="<?php echo $precio; ?>">
                            <input type="hidden" name="metodo_pago" value="Tarjeta Credito/Debito">
                            <input type="hidden" name="plan_gym" value="<?php echo $nombre_plan; ?>">

                            <div class="mb-3">
                                <label class="form-label">Titular de la tarjeta</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control"
                                        placeholder="Nombre como aparece en la tarjeta" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Número de Tarjeta</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-credit-card"></i></span>
                                    <input type="text" class="form-control" placeholder="0000 0000 0000 0000"
                                        maxlength="19" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Vencimiento</label>
                                    <input type="text" class="form-control" placeholder="MM/AA" maxlength="5" required>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">CVV</label>
                                    <input type="password" class="form-control" placeholder="123" maxlength="3" required>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 btn-lg mt-3 shadow-sm">Pagar €<?php echo $precioMostrar; ?> <i class="fas fa-lock ms-2"></i></button>

                            <div class="text-center mt-3">
                                <small class="text-muted"><i class="fas fa-check-circle text-success"></i> Transacción segura SSL</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>