<?php
// Configuración de Firebase
define('API_KEY', 'AIzaSyBiGQvtCuowFFzQJEoSNdc94oRBL8_8k4A');
define('DATABASE_URL', 'https://esp32-dth22-default-rtdb.firebaseio.com/');
define('USER_EMAIL', 'jaderfortine@gmail.com');
define('USER_PASSWORD', 'Jaderyjader4');

// Función para obtener el token de autenticación
function getFirebaseToken($email, $password, $apiKey) {
    $url = 'https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=' . $apiKey;
    $data = json_encode([
        'email' => $email,
        'password' => $password,
        'returnSecureToken' => true
    ]);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);
    return $responseData['idToken'] ?? null;
}

// Función para obtener datos de Firebase
function getFirebaseData($path, $token) {
    $url = DATABASE_URL . $path . '.json?auth=' . $token;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Obtener el token de autenticación
$token = getFirebaseToken(USER_EMAIL, USER_PASSWORD, API_KEY);

if ($token) {
    // Obtener datos de temperatura y humedad
    $temperature = getFirebaseData('sensor/temperature', $token);
    $humidity = getFirebaseData('sensor/humidity', $token);
} else {
    echo 'Error al obtener el token de autenticación.';
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos del Sensor DHT11</title>
</head>
<body>
    <h1>Datos del Sensor DHT11</h1>
    <p>Temperatura: <?php echo htmlspecialchars($temperature); ?> °C</p>
    <p>Humedad: <?php echo htmlspecialchars($humidity); ?> %</p>
</body>
</html>
