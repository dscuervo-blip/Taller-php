<?php
session_start();
require 'classCalculadora.php';

if (!isset($_SESSION['historialCalculadora'])) {
    $_SESSION['historialCalculadora'] = [];
}

$resultado = null;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['borrarHistorial'])) {
        $_SESSION['historialCalculadora'] = [];
    } elseif (isset($_POST['numero1']) && isset($_POST['numero2']) && isset($_POST['operacion'])) {
        if ($_POST['numero1'] === '' || $_POST['numero2'] === '' || !is_numeric($_POST['numero1']) || !is_numeric($_POST['numero2'])) {
            $error = "Ingrese dos números válidos (enteros o decimales).";
        } else {
            $numero1 = $_POST['numero1'];
            $numero2 = $_POST['numero2'];
            $operacion = $_POST['operacion'];

            $calculadora = new Calculadora($numero1, $numero2);
            $resultado = $calculadora->calcular($operacion);

            $simbolo = Calculadora::simboloOperacion($operacion);
            $expresion = htmlspecialchars($numero1) . " " . $simbolo . " " . htmlspecialchars($numero2)
                . " = " . (is_numeric($resultado) ? $resultado : htmlspecialchars($resultado));

            $_SESSION['historialCalculadora'][] = $expresion;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="calculadora.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Calculadora</title>
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
                <h2>Calculadora</h2>
                <p>Realiza operaciones básicas con números enteros o decimales y consulta el historial de cálculos</p>

                <?php if ($error != ""): ?>
                <div class="error">
                    <h3>Error</h3>
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
                <?php endif; ?>

                <form method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="numero1">Primer número:</label>
                            <input type="number" id="numero1" name="numero1" step="any" required
                                   placeholder="Ejemplo: 10"
                                   value="<?php echo isset($_POST['numero1']) ? htmlspecialchars($_POST['numero1']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="numero2">Segundo número:</label>
                            <input type="number" id="numero2" name="numero2" step="any" required
                                   placeholder="Ejemplo: 5"
                                   value="<?php echo isset($_POST['numero2']) ? htmlspecialchars($_POST['numero2']) : ''; ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="operacion">Seleccione la operación:</label>
                        <select id="operacion" name="operacion" required>
                            <option value="suma" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == 'suma') ? 'selected' : ''; ?>>Suma</option>
                            <option value="resta" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == 'resta') ? 'selected' : ''; ?>>Resta</option>
                            <option value="multiplicacion" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == 'multiplicacion') ? 'selected' : ''; ?>>Multiplicación</option>
                            <option value="division" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == 'division') ? 'selected' : ''; ?>>División</option>
                            <option value="porcentaje" <?php echo (isset($_POST['operacion']) && $_POST['operacion'] == 'porcentaje') ? 'selected' : ''; ?>>Porcentaje (número1 % de número2)</option>
                        </select>
                        <small>Para porcentaje: el resultado es "número1% de número2" (ej: 20 y 150 → 30).</small>
                    </div>

                    <button type="submit" class="btn">
                        Calcular
                    </button>
                </form>

                <?php if ($resultado !== null): ?>
                <div class="result-section">
                    <h3>Resultado</h3>
                    <div class="result-value">
                        <?php echo is_numeric($resultado) ? $resultado : htmlspecialchars($resultado); ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="result-section" style="background: var(--bg-secondary); border-left: 4px solid var(--secondary-color);">
                    <h3 style="color: var(--secondary-color);">Historial de operaciones</h3>
                    <?php if (empty($_SESSION['historialCalculadora'])): ?>
                        <p class="historial-vacio">Aún no hay operaciones registradas.</p>
                    <?php else: ?>
                        <div class="result-list">
                            <?php foreach (array_reverse($_SESSION['historialCalculadora']) as $item): ?>
                                <div class="historial-item"><?php echo $item; ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" class="calc-actions">
                        <button type="submit" name="borrarHistorial" value="1" class="btn btn-danger">
                            Borrar historial
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
