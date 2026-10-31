<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Árbol Binario</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="dark">
    <meta name="theme-color" content="#0f172a">
    <meta name="description" content="Herramienta para reconstruir y recorrer árboles binarios a partir de recorridos.">
    <style>
        .form-section input {
            color: var(--text-primary) !important;
            background: var(--bg-primary) !important;
            transition: none !important;
        }
        .form-section input::placeholder {
            color: var(--text-light);
        }
        .form-section, .form-section * {
            animation: none !important;
            transition: none !important;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="nav">
            <a href="../index.html" class="btn btn-secondary btn-back">← Volver</a>
        </nav>

        <section class="section form-section">
            <h2>Árbol Binario</h2>
            <p>Construye un árbol a partir de dos recorridos y visualiza sus recorridos resultantes.</p>

            <div class="examples">
                <h3>Ejemplos (usa comas)</h3>
                <div class="example">Preorden= A,B,D,E,C</div>
                <div class="example">Inorden= D,B,E,A,C</div>
                <div class="example">Postorden= D,E,B,C,A</div>
            </div>

            <form method="POST" action="Arbolbinario.php" class="form-group">
                <div class="traversals-container">
                    <div class="traversal-group">
                        <h3>Preorden</h3>
                        <input type="text" name="preorden" placeholder="Ej: A,B,D,E,C">
                        <small>Usa comas para separar los valores.</small>
                    </div>
                    <div class="traversal-group">
                        <h3>Inorden</h3>
                        <input type="text" name="inorden" placeholder="Ej: D,B,E,A,C">
                        <small>Usa comas para separar los valores.</small>
                    </div>
                    <div class="traversal-group">
                        <h3>Postorden</h3>
                        <input type="text" name="postorden" placeholder="Ej: D,E,B,C,A">
                        <small>Usa comas para separar los valores.</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Construir árbol</button>
            </form>


        </section>

    <?php
    include("clasArbolbinario.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $pre = isset($_POST["preorden"]) ? $_POST["preorden"] : '';
        $in = isset($_POST["inorden"]) ? $_POST["inorden"] : '';
        $post = isset($_POST["postorden"]) ? $_POST["postorden"] : '';

        echo "<div class='result-section'>";

        if ($pre && $in) {
            $val = ArbolBinario::validarEntradas($pre, $in);
            if (!$val['ok']) {
                echo "<div class='error'><h3>Error de validación</h3><p>" . htmlspecialchars($val['mensaje']) . "</p></div>";
            } else {
                $arbol = ArbolBinario::desdePreIn($pre, $in);
                if ($arbol === null) {
                    echo "<div class='error'><h3>No se pudo construir el árbol</h3><p>Revisa que los recorridos correspondan al mismo árbol.</p></div>";
                } else {
                    echo "<h3>Árbol reconstruido (Pre + In)</h3>";
                    ArbolBinario::mostrarArbol($arbol);
                    ArbolBinario::mostrarRecorridos($arbol);
                }
            }
        } elseif ($post && $in) {
            $val = ArbolBinario::validarEntradas($post, $in);
            if (!$val['ok']) {
                echo "<div class='error'><h3>Error de validación</h3><p>" . htmlspecialchars($val['mensaje']) . "</p></div>";
            } else {
                $arbol = ArbolBinario::desdePostIn($post, $in);
                if ($arbol === null) {
                    echo "<div class='error'><h3>No se pudo construir el árbol</h3><p>Revisa que los recorridos correspondan al mismo árbol.</p></div>";
                } else {
                    echo "<h3>Árbol reconstruido (Post + In)</h3>";
                    ArbolBinario::mostrarArbol($arbol);
                    ArbolBinario::mostrarRecorridos($arbol);
                }
            }
        } elseif ($pre && $post) {
            $val = ArbolBinario::validarEntradas($pre, $post);
            if (!$val['ok']) {
                echo "<div class='error'><h3>Error de validación</h3><p>" . htmlspecialchars($val['mensaje']) . "</p></div>";
            } else {
                $arbol = ArbolBinario::desdePrePost($pre, $post);
                if ($arbol === null) {
                    echo "<div class='error'><h3>No se pudo construir el árbol</h3><p>La combinación Preorden + Postorden no determina un árbol único con estos datos (solo funciona con árboles donde cada nodo tiene 0 o 2 hijos). Agrega el recorrido Inorden para una reconstrucción confiable.</p></div>";
                } else {
                    echo "<h3>Árbol reconstruido (Pre + Post)</h3>";
                    ArbolBinario::mostrarArbol($arbol);
                    ArbolBinario::mostrarRecorridos($arbol);
                }
            }
        } else {
            echo "<div class='error'><h3>Faltan datos</h3>";
            echo "<div style='background: rgba(248, 113, 113, 0.08); border: 1px solid rgba(248, 113, 113, 0.3); border-radius: 8px; padding: 15px; margin: 10px 0;'>";
            echo "<p style='color: var(--danger-color); margin-bottom: 10px;'>Para construir un árbol binario necesitas:</p>";
            echo "<ul style='color: var(--danger-color); margin: 0; padding-left: 20px;'>";
            echo "<li><strong>Al menos 2 recorridos</strong> de los 3 disponibles (cualquier par: Pre+In, Post+In o Pre+Post)</li>";
            echo "</ul>";
            echo "<p style='color: var(--danger-color); margin-top: 10px; margin-bottom: 0;'><strong>Recomendación:</strong> Usa <strong>Preorden + Inorden</strong> o <strong>Postorden + Inorden</strong> para una reconstrucción siempre única.</p>";
            echo "</div></div>";
        }
        echo "</div>";
    }
    ?>

    <!-- Mensaje educativo permanente -->
    <div style="background: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin: 30px 0;">
        <h3 style="color: var(--text-primary); margin-top: 0; display: flex; align-items: center;">
            Información importante sobre recorridos
        </h3>
        <div style="background: rgba(234, 179, 8, 0.08); border: 1px solid rgba(234, 179, 8, 0.3); border-radius: 8px; padding: 15px; margin: 15px 0;">
            <h4 style="color: #fbbf24; margin-top: 0;">Limitaciones de Preorden + Postorden</h4>
            <p style="color: #fbbf24; margin-bottom: 10px;">La combinación <strong>Preorden + Postorden</strong> tiene limitaciones importantes:</p>
            <ul style="color: #fbbf24; margin: 0; padding-left: 20px;">
                <li><strong>No es única:</strong> Múltiples árboles pueden generar los mismos recorridos pre y post</li>
                <li><strong>Solo funciona con árboles completos:</strong> Cada nodo debe tener 0 o exactamente 2 hijos</li>
                <li><strong>Falta información estructural:</strong> Sin inorden, no se puede determinar la estructura interna</li>
            </ul>
            <p style="color: #fbbf24; margin-top: 10px; margin-bottom: 0;"><strong>Recomendación:</strong> Usa <strong>Preorden + Inorden</strong> o <strong>Postorden + Inorden</strong> para una reconstrucción única y confiable.</p>
        </div>
        <div style="background: rgba(96, 165, 250, 0.08); border: 1px solid rgba(96, 165, 250, 0.3); border-radius: 8px; padding: 15px;">
            <h4 style="color: #93c5fd; margin-top: 0;">Combinaciones recomendadas</h4>
            <ul style="color: #93c5fd; margin: 0; padding-left: 20px;">
                <li><strong>Preorden + Inorden:</strong> Reconstrucción única y confiable</li>
                <li><strong>Postorden + Inorden:</strong> Reconstrucción única y confiable</li>
                <li><strong>Inorden es esencial:</strong> Proporciona la información estructural necesaria</li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>
