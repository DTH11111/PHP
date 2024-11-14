<?php
// URL de tu base de datos Firebase
$url = 'https://esp32-dth22-default-rtdb.firebaseio.com';

// Inicializa cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);

// Ejecuta cURL y obtén la respuesta
$response = curl_exec($ch);
curl_close($ch);

// Decodifica la respuesta JSON
$data = json_decode($response, true);

// Obtén los valores de temperatura y humedad
$temperature = isset($data['temperature']) ? $data['temperature'] : 'No disponible';
$humidity = isset($data['humidity']) ? $data['humidity'] : 'No disponible';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos de Temperatura y Humedad</title>
</head>
<body>
    <h1>Datos de Temperatura y Humedad</h1>
    <p>Temperatura: <?php echo htmlspecialchars($temperature); ?> °C</p>
    <p>Humedad: <?php echo htmlspecialchars($humidity); ?> %</p>
</body>
</html>
