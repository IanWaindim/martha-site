<?php
// contact.php — handles the contact form submission
 
// Only run on POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}
 
// Sanitize inputs — always clean user data before using it
$name    = htmlspecialchars(strip_tags(trim($_POST['name'] ?? '')));
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$message = htmlspecialchars(strip_tags(trim($_POST['message'] ?? '')));
 
// Validate — make sure nothing is empty and email is real
$errors = [];
 
if (empty($name))    $errors[] = 'Name is required.';
if (empty($message)) $errors[] = 'Message is required.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email address is required.';
}
 
if (!empty($errors)) {
    // In a real site you'd send these back nicely — for now just show them
    foreach ($errors as $error) {
        echo htmlspecialchars($error) . "<br>";
    }
    exit;
}
 
// Email settings — change this to Martha's real email
$to      = 'martha@waindim.com';
$subject = "New message from $name via your website";
$body    = "Name: $name\nEmail: $email\n\nMessage:\n$message";
$headers = "From: noreply@waindim.com\r\nReply-To: $email";
 
// Send the email
if (mail($to, $subject, $body, $headers)) {
    // Redirect back to homepage with success flag
    header('Location: index.html?sent=1');
} else {
    echo "Sorry, there was a problem sending your message. Please try again.";
}
exit;
?>