<?php
require 'classCalculosStadisticos.php';

$resultado = "";
$numerosIngresados = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numerosIngresados = htmlspecialchars($_POST['numeros']); 
    $estadistica = new Estadistica($numerosIngresados);
    $resultado .= "<h2>Resultados:</h2>";
    $resultado .= "Números ingresados: " . $numerosIngresados . "<br>";
    $resultado .= "Promedio: " . $estadistica->calcularPromedio() . "<br>";
    $resultado .= "Mediana: " . $estadistica->calcularMediana() . "<br>";
    $resultado .= "Moda: " . $estadistica->calcularModa() . "<br>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="esta.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Calculadora Estadística</title>
</head>
<body>
    <div class="container">
        <div class="nav">
            <a href="../index.html" class="btn-back">
                ← Volver al inicio
            </a>
        </div>
        
        <div class="section">
            <div class="form-section">
                <h2>Calculadora Estadística</h2>
                <p>Calcula promedio, mediana y moda de un conjunto de números</p>
                
                <form method="post">
                    <div class="form-group">
                        <label for="numeros">Ingrese números separados por comas:</label>
                        <input type="text" id="numeros" name="numeros" required 
                               placeholder="Ejemplo: 1, 2, 3, 4, 5, 6, 7, 8, 9, 10"
                               value="<?php echo htmlspecialchars($numerosIngresados); ?>">
                    </div>
                    
                    <button type="submit" class="btn">
                        Calcular Estadísticas
                    </button>
                </form>
                
                <?php if ($resultado): ?>
                <div class="result-section">
                    <h3>Resultados Estadísticos</h3>
                    <div class="result-value">
                        <?php echo $resultado; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>