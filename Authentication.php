<?php
session_start();
$db_connect = mysqli_connect('localhost', 'root', '', 'login_activity');

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Check if auto_login flag is set
$auto_login = isset($input['auto_login']) ? $input['auto_login'] : false;

if ($auto_login && isset($_COOKIE['remember_token'])) {
    $token = $_COOKIE['remember_token'];

    // Prepare and execute query
    $stmt = $db_connect->prepare('SELECT username FROM user_info WHERE remember_token = ?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user was found
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];

        echo json_encode([
            'status' => 'success',
            'message' => 'Auto-login successful',
            'username' => $user['username']
            
        ]);
 
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid token'
        ]);
    
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No token found or auto_login not enabled'
    ]);

}

