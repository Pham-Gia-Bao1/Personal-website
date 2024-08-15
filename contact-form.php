<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to sanitize inputs
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['emailHelp'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $comments = $_POST['comments'] ?? '';

    // Process the data (e.g., send email, save to database)
} else {
    echo "Invalid request.";
}

// Retrieve and sanitize input data
$name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
$emailHelp = isset($_POST['emailHelp']) ? sanitize_input($_POST['emailHelp']) : '';
$phone = isset($_POST['phone']) ? sanitize_input($_POST['phone']) : '';
$subject = isset($_POST['subject']) ? sanitize_input($_POST['subject']) : '';
$comments = isset($_POST['comments']) ? sanitize_input($_POST['comments']) : '';

// Debug output
echo "<h3>Debug Information</h3>";
echo "<p><strong>Name:</strong> $name</p>";
echo "<p><strong>Email:</strong> $emailHelp</p>";
echo "<p><strong>Phone:</strong> $phone</p>";
echo "<p><strong>Subject:</strong> $subject</p>";
echo "<p><strong>Comments:</strong> $comments</p>";

if (!empty($name) && !empty($phone) && !empty($emailHelp)) {
    $to_email = "phamgiabao123abc@gmail.com";
    $email_subject = "Inquiry From Contact Page";
    $vpb_message_body = nl2br("Dear Admin,\n
    The user whose details are shown below has sent this message from ".$_SERVER['HTTP_HOST']." dated ".date('d-m-Y').".\n

    Name: ".$name."\n
    Phone: ".$phone."\n
    Email Address: ".$emailHelp."\n
    Subject: ".$subject."\n
    Message: ".$comments."\n
    User IP: ".getHostByName(getHostName())."\n
    Thank You!\n\n");

    // Set up the email headers
    $headers = "From: $name <$emailHelp>\r\n";
    $headers .= "Reply-To: $emailHelp\r\n";
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $headers .= "Message-ID: <".time().rand(1,1000)."@".$_SERVER['SERVER_NAME'].">\r\n";

    // Debug email headers and body
    echo "<h3>Email Debug Information</h3>";
    echo "<p><strong>To Email:</strong> $to_email</p>";
    echo "<p><strong>Email Subject:</strong> $email_subject</p>";
    echo "<p><strong>Email Headers:</strong> $headers</p>";
    echo "<p><strong>Email Body:</strong><br>$vpb_message_body</p>";

    // Send email
    if (mail($to_email, $email_subject, $vpb_message_body, $headers)) {
        $status = 'Success';
        $output = "Congrats ".$name.", your email message has been sent successfully! We will get back to you as soon as possible. Thanks.";
    } else {
        $status = 'error';
        $output = "Sorry, your email could not be sent at the moment. Please try again or contact this website admin to report this error message if the problem persists. Thanks.";
    }
} else {
    $status = 'error';
    $output = "Please fill in the required fields.";
}

// Return JSON response
echo "<h3>Response</h3>";
echo json_encode(array('status'=> $status, 'msg'=>$output));
?>

<h1>Hello</h1>