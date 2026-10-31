<?php
require 'claseAcronimo.php';

$acronimo = "";
$fraseOriginal = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["frase"])) {
    $fraseOriginal = trim($_POST["frase"]);
    $obj = new Acronimo($fraseOriginal);
    $acronimo = $obj->getAcronimo();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="acronimo.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Generador de Acrónimos</title>
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
                <h2>Generador de Acrónimos</h2>
                <p>Ingresa una frase y genera un acrónimo con las primeras letras de cada palabra</p>
                
                <form method="post">
                    <div class="form-group">
                        <label for="frase">Ingrese una frase:</label>
                        <input type="text" id="frase" name="frase" required 
                               placeholder="Ejemplo: Organización de las Naciones Unidas"
                               value="<?php echo htmlspecialchars($fraseOriginal); ?>">
                    </div>
                    
                    <button type="submit" class="btn">
                        Generar Acrónimo
                    </button>
                </form>
                
                <?php if ($acronimo != ""): ?>
                <div class="result-section">
                    <h3>Resultado</h3>
                    <div class="result-value">
                        <strong>Frase:</strong> <?php echo htmlspecialchars(strtolower($fraseOriginal)); ?><br>
                        <strong>Acrónimo:</strong> <?php echo strtoupper($acronimo); ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
