<?php
$host = 'bdpass1.mysql.database.azure.com';
$db = 'alumnos';
$user = 'angel@bdpass1';
$pass = 'Amezquita12$';
$charset = 'utf8mb4';
$ssl_ca = __DIR__ . '/BaltimoreCyberTrustRoot.crt.pem';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::MYSQL_ATTR_SSL_CA => $ssl_ca,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

$mensaje = "";

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nombre = $_POST["nombre"];
        $materia = $_POST["materia"];
        $calificacion = $_POST["calificacion"];

        $stmt = $pdo->prepare("INSERT INTO registros (nombre, materia, calificacion) VALUES (?, ?, ?)");
        $stmt->execute([$nombre, $materia, $calificacion]);
        $mensaje = "✅ Registro guardado correctamente.";
    }

} catch (PDOException $e) {
    $mensaje = "❌ Error de conexión: " . $e->getMessage();
}
?>
