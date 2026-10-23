<?php
// admin_proyectos.php
require_once __DIR__ . '/config/conexion.php';

$mensaje = '';
$tipo_alerta = '';

// Procesar el envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'crear_proyecto') {
    $titulo = trim($_POST['titulo'] ?? '');
    $categoria = trim($_POST['categoria'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $orden = (int)($_POST['orden'] ?? 0);

    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['imagen']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($fileExtension, $extensiones_permitidas)) {
            $nuevoNombreImagen = 'proyecto_' . time() . '_' . uniqid() . '.' . $fileExtension;
            $uploadFileDir = __DIR__ . '/img/';
            $dest_path = $uploadFileDir . $nuevoNombreImagen;

            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $dest_path)) {
                $rutaBaseDatos = 'img/' . $nuevoNombreImagen;

                $stmt = $pdo->prepare("INSERT INTO proyectos (titulo, categoria, descripcion, imagen_url, orden) VALUES (:titulo, :categoria, :descripcion, :imagen_url, :orden)");
                $exito = $stmt->execute([
                    ':titulo' => $titulo,
                    ':categoria' => $categoria,
                    ':descripcion' => $descripcion,
                    ':imagen_url' => $rutaBaseDatos,
                    ':orden' => $orden
                ]);

                if ($exito) {
                    $mensaje = "¡Proyecto publicado con éxito!";
                    $tipo_alerta = "exito";
                } else {
                    $mensaje = "Error al guardar el registro en la base de datos.";
                    $tipo_alerta = "error";
                }
            } else {
                $mensaje = "Error al mover el archivo a la carpeta img/. Revisa los permisos.";
                $tipo_alerta = "error";
            }
        } else {
            $mensaje = "Formato de imagen no permitido (solo JPG, PNG y WEBP).";
            $tipo_alerta = "error";
        }
    } else {
        $mensaje = "Debes seleccionar una imagen para el proyecto.";
        $tipo_alerta = "error";
    }
}

// Eliminar proyecto
if (isset($_GET['eliminar'])) {
    $id_eliminar = (int)$_GET['eliminar'];
    
    $stmtImg = $pdo->prepare("SELECT imagen_url FROM proyectos WHERE id = :id");
    $stmtImg->execute([':id' => $id_eliminar]);
    $proj = $stmtImg->fetch();
    
    if ($proj && !empty($proj['imagen_url']) && file_exists(__DIR__ . '/' . $proj['imagen_url'])) {
        unlink(__DIR__ . '/' . $proj['imagen_url']);
    }

    $stmtDel = $pdo->prepare("DELETE FROM proyectos WHERE id = :id");
    $stmtDel->execute([':id' => $id_eliminar]);
    header("Location: admin_proyectos.php");
    exit();
}

$proyectos = $pdo->query("SELECT * FROM proyectos ORDER BY orden ASC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrar Proyectos - JVDeveloper</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background-color: #070d19; color: #fff; font-family: 'Inter', sans-serif; padding: 2rem; }
        .admin-card { background: #0e172a; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 12px; padding: 2rem; max-width: 800px; margin: 0 auto 2rem auto; }
        h2 { margin-bottom: 1.5rem; color: #00d2d3; }
        .form-group { margin-bottom: 1.2rem; }
        label { display: block; margin-bottom: 0.4rem; color: #8e9bb0; font-size: 0.9rem; }
        input[type="text"], textarea, input[type="number"], input[type="file"] { width: 100%; padding: 0.8rem; background: #070d19; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 8px; color: #fff; box-sizing: border-box; }
        .btn-submit { background: #1d72f3; color: #fff; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer; width: 100%; }
        .alert { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; }
        .alert-exito { background: rgba(46, 204, 113, 0.2); color: #2ecc71; border: 1px solid #2ecc71; }
        .alert-error { background: rgba(231, 76, 60, 0.2); color: #e74c3c; border: 1px solid #e74c3c; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { padding: 0.8rem; border-bottom: 1px solid rgba(255,255,255,0.1); text-align: left; }
        th { color: #8e9bb0; }
        .img-preview { width: 60px; height: 40px; object-fit: cover; border-radius: 4px; }
        .btn-delete { color: #e74c3c; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>

    <div class="admin-card">
        <h2>Subir Nuevo Proyecto</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-<?= $tipo_alerta ?>"><?= htmlspecialchars($mensaje) ?></div>
        <?php endif; ?>

        <form action="admin_proyectos.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="crear_proyecto">
            
            <div class="form-group">
                <label for="titulo">Título del Proyecto</label>
                <input type="text" id="titulo" name="titulo" placeholder="Ej: E-Commerce de Alta Escala" required>
            </div>

            <div class="form-group">
                <label for="categoria">Categoría</label>
                <input type="text" id="categoria" name="categoria" placeholder="Ej: Fintech / Retail" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3" placeholder="Descripción breve..." required></textarea>
            </div>

            <div class="form-group">
                <label for="imagen">Seleccionar Imagen</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>

            <div class="form-group">
                <label for="orden">Orden</label>
                <input type="number" id="orden" name="orden" value="1" min="0" required>
            </div>

            <button type="submit" class="btn-submit">Guardar Proyecto</button>
        </form>
    </div>

    <div class="admin-card">
        <h2>Proyectos Registrados</h2>
        <table>
            <thead>
                <tr>
                    <th>Imagen</th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Orden</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($proyectos as $p): ?>
                    <tr>
                        <td>
                            <?php if (!empty($p['imagen_url'])): ?>
                                <img src="<?= htmlspecialchars($p['imagen_url']) ?>" class="img-preview" alt="Proyecto">
                            <?php else: ?>
                                <span style="color: #8e9bb0; font-size: 0.8rem;">Sin foto</span>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($p['titulo']) ?></td>
                        <td><?= htmlspecialchars($p['categoria']) ?></td>
                        <td><?= (int)$p['orden'] ?></td>
                        <td>
                            <a href="admin_proyectos.php?eliminar=<?= $p['id'] ?>" class="btn-delete" onclick="return confirm('¿Deseas eliminar este proyecto?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>