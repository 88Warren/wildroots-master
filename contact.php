<?php 

$firstname_error = $lastname_error = $email_error =  $phone_error = $subject_error = $event_error = $message_error = " ";
$firstname = $lastname = $email = $phone = $subject = $event = $message = $success = " ";
// if (isset($_POST['submit'])) {
//     $firstname = $_POST["firstname"];
//     $lastname = $_POST["lastname"];
//     $email = $_POST["email"];
//     $phone = $_POST["phone"];
//     $subject = $_POST["subject"];
//     $event = $_POST["event"];
//     $message = $_POST["message"];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST["firstname"])){
        $firstname_error = "Enter your first name";
    } else {
        $firstname = test_input ($_POST["firstname"]);
        if(!preg_match ("/^[a-zA-Z-' ]*$/", $firstname)){
            $firstname_error = "Only letters and white space allowed";
        }
    }
    
    if(empty($_POST["lastname"])){
        $lastname_error = "Enter your last name";
    } else {
        $lastname = test_input ($_POST["lastname"]);
        if(!preg_match ("/^[a-zA-Z-' ]*$/", $lastname)){
            $lastname_error = "Only letters and white space allowed";
    }
    }

   if(empty($_POST["email"])){
        $email_error = "Email is required";
    } else {
        $email = test_input ($_POST["email"]);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $email_error = "Invalid email format";
    }
    }

    if(empty($_POST["phone"])){
        $phone_error = "Phone number is required";
    } else{
        $phone = test_input($_POST["phone"]);
    }

    if(empty($_POST["subject"])){
        $subject_error = "Subject is required";
    } else {
        $subject = test_input($_POST ["subject"]);
    }
    
      
    if(empty($_POST["event"])){
        $event_error = "Date is required";
    } else {
        $event = test_input($_POST ["event"]);
    }
    

    if(empty($_POST["message"])){
        $message_error = "A brief message is required";
    } else {
        $message = test_input($_POST["message"]);
    }

    if ($firstname_error == ' ' and $lastname_error == ' ' and $email_error == ' ' and $phone_error == ' ' and $subject_error == ' ' and $event_error == ' ' and $message_error == ' '){
        $message_body = ' ';
            unset($_POST['submit']);
            foreach ($_POST as $key => $value){
                $message_body .= "$key: $value\n";
            }

            
            $headers =  'MIME-Version: 1.0' . "\r\n"; 
            $headers .= 'From: ' . $email . "\r\n";
            $headers .= 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
            $mailTo = "theteam@wildrootskitchenandbar.co.uk";
            $message = "You have received a new message. \r\n" .
            "Here are the details: \r\n".
            'First Name: ' .$firstname. "\r\n ".
            'Last Name: '.$lastname. "\r\n".
            'Phone Number: '.$phone. "\r\n".
            'Event Date: '.$event. "\r\n".
            'Email: '.$email. "\r\n".
            'Message: '.$message. "\r\n";
            $subject = "Website Enquiry: " . $subject;
            if (mail($mailTo,$subject,$message,$headers)){
                $success = "Message sent, thank you for contacting us";
                $firstname = $lastname = $email = $phone = $subject = $event = $message = " ";
            }
    }
}

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data; 
    }

//     else{
//         $message = wordwrap($message, 500) . "\r\n" . 'Event Date: ' .$event. "\r\n". 'First Name: '.$firstname. "\r\n". 'Last Name: '. $lastname. "\r\n". 'Phone Number: '.$phone. "\r\n". $event. "\r\n";
//         $headers =  'MIME-Version: 1.0' . "\r\n"; 
//         $headers .= 'From: ' . $email . "\r\n";
//         $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//         $subject = "Website Enquiry: " . $subject;
//         $mailTo = "theteam@wildrootskitchenandbar.co.uk";
//         $result = mail($mailTo,$subject,$message,$headers);
//         echo("Message sent to".$mailTo);
//     }
// }
?>



<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="creative bespoke sustainable fresh local business" />
        <meta name="keywords" content="wedding, venue, caterer, welsh, in-house" />
        <meta http-equiv="author" content="LMW" />
        <link rel="stylesheet" href="/stylesheets/nav.css" />
        <link rel="stylesheet" href="/stylesheets/main.css"/>
        <link rel="stylesheet" href="/stylesheets/blog.css"/>
        <link rel="stylesheet" href="/stylesheets/footer.css"/>
        <title>Wildroots Kitchen & Bar</title>
    </head>
        <body>
            <nav class="top transparent" id="navbarPrime">
                <a href="/"><img src="Images/nav/main logo.jpg" alt="Logo Wild Roots" width="120" height="50" /></a>
                    <div class="menu">
                        <button aria-expanded="false" aria-controls="menu-list">
                            <span class="open">☰</span>
                            <span class="close">×</span>
                        </button>
                        <ul class="menu-list">
                            <li><a href="/#whatWeDo">What we do</a></li>
                            <li><a href="/sustainability">Sustainability</a></li>
                            <li><a href="/blog">Blog</a></li>
                            <li><a href="/contact">Get in Touch</a></li>
                        </ul>
                    </div>
                        <div class="social">
                            <a href="https://www.instagram.com/wildrootskitchenandbar/?hl=en"  target="_blank"><img class="instagram" src="Images/nav/instagram.png" width="25"></a> 
                            <a href="https://www.facebook.com/pages/category/Caterer/Wild-Roots-Kitchen-and-Bar-100997658454964/"  target="_blank"><img class="facebook" src="Images/nav/facebook.png" width="21"></a> 
                            <a href="https://www.linkedin.com/company/wild-roots-kitchen-and-bar-ltd"  target="_blank"><img class="linkedin" src="Images/nav/linkedin.png" width="25"></a>
                            <a href="https://twitter.com/WildRoots_KB"  target="_blank"><img class="twitter" src="Images/nav/twitter.png" width="25"></a>
                        </div>
                    </nav>

    <div class="heroC">
        <div class="heroImageC"><h1>Contact Wild Roots</h1></div>
    </div>

    <div class="getInTouch">
            <div class="companyInfo">
                <h1 class="heading">Get in touch </h1>
                <ul>
                    <li><span>Email</span> theteam@wildrootskitchenandbar.co.uk</li>
                </ul>
                <h1 class="heading">Sign up to our newsletter</h1>
                <form action="https://eepurl.com/hpBXjj" target="_blank">
                    <center><button class="bulletBtn newsletter">Click here</button></center>
                </form>
                
            </div>
            <div class="contact">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form">
                    <div class="success"><?php echo $success; ?></div>
                    <p>
                        <label for="fname">First name</label>
                        <input type="text" id="fname" name="firstname" value="<?php echo $firstname; ?>">
                        <br>
                        <span class="error"><?php echo $firstname_error;?></span>
                    </p>
                    <p>
                        <label for="lname">Last name</label>
                        <input type="text" id="lname" name="lastname" value="<?php echo $lastname; ?>">
                        <br>
                        <span class="error"><?php echo $lastname_error;?></span>
                    </p>
                    <p>
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $email;?>">
                        <br>
                        <span class="error"><?php echo $email_error;?></span>
                    </p>
                    <p>
                        <label for="phone">Phone number</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" >
                        <!-- pattern="[0-9]{11}"  -->
                        <br>
                        <span class="error"><?php echo $phone_error;?></span>
                    </p>
                    <p>
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" value="<?php echo $subject; ?>">
                        <br>
                        <span class="error"><?php echo $subject_error;?></span>
                    </p>
                    <p>
                        <label for="event">Date of Event</label>
                        <input type="date" id="event" name="event" value="<?php echo $event;?>">
                        <br>
                        <span class="error"><?php echo $event_error;?></span>
                   </p>
                    <p>
                        <label for="message">Message</label>
                        <textarea type="text"  id="message" name="message" value="<?php echo $message; ?>"></textarea>
                        <br>
                        <span class="error"><?php echo $message_error;?></span>
                    </p>
                    <p>
                        <button type="submit" value="send" name="submit">Submit</button>
                    </p>
                </form>
            </div>
        </div>

        <div id="footer4">
            <div id="mark">
                <a href="/"><img src="Images/nav/main logo.jpg" alt="Logo Wild Roots" width="120" height="50" /></a> 
            </div>
            <div id="media">
                <a href="https://www.instagram.com/wildrootskitchenandbar/?hl=en"  target="_blank"><img id="instafoot" src="Images/nav/instagram.png" width="25"></a> 
                <a href="https://www.facebook.com/pages/category/Caterer/Wild-Roots-Kitchen-and-Bar-100997658454964/"  target="_blank"><img id="facefoot" src="images/nav/facebook.png" width="21"></a>
                <a href="https://www.linkedin.com/company/wild-roots-kitchen-and-bar-ltd"  target="_blank"><img id="linkedin" src="Images/nav/linkedin.png" width="25"></a>
                <a href="https://twitter.com/WildRoots_KB"  target="_blank"><img id="twitter" src="Images/nav/twitter.png" width="25"></a>
            </div>
            <div id="docs">
                <a href="docs/footer/EnvironmentalPolicies.pdf"  target="_blank">Environmental Policies</a>|<a href="docs/footer/Website Policies.pdf" target="_blank">Website Policies</a>|<a href="docs/footer/missionStatement.pdf" target="_blank">Mission Statement</a>
            </div>
            <div id="weddingLinks"> 
                <a href="https://www.ukbridaldirectory.co.uk/" target="_blank">UK Bridal Directory</a>|<a href="https://www.findaweddingsupplier.co.uk/" target="_blank">Find A Wedding Supplier</a>|<a href="https://www.thesustainableweddingmovement.co.uk/" target="_blank">The Sustainable Wedding Movement</a>
            </div>
            <div id="copy">
                <p>© Copyright 2022 Wild Roots Kitchen and Bar Ltd.</p>
            </div>
            <div id="info">
                <p>Registered in England & Wales | Company no. 12808915 | Registered Address: Bridgend</p>
            </div>
        </div>
        <script src="/javascript/wildroots.js" ></script>
    </body>
</html>