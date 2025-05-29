<?php
// Configuración de la base de datos
$host = 'bdpass1.mysql.database.azure.com';
$db = 'alumnos';
$user = 'angel@bdpass1';
$pass = 'Amezquita12$';
$charset = 'utf8mb4';
$ssl_ca = __DIR__ . '/BaltimoreCyberTrustRoot.crt.pem'; // Ruta al certificado

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::MYSQL_ATTR_SSL_CA => $ssl_ca,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$mensaje = "";

try {
    // Crear conexión PDO
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Verifica si se envió el formulario
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $matricula = $_POST["matricula"];
        $semestre = $_POST["semestre"];

        // Inserta los datos
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
