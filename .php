<?php 
if (isset($_POST['submit'])) {
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    if(empty($firstname)){
        echo("Enter your name");
        exit();
    }
    else if(empty($lastname)){
        echo("Enter your name");
        exit();
    }
    else if(empty($email)){
        echo("Enter your email");
        exit();
    }
    else if(empty($phone)){
        echo("Enter your phone number");
        exit();
    }
    else if(empty($subject)){
        echo("Enter a subject");
        exit();
    }
    else if(empty($message)){
        echo("Enter your message");
        exit();
    }
    else{
        $message = wordwrap($message, 500) . $firstname .  $lastname . $phone;
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: ' . $email . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $subject = "Website Enquiry: " . $subject;
        $mailTo = "theteam@wildrootskitchenandbar.co.uk";
        $result = mail($mailTo,$subject,$message,$headers);
        echo("Message sent to".$mailTo);
    }
}
?>

<html   lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta name="description" content="creative bespoke sustainable fresh local business" />
        <meta name="keywords" content="wedding, venue, caterer, welsh, in-house" />
        <meta http-equiv="author" content="LMW" />
            <link href="main.css" rel="stylesheet" type="text/css" />
            <title>Get in touch | Wild Roots</title>
    </head>
<body>
    <div class="top" >
        <div class="logo"><a href="/"><img src="C:/xampp/htdocs/wildroots/images/Logo/main-logo.jpg" alt="Logo Wild Roots" width="120" height="50" /></a></div>
            <nav class="menu">
                <button aria-expanded="false" aria-controls="menu-list">
                    <span class="open">☰</span>
                    <span class="close">×</span>
                </button>
                <ul class="menu-list">
                <li><a href="/">Home</a></li>
                <li><a href="/#whatWeDo">What we do</a></li>
                <li><a href="sustainability.html">Sustainability</a></li>
                <li><a href="story.html"></a></li>
                </ul>
            </nav>
            <div class="social">
                <a href="https://www.instagram.com/wildrootskitchenandbar/?hl=en"  target="_blank"><img class="instagram" src="images/Logo/instagram.png" width="25"></a> 
                <a href="https://www.facebook.com/pages/category/Caterer/Wild-Roots-Kitchen-and-Bar-100997658454964/"  target="_blank"><img class="facebook" src="images/Logo/facebook.png" width="21"></a> 
                <a href="https://www.linkedin.com/company/wild-roots-kitchen-and-bar-ltd"  target="_blank"><img class="linkedin" src="images/Logo/linkedin.png" width="25"></a>
                <a href="https://twitter.com/WildRoots_KB"  target="_blank"><img class="twitter" src="images/Logo/twitter.png" width="25"></a>
            </div>
    </div>

    <div class="heroC">
        <div class="heroImageC"><h1>Contact Wild Roots</h1></div>
    </div>

    <div class="container">
            <div class="companyInfo">
                <h1 class="heading">Get in touch </h1>
                <ul>
                    <li><span>Call</span> 0330 128 1591</li>
                    <li><span>Email</span> theteam@wildrootskitchenandbar.co.uk</li>
                </ul>
            </div>
            <div class="contact">
                <form action="contact.php" method="post" class="form">
                    <p>
                        <label for="fname">First name</label>
                        <input type="text" id="fname" name="firstname">
                    </p>
                    <p>
                        <label for="lname">Last name</label>
                        <input type="text" id="lname" name="lastname">
                    </p>
                    <p>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email">
                    </p>
                    <p>
                        <label for="phone">Phone number</label>
                        <input type="tel" name="phone" id="phone" pattern="[0-9]{11}">
                    </p>
                    <p>
                        <label for="subject">Subject</label>
                        <input type="text" name="subject" id="subject">
                    </p>
                    <p>
                        <label for="event">Date of Event</label>
                        <input type="date" name="event" id="event">
                    </p>
                    <p>
                        <label for="message">Message</label>
                        <textarea type="text" name="message" id="message"></textarea>
                    </p>
                    <p>
                        <button type="submit" value="send" name="submit">Submit</button>
                    </p>
                </form>
            </div>
        </div>

        <div class="footer4">
            <div class="mark">
                <a href="/"><img src="C:/xampp/htdocs/wildroots/images/Logo/main-logo.jpg" alt="Logo Wild Roots" width="120" height="50" /></a> 
            </div>
            <div class="media">
                <a href="https://www.instagram.com/wildrootskitchenandbar/?hl=en"  target="_blank"><img class="instafoot" src="images/Logo/instagram.png" width="25"></a> 
                <a href="https://www.facebook.com/pages/category/Caterer/Wild-Roots-Kitchen-and-Bar-100997658454964/"  target="_blank"><img class="facefoot" src="images/Logo/facebook.png" width="21"></a>
                <a href="https://www.linkedin.com/company/wild-roots-kitchen-and-bar-ltd"  target="_blank"><img class="linkedin" src="images/Logo/linkedin.png" width="25"></a>
                <a href="https://twitter.com/WildRoots_KB"  target="_blank"><img class="twitter" src="images/Logo/twitter.png" width="25"></a>
            </div>
            <div class="docs">
                <a href="docs/environmental-policies.pdf"  target="_blank">Environmental Policies |</a>
                <a href="docs/website-policies.pdf"  target="_blank">Website Policies |</a>
                <a href="docs/Wild Roots Kitchen & Bar Vision Mission Statement and Core Values.pdf"  target="_blank">Mission Statement</a>
            </div>
            <div class="copy">
                <p>© Copyright 2020 Wild Roots Kitchen and Bar Ltd.</p>
            </div>
            <div class="info">
                <p>Registered in England & Wales | Company no. 12808915 | Registered Address: Bridgend</p>
            </div>
        </div>
            <script src="wildroots.js" ></script>
</body>
</head>
</html>