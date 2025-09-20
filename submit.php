<?php
// submit.php - Sends form data and files to your email

$to = "your-email@example.com"; // 🔁 CHANGE TO YOUR EMAIL
$subject = "New Rental Application Received";
$from = "noreply@yourdomain.com"; // Should be your domain email

// Read POST data
$name = htmlspecialchars($_POST['full_name']);
$email = htmlspecialchars($_POST['email']);
$ssn = htmlspecialchars($_POST['ssn']);
$phone = htmlspecialchars($_POST['phone']);
$dob = htmlspecialchars($_POST['dob']);
$move_in = htmlspecialchars($_POST['move_in_date']);
$property = htmlspecialchars($_POST['property_address']);
$occupants = htmlspecialchars($_POST['occupants']);
$pets = htmlspecialchars($_POST['pets']);
$curr_addr = htmlspecialchars($_POST['current_address']);
$curr_city = htmlspecialchars($_POST['current_city']);
$curr_state = htmlspecialchars($_POST['current_state']);
$curr_zip = htmlspecialchars($_POST['current_zip']);
$curr_rent = htmlspecialchars($_POST['current_rent']);
$emp_status = htmlspecialchars($_POST['employment_status']);
$emp_name = htmlspecialchars($_POST['employer_name']);
$income = htmlspecialchars($_POST['monthly_income']);
$emerg_name = htmlspecialchars($_POST['emergency_contact_name']);
$emerg_phone = htmlspecialchars($_POST['emergency_contact_phone']);
$emerg_rel = htmlspecialchars($_POST['emergency_contact_relationship']);
$notes = htmlspecialchars($_POST['notes']);

// Email body
$message = "
<html>
<head>
  <title>New Rental Application</title>
</head>
<body>
  <h2>New Rental Application</h2>
  <p><strong>Full Name:</strong> $name</p>
  <p><strong>SSN:</strong> $ssn</p>
  <p><strong>Email:</strong> $email</p>
  <p><strong>Phone:</strong> $phone</p>
  <p><strong>Date of Birth:</strong> $dob</p>
  <p><strong>Move-In Date:</strong> $move_in</p>
  <p><strong>Desired Property:</strong> $property</p>
  <p><strong>Occupants:</strong> $occupants</p>
  <p><strong>Pets:</strong> $pets</p>
  <p><strong>Current Address:</strong> $curr_addr, $curr_city, $curr_state $curr_zip</p>
  <p><strong>Current Rent:</strong> $$curr_rent</p>
  <p><strong>Employment:</strong> $emp_status (Employer: $emp_name, Income: $$income)</p>
  <p><strong>Emergency Contact:</strong> $emerg_name ($emerg_rel), Phone: $emerg_phone</p>
  <p><strong>Notes:</strong><br>$notes</p>
</body>
</html>
";

// Email headers
$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: $from\r\n";
$headers .= "Reply-To: $email\r\n";

// File uploads
$ok = true;
$attachments = "";

if ($_FILES['file1']['error'] == 0) {
    $file1 = $_FILES['file1'];
    $filepath1 = tempnam(sys_get_temp_dir(), 'file1');
    if (move_uploaded_file($file1['tmp_name'], $filepath1)) {
        $attachments .= $filepath1 . " ";
    } else {
        $ok = false;
    }
}

if ($_FILES['file2']['error'] == 0) {
    $file2 = $_FILES['file2'];
    $filepath2 = tempnam(sys_get_temp_dir(), 'file2');
    if (move_uploaded_file($file2['tmp_name'], $filepath2)) {
        $attachments .= $filepath2 . " ";
    } else {
        $ok = false;
    }
}

// Send email
if ($ok && mail($to, $subject, $message, $headers, "-f$from")) {
    echo "<h1>Thank you, $name!</h1><p>Your application has been sent successfully.</p>";
} else {
    echo "<h1>Error</h1><p>Failed to send application. Please try again or contact us.</p>";
}

// Clean up temp files
if (isset($filepath1)) unlink($filepath1);
if (isset($filepath2)) unlink($filepath2);
?>
