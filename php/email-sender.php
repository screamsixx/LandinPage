<?php

header('Content-Type: application/json'); // Ensure the response is JSON

// Function to sanitize and validate input data
function sanitize_input($data) {
    $data = trim($data); // Remove whitespace from the beginning and end
    $data = stripslashes($data); // Remove backslashes
    $data = htmlspecialchars($data); // Convert special characters to HTML entities
    return $data;
}

// 1. Receive and validate POST data
// IMPORTANT: The 'info' field in your original PHP should be 'message' here,
// as that's the ID of your textarea in the HTML.
$name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
$email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
$message = isset($_POST['message']) ? sanitize_input($_POST['message']) : ''; // CHANGED from $_GET['info'] to $_POST['message']

// Basic validations
if (empty($name) || empty($email) || empty($message)) {
    // HTTP 400 Bad Request response code
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'All fields (name, email, message) are required.']);
    exit; // Stop execution if data is missing
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // HTTP 400 Bad Request response code
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'The provided email format is invalid.']);
    exit; // Stop execution if the email is invalid
}

// 2. Configure email recipients
$to_user = $email; // To the email address provided by the user
$to_sales = 'ventas@pascalsolutionsti.com'; // Keeping original recipient email for sales
$to_valeria = 'valeria.guerrero@pascalsolutionsti.com'; // Keeping original recipient email for Valeria

// Combine all recipients. You can use BCC if you don't want them to see each other.
// $recipients = "$to_sales, $to_valeria"; // If you don't want the user to receive a direct copy in 'To'
// $headers .= "Bcc: $to_user\r\n"; // And here, for the user to receive a blind carbon copy

// To send to all in the 'To' field (as you had it)
$recipients = "$to_user, $to_sales, $to_valeria";

// Email subject
$subject = 'New Message from Contact Form'; // More specific subject

// Email body
$message_body = "Hello,\n\n";
$message_body .= "You have received a new message from the contact form with the following information:\n\n";
$message_body .= "Name: " . $name . "\n";
$message_body .= "Email: " . $email . "\n";
$message_body .= "Message: " . $message . "\n\n"; // Now it's 'Message'
$message_body .= "Thank you.";

// Email headers (important for proper email display and to avoid spam)
$headers = "From: ventas@pascalsolutionsti.com\r\n"; // IMPORTANT! Change 'yourdomain.com' to your actual domain
$headers .= "Reply-To: " . $email . "\r\n"; // So they can reply directly to the user
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/plain; charset=utf-8\r\n"; // For supporting special characters

// 3. Send the email
$mail_sent = mail($recipients, $subject, $message_body, $headers);

// 4. Return a JSON response
if ($mail_sent) {
    echo json_encode(['success' => true, 'message' => 'Your message has been sent.']); // Success message for the form
} else {
    // If the mail() function returns false, there might be a server configuration issue
    // or the email might have been internally flagged as spam.
    http_response_code(500); // HTTP 500 Internal Server Error response code
    echo json_encode(['success' => false, 'message' => 'Could not register contact. Please try again later.']); // Error message for the form
}

?>