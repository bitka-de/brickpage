<?php
// Simuliere ein Login über POST
$postData = [
    'email' => 'admin@admin.de',
    'password' => 'Admin123!'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/login');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h1>Login Test</h1>";
echo "<p>HTTP Code: $httpCode</p>";

// Jetzt Settings-Seite abrufen
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/settings');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_COOKIEFILE, '/tmp/cookies.txt');

$settingsResponse = curl_exec($ch);
$settingsHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h2>Settings Page Test</h2>";
echo "<p>HTTP Code: $settingsHttpCode</p>";
if ($settingsHttpCode === 200) {
    echo "<div style='max-height: 300px; overflow: auto; border: 1px solid #ccc; padding: 10px;'>";
    echo htmlspecialchars(substr($settingsResponse, 0, 2000));
    echo "</div>";
} else {
    echo "<p>Error loading settings page</p>";
}