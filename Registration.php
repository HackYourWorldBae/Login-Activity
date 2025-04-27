<?php
header('Content-Type: application/json');

// DB connection
$db_connect = mysqli_connect('localhost', 'root', '', 'login_activity');

// error handling
if (!$db_connect) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

// Get the JSON input data from the fetch request
$input = json_decode(file_get_contents('php://input'), true);

// Check if the necessary data is available in the request
if (!isset($input['username'], $input['email'], $input['password'], $input['g-recaptcha-response'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

// Extract inputs
$username = $input['username'];
$email = $input['email'];
$pass = $input['password'];
$recaptcha_response = $input['g-recaptcha-response']; // reCAPTCHA response from the JavaScript

// Check if username exists
$stmt = $db_connect->prepare("SELECT 1 FROM user_info WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
    $stmt->close();
    $db_connect->close();
    exit;
}
$stmt->close();

// Check if email exists
$stmt = $db_connect->prepare("SELECT 1 FROM user_info WHERE email = ?");
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
    $stmt->close();
    $db_connect->close();
    exit;
}
$stmt->close();

// Verify reCAPTCHA with Google
$secret_key = '6Lc9hBIrAAAAAD0ZkoREZwIzOh4ZsFngkV2VslcL';
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$recaptcha_response");
$response_keys = json_decode($response, true);

if (intval($response_keys["success"]) !== 1) {
    // reCAPTCHA validation failed
    echo json_encode(['status' => 'error', 'message' => 'reCAPTCHA verification failed.']);
    exit;
}

// Hash the password
$hashed_password = password_hash($pass, PASSWORD_DEFAULT);

// Insert the user data into the database
$stmt = $db_connect->prepare("INSERT INTO user_info (username, email, pass) VALUES (?, ?, ?)");
$stmt->bind_param('sss', $username, $email, $hashed_password);
$stmt->execute();

// Close the statement and DB connection
$stmt->close();
$db_connect->close();

// Return success message
echo json_encode(['status' => 'success', 'message' => 'You signed up successfully']);
exit;
