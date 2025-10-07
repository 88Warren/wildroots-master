<?php

// Load environment variables from .env file for development
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

$firstname_error = $lastname_error = $email_error =  $phone_error = $subject_error = $event_error = $message_error = $recaptcha_error = " ";
$firstname = $lastname = $email = $phone = $subject = $message = $success = " ";
$event = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["firstname"])) {
        $firstname_error = "Enter your first name";
    } else {
        $firstname = test_input($_POST["firstname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $firstname)) {
            $firstname_error = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["lastname"])) {
        $lastname_error = "Enter your last name";
    } else {
        $lastname = test_input($_POST["lastname"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lastname)) {
            $lastname_error = "Only letters and white space allowed";
        }
    }

    if (empty($_POST["email"])) {
        $email_error = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Invalid email format";
        }
    }

    if (empty($_POST["phone"])) {
        $phone_error = "Phone number is required";
    } else {
        $phone = test_input($_POST["phone"]);
        // Simple phone number validation - just check basic format
        $clean_phone = preg_replace('/[^\d\+]/', '', $phone);

        // Very basic validation - just check it has digits and reasonable length
        if (strlen($clean_phone) < 10 || strlen($clean_phone) > 15) {
            $phone_error = "Phone number must be between 10-15 digits";
        }
        // If we get here and no error set, the phone number is valid
    }

    if (empty($_POST["subject"])) {
        $subject_error = "Subject is required";
    } else {
        $subject = test_input($_POST["subject"]);
    }

    if (empty($_POST["event"])) {
        $event_error = "Date is required";
    } else {
        $event = test_input($_POST["event"]);
    }

    if (empty($_POST["message"])) {
        $message_error = "A brief message is required";
    } else {
        $message = test_input($_POST["message"]);
    }

    // reCAPTCHA validation (temporarily relaxed for testing)
    if (empty($_POST['g-recaptcha-response'])) {
        $recaptcha_error = "Please complete the reCAPTCHA verification";
    } else {
        $recaptcha_secret = $_ENV['RECAPTCHA_SECRET'] ?? getenv('RECAPTCHA_SECRET');
        $recaptcha_response = $_POST['g-recaptcha-response'];

        // Use standard verification endpoint (works for both regular and Enterprise reCAPTCHA)
        $recaptcha_url = "https://www.google.com/recaptcha/api/siteverify";

        $recaptcha_data = array(
            'secret' => $recaptcha_secret,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        );

        $recaptcha_options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($recaptcha_data)
            )
        );

        $recaptcha_context = stream_context_create($recaptcha_options);
        $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
        $recaptcha_json = json_decode($recaptcha_result);

        if (!$recaptcha_json || !$recaptcha_json->success) {
            $recaptcha_error = "reCAPTCHA verification failed. Please try again.";


        } else {
            // reCAPTCHA v3 uses a score system (0.0 to 1.0)
            // Higher scores indicate more likely human interaction
            $score = $recaptcha_json->score ?? 0;
            $action = $recaptcha_json->action ?? '';

            // Set minimum score threshold (0.5 is recommended)
            $min_score = 0.5;

            if ($score < $min_score) {
                $recaptcha_error = "reCAPTCHA verification failed. Please try again.";


            }
        }
    }

    if ($firstname_error == ' ' and $lastname_error == ' ' and $email_error == ' ' and $phone_error == ' ' and $subject_error == ' ' and $event_error == ' ' and $message_error == ' ' and $recaptcha_error == ' ') {
        $message_body = ' ';
        unset($_POST['submit']);
        foreach ($_POST as $key => $value) {
            $message_body .= "$key: $value\n";
        }

        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: ' . $email . "\r\n";
        $headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
        $mailTo = "theteam@wildrootskitchenandbar.co.uk";
        $message = "You have received a new message. \r\n" .
            "Here are the details: \r\n" .
            'First Name: ' . $firstname . "\r\n " .
            'Last Name: ' . $lastname . "\r\n" .
            'Phone Number: ' . $phone . "\r\n" .
            'Event Date: ' . $event . "\r\n" .
            'Email: ' . $email . "\r\n" .
            'Message: ' . $message . "\r\n";
        $subject = "Website Enquiry: " . $subject;
        if (mail($mailTo, $subject, $message, $headers)) {
            $success = "Message sent, thank you for contacting us";
            $firstname = $lastname = $email = $phone = $subject = $message = " ";
            $event = "";
        }
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <?php include 'includes/head.php'; ?>
    <title>Contact Us - Wildroots Kitchen & Bar</title>
</head>

<body>
    <?php include 'includes/nav.php'; ?>

    <main id="main-content">

        <!-- Hero Section -->
        <section class="hero contact-hero" aria-label="Contact Wild Roots Kitchen & Bar">
            <div class="hero-content">
                <h1 class="hero-title">Contact Wild Roots</h1>
                <p class="hero-subtitle">Get in touch for sustainable catering services</p>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="contact-section">
            <div class="container">
                <div class="contact-content">
                    <!-- Contact Information -->
                    <div class="contact-info">
                        <div class="info-card">
                            <h2>Get in Touch</h2>
                            <div class="contact-details">
                                <div class="contact-item">
                                    <div class="email-with-icon">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
                                        </svg>
                                        <a href="mailto:theteam@wildrootskitchenandbar.co.uk">theteam@wildrootskitchenandbar.co.uk</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="newsletter-card">
                            <h2>Sign up to our newsletter</h2>
                            <p>Stay updated with our latest sustainable catering insights and special offers.</p>
                            <a href="https://eepurl.com/hpBXjj" target="_blank" rel="noopener noreferrer" class="cta-button">Subscribe Here</a>
                        </div> -->
                    </div>

                    <!-- Contact Form -->
                    <div class="contact-form-container">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="contact-form" novalidate>
                            <h2>Send us a message</h2>

                            <?php if ($success != ' '): ?>
                                <div class="form-message success" role="alert">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z" />
                                    </svg>
                                    <?php echo $success; ?>
                                </div>
                            <?php endif; ?>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="firstname">First Name <span class="required">*</span></label>
                                    <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required aria-describedby="firstname-error">
                                    <?php if ($firstname_error != ' '): ?>
                                        <span class="form-error" id="firstname-error" role="alert"><?php echo $firstname_error; ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="lastname">Last Name <span class="required">*</span></label>
                                    <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required aria-describedby="lastname-error">
                                    <?php if ($lastname_error != ' '): ?>
                                        <span class="form-error" id="lastname-error" role="alert"><?php echo $lastname_error; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="email">Email <span class="required">*</span></label>
                                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required aria-describedby="email-error">
                                    <?php if ($email_error != ' '): ?>
                                        <span class="form-error" id="email-error" role="alert"><?php echo $email_error; ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="phone">Phone Number <span class="required">*</span></label>
                                    <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required aria-describedby="phone-error" placeholder="e.g. 01234 567890 or 07123 456789">
                                    <?php if ($phone_error != ' '): ?>
                                        <span class="form-error" id="phone-error" role="alert"><?php echo $phone_error; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="subject">Subject <span class="required">*</span></label>
                                    <input type="text" id="subject" name="subject" value="<?php echo htmlspecialchars($subject); ?>" required aria-describedby="subject-error">
                                    <?php if ($subject_error != ' '): ?>
                                        <span class="form-error" id="subject-error" role="alert"><?php echo $subject_error; ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label for="event">Date of Event <span class="required">*</span></label>
                                    <input type="date" id="event" name="event" value="<?php echo htmlspecialchars($event); ?>" required aria-describedby="event-error">
                                    <?php if ($event_error != ' '): ?>
                                        <span class="form-error" id="event-error" role="alert"><?php echo $event_error; ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message">Message <span class="required">*</span></label>
                                <textarea id="message" name="message" rows="5" required aria-describedby="message-error" placeholder="Tell us about your event and catering requirements..."><?php echo htmlspecialchars($message); ?></textarea>
                                <?php if ($message_error != ' '): ?>
                                    <span class="form-error" id="message-error" role="alert"><?php echo $message_error; ?></span>
                                <?php endif; ?>
                            </div>

                            <!-- reCAPTCHA v3 (Invisible) -->
                            <?php if ($recaptcha_error != ' '): ?>
                                <div class="form-group">
                                    <span class="form-error" role="alert"><?php echo $recaptcha_error; ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Debug info for development -->
                            <?php if (($_SERVER['HTTP_HOST'] === 'localhost' || strpos($_SERVER['HTTP_HOST'], '127.0.0.1') !== false) && ($_ENV['RECAPTCHA_SITE_KEY'] ?? getenv('RECAPTCHA_SITE_KEY'))): ?>
                                <div class="form-group">
                                    <small style="color: #666; font-size: 0.8em;">
                                        🔒 Protected by reCAPTCHA v3 (invisible) - Site key: <?php echo substr($_ENV['RECAPTCHA_SITE_KEY'] ?? getenv('RECAPTCHA_SITE_KEY'), 0, 20) . '...'; ?>
                                    </small>
                                </div>
                            <?php endif; ?>

                            <button type="submit" name="submit" class="cta-button submit-button">
                                <span>Send Message</span>
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                                </svg>
                            </button>

                            <p class="form-note">
                                <span class="required">*</span> Required fields<br>
                                By submitting this form, you agree to our <a href="docs/footer/wildroots-kitchen-website-policies.pdf" target="_blank" rel="noopener noreferrer">Privacy Policy</a>.
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why Choose Us Section -->
        <section class="why-choose-us">
            <div class="container">
                <h2 class="section-title">Why Choose Wild Roots?</h2>
                <div class="features-grid">
                    <div class="feature-card">
                        <div class="contact-feature-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                            </svg>
                        </div>
                        <h3>Sustainable Practices</h3>
                        <p>Locally sourced ingredients, compostable packaging, and carbon footprint reduction in everything we do.</p>
                    </div>

                    <div class="feature-card">
                        <div class="contact-feature-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.82,11.69,4.82,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z"/>
                            </svg>
                        </div>
                        <h3>Flexible Service</h3>
                        <p>From intimate gatherings to large corporate events, we tailor our service to your specific needs.</p>
                    </div>

                    <div class="feature-card">
                        <div class="contact-feature-icon">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                            </svg>
                        </div>
                        <h3>Quality Guaranteed</h3>
                        <p>Award-winning service with uncompromising quality and attention to detail in every dish.</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <?php include 'includes/footer.php'; ?>
</body>

</html>