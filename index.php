<?php
$host = '20.151.178.117'; // IP pública de tu servidor MySQL
$db = 'alumnos';
$user = 'angel'; // Solo el nombre de usuario, sin @bdpass1
$pass = 'Amezquita12$';
$charset = 'utf8mb4';
$mensaje = "";

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "✅ Conexión exitosa";
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $matricula = $_POST["matricula"];
        $semestre = $_POST["semestre"];

        $stmt = $pdo->prepare("INSERT INTO estudiantes (nombre, apellido, matricula, semestre) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $apellido, $matricula, $semestre]);
        $mensaje = "✅ Registro guardado correctamente.";
    }

} catch (PDOException $e) {
    $mensaje = "❌ Error de conexión: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulario de Estudiantes</title>
</head>
<body>
    <h2>Registrar Estudiante</h2>

    <?php if ($mensaje): ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Apellido:</label><br>
        <input type="text" name="apellido" required><br><br>

        <label>Matrícula:</label><br>
        <input type="text" name="matricula" required><br><br>

        <label>Semestre:</label><br>
        <input type="number" name="semestre" required><br><br>

        <input type="submit" value="Guardar">
    </form>
</body>
</html>
