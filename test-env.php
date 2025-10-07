<?php
// Test environment variable loading
echo "<h2>Environment Variable Test</h2>";

// Load environment variables from .env file
if (file_exists(__DIR__ . '/.env')) {
    echo "<p>✅ .env file found</p>";
    $env_vars = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($env_vars as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
            putenv(trim($key) . '=' . trim($value));
            echo "<p>Loaded: " . htmlspecialchars(trim($key)) . " = " . htmlspecialchars(trim($value)) . "</p>";
        }
    }
} else {
    echo "<p>❌ .env file not found</p>";
}

echo "<h3>reCAPTCHA Variables:</h3>";
echo "<p>RECAPTCHA_SITE_KEY: " . htmlspecialchars($_ENV['RECAPTCHA_SITE_KEY'] ?? 'NOT SET') . "</p>";
echo "<p>RECAPTCHA_SECRET: " . htmlspecialchars($_ENV['RECAPTCHA_SECRET'] ?? 'NOT SET') . "</p>";

echo "<h3>Using getenv():</h3>";
echo "<p>RECAPTCHA_SITE_KEY: " . htmlspecialchars(getenv('RECAPTCHA_SITE_KEY') ?: 'NOT SET') . "</p>";
echo "<p>RECAPTCHA_SECRET: " . htmlspecialchars(getenv('RECAPTCHA_SECRET') ?: 'NOT SET') . "</p>";
