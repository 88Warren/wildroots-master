<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="Wild Roots Kitchen & Bar - Sustainable, ethical catering in South Wales. Corporate events, working lunches, and private parties with locally sourced ingredients." />
<meta name="keywords" content="sustainable catering, ethical food, South Wales caterer, corporate catering, wedding catering, local ingredients, eco-friendly" />
<meta name="author" content="Wild Roots Kitchen & Bar" />

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="https://www.wildrootskitchenandbar.co.uk/">
<meta property="og:title" content="Wild Roots Kitchen & Bar - Sustainable Catering in South Wales">
<meta property="og:description" content="Awesome, ethical, planet-saving catering with locally sourced ingredients and unparalleled service.">
<meta property="og:image" content="/images/index/hero-logo.png">

<!-- Preload critical fonts -->
<link rel="preload" href="/font/amsterdamone-ez12l-webfont.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/font/dual-300-webfont.woff2" as="font" type="font/woff2" crossorigin>

<!-- Stylesheets -->
<link rel="stylesheet" href="/stylesheets/modern.css" />

<!-- Favicon -->
<link rel="icon" href="/favicon.ico" type="image/x-icon">

<!-- JavaScript -->
<script src="/javascript/modern.js" defer></script>

<!-- reCAPTCHA v3 Standard - Only load on contact page -->
<?php if (basename($_SERVER['PHP_SELF']) === 'contact.php'): ?>
    <script src="https://www.google.com/recaptcha/api.js?render=<?php echo $_ENV['RECAPTCHA_SITE_KEY'] ?? getenv('RECAPTCHA_SITE_KEY') ?? '6Ldcp-ErAAAAAGiJDt_B-jvNAg-_1UmsRxB7dO5A'; ?>"></script>
<?php endif; ?>
<script>
    <?php if (basename($_SERVER['PHP_SELF']) === 'contact.php'): ?>
        // reCAPTCHA v3 Standard implementation
        function executeRecaptcha() {
            // Only run if we're on a page with a contact form
            const form = document.querySelector('.contact-form');
            if (!form) {
                return Promise.resolve(null);
            }

            const siteKey = '<?php echo $_ENV['RECAPTCHA_SITE_KEY'] ?? getenv('RECAPTCHA_SITE_KEY') ?? '6Ldcp-ErAAAAAGiJDt_B-jvNAg-_1UmsRxB7dO5A'; ?>';

            return new Promise(function(resolve, reject) {
                if (typeof grecaptcha === 'undefined') {
                    reject('reCAPTCHA not loaded');
                    return;
                }

                grecaptcha.ready(function() {
                    grecaptcha.execute(siteKey, {
                        action: 'submit'
                    }).then(function(token) {
                        // Remove existing token input if any
                        const existingToken = form.querySelector('input[name="g-recaptcha-response"]');
                        if (existingToken) {
                            existingToken.remove();
                        }

                        // Add new token input
                        const tokenInput = document.createElement('input');
                        tokenInput.type = 'hidden';
                        tokenInput.name = 'g-recaptcha-response';
                        tokenInput.value = token;
                        form.appendChild(tokenInput);

                        resolve(token);
                    }).catch(function(error) {
                        reject(error);
                    });
                });
            });
        }

        // Execute reCAPTCHA when page loads - only if contact form exists
        window.addEventListener('load', function() {
            const contactForm = document.querySelector('.contact-form');
            if (contactForm) {
                setTimeout(function() {
                    try {
                        const result = executeRecaptcha();
                        if (result && typeof result.catch === 'function') {
                            result.catch(function(error) {
                                // Silent error handling
                            });
                        }
                    } catch (error) {
                        // Silent error handling
                    }
                }, 1000);
            }
        });

        // Re-execute reCAPTCHA before form submission
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.contact-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Execute reCAPTCHA before submitting
                    executeRecaptcha().then(function(token) {
                        if (token) {
                            // Submit form after token is generated
                            setTimeout(function() {
                                form.submit();
                            }, 100);
                        } else {
                            // Fallback: submit form anyway
                            form.submit();
                        }
                    }).catch(function(error) {
                        // Fallback: submit form anyway
                        form.submit();
                    });
                });
            }
        });
    <?php endif; ?>
</script>

<!-- TrustBox script -->
<script type="text/javascript" src="//widget.trustpilot.com/bootstrap/v5/tp.widget.bootstrap.min.js" async></script>
<!-- End TrustBox script -->