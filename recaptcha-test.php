<?php
// Load environment variables
if (file_exists(__DIR__ . '/.env')) {
    $env_vars = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($env_vars as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[trim($key)] = trim($value);
            putenv(trim($key) . '=' . trim($value));
        }
    }
}

$site_key = $_ENV['RECAPTCHA_SITE_KEY'] ?? getenv('RECAPTCHA_SITE_KEY');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reCAPTCHA Test</title>
    <!-- Test both v2 and v3 -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $site_key; ?>" async defer></script>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .test-container { max-width: 500px; margin: 0 auto; }
        .debug-info { background: #f5f5f5; padding: 10px; margin: 10px 0; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>reCAPTCHA Test Page</h1>
        
        <div class="debug-info">
            <h3>Debug Information:</h3>
            <p><strong>Site Key:</strong> <?php echo $site_key ? htmlspecialchars($site_key) : 'NOT FOUND'; ?></p>
            <p><strong>Key Length:</strong> <?php echo $site_key ? strlen($site_key) : 'N/A'; ?></p>
            <p><strong>Key Preview:</strong> <?php echo $site_key ? substr($site_key, 0, 20) . '...' : 'N/A'; ?></p>
        </div>

        <?php if ($site_key): ?>
            <h3>Test reCAPTCHA v2 (Checkbox):</h3>
            <form method="post" id="v2-form">
                <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($site_key); ?>"></div>
                <br>
                <button type="submit">Test v2 Submit</button>
            </form>
            
            <hr style="margin: 20px 0;">
            
            <h3>Test reCAPTCHA v3 (Invisible):</h3>
            <form method="post" id="v3-form">
                <button type="button" onclick="testV3()">Test v3 Submit</button>
                <div id="v3-result" style="margin-top: 10px;"></div>
            </form>
            
            <?php if ($_POST): ?>
                <div class="debug-info">
                    <h3>Form Submission Result:</h3>
                    <p><strong>reCAPTCHA Response:</strong> <?php echo isset($_POST['g-recaptcha-response']) ? 'Received' : 'Missing'; ?></p>
                    <?php if (isset($_POST['g-recaptcha-response'])): ?>
                        <p><strong>Response Length:</strong> <?php echo strlen($_POST['g-recaptcha-response']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div style="color: red;">
                <h3>Error: No reCAPTCHA site key found!</h3>
                <p>Check your .env file and make sure RECAPTCHA_SITE_KEY is set.</p>
            </div>
        <?php endif; ?>

        <div class="debug-info">
            <h3>Browser Console:</h3>
            <p>Check the browser console for any JavaScript errors.</p>
            <p>Common issues:</p>
            <ul>
                <li>Invalid site key</li>
                <li>Domain not authorized</li>
                <li>Wrong reCAPTCHA version</li>
                <li>Network connectivity issues</li>
            </ul>
        </div>
    </div>

    <script>
        console.log('reCAPTCHA Test Page Loaded');
        console.log('Site Key:', '<?php echo $site_key; ?>');
        
        // Log when reCAPTCHA is ready
        window.addEventListener('load', function() {
            setTimeout(function() {
                if (typeof grecaptcha !== 'undefined') {
                    console.log('✅ reCAPTCHA API loaded successfully');
                } else {
                    console.error('❌ reCAPTCHA API failed to load');
                }
            }, 2000);
        });
        
        // Callback functions
        function onRecaptchaSuccess(token) {
            console.log('✅ reCAPTCHA completed successfully');
            console.log('Token length:', token.length);
        }
        
        function onRecaptchaExpired() {
            console.log('⚠️ reCAPTCHA expired');
        }
        
        function onRecaptchaError() {
            console.log('❌ reCAPTCHA error occurred');
        }
        
        // Test reCAPTCHA v3
        function testV3() {
            const siteKey = '<?php echo $site_key; ?>';
            const resultDiv = document.getElementById('v3-result');
            
            resultDiv.innerHTML = 'Testing reCAPTCHA v3...';
            
            if (typeof grecaptcha !== 'undefined' && grecaptcha.execute) {
                grecaptcha.ready(function() {
                    grecaptcha.execute(siteKey, {action: 'submit'}).then(function(token) {
                        resultDiv.innerHTML = '✅ reCAPTCHA v3 Success! Token length: ' + token.length;
                        console.log('v3 token:', token);
                    }).catch(function(error) {
                        resultDiv.innerHTML = '❌ reCAPTCHA v3 Error: ' + error;
                        console.error('v3 error:', error);
                    });
                });
            } else {
                resultDiv.innerHTML = '❌ reCAPTCHA v3 API not available';
            }
        }
    </script>
</body>
</html>