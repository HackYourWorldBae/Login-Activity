<?php
session_start();
header('Content-Type: application/json');

// DB connection
$db_connect = mysqli_connect('localhost', 'root', '', 'login_activity');

//error handling
if (!$db_connect) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}


//get user input from fetch
$input = json_decode(file_get_contents('php://input'), true);
$remember = $input['remember_me'];


    $loginUsername = $input['loginUsername'];
    $loginPass = $input['loginPassword'];
    $stmt_login = $db_connect->prepare("SELECT id, username, pass FROM user_info WHERE username = ?");
    $stmt_login->bind_param('s',$loginUsername);
    $stmt_login->execute();
    $login_result = $stmt_login->get_result();

    if ($login_result->num_rows > 0)
    {
        $user = $login_result->fetch_assoc();
        
        if ($loginUsername == $user['username'] && password_verify($loginPass, $user['pass']))
        {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            echo json_encode(['status' => 'success', 'message' => 'Logged in Successfully']);

            if($remember){
                $token = bin2hex(random_bytes(32));
                $expires = date('Y-m-d H:i:s', time() + (86400 * 30)); // 30 days
        
                setcookie("remember_token", $token, time() + (86400 * 30), "/");
        
                $stmt = $db_connect->prepare("UPDATE user_info SET remember_token = ?, token_expires = ? WHERE id = ?");
                $stmt->bind_param("ssi", $token, $expires, $user['id']);
                $stmt->execute();
            }

            $stmt_login->close();
            $db_connect->close();
            exit;
        }
        else
        {
            echo json_encode(['status' => 'error','message' => 'incorrect username or password']);
            exit;
        }
    } 
    else 
    {
        echo json_encode(['status' => 'error','message' => 'user not found']);
        $stmt_login->close();
        $db_connect->close();
        exit;
    }
