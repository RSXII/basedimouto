<?php
//re-create the session if the cookie is still valid
if( $_COOKIE['loggedin'] ){
    $_SESSION['loggedin'] = 1;
}

//Logout Action
if( $_GET['action'] == 'logout' ){
//close the session and the associated cookie. this snippet is from php.net
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();

    $_SESSION['user_id'] = '';
    setcookie( 'user_id', '', time() -9999999 );

    $_SESSION['secret_key'] = '';
    setcookie( 'secret_key', '', time() -9999999 );

    $_SESSION['status_id'] = '';
}//end of logout action

//if the form was submitted, parse it
if( $_POST['did_login'] ){
//extract the data
    $username = clean_string($_POST['username']);
    $password = clean_string($_POST['password']);
//validate the data
    $valid = true;
    if($username == '' || strlen($username) > 40){
        $valid = false;
        $errors['username'] = 'Username is the wrong length';
    }
    if(strlen($password) < 8){
        $valid = false;
        $errors['password'] = 'Password is too short';
    }
//if valid check the credentials against the database
    if($valid) {
        $password = sha1($password . SALT);
        $query = "SELECT user_id, status_id FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
        $result = $db->query($query);

//send the user to the secret page if they got it right, or show an error
        if ( $result->num_rows == 1) {

//success - remember the user for 1 day and then redirect to secret page
            $secret_key = sha1(microtime() . SALT);
            $row = $result->fetch_assoc();
            $user_id = $row['user_id'];
            $status_id = $row['status_id'];
            //store key in database for THIS user
            $query = "UPDATE users SET secret_key = '$secret_key' WHERE user_id = $user_id LIMIT 1";
            $result = $db->query($query);
            //make sure query worked
            if ($db->affected_rows == 1) {

                setcookie('secret_key', $secret_key, time() + 60 * 60 * 24);
                $_SESSION['secret_key'] = $secret_key;

                setcookie('user_id', $user_id, time() + 60 * 60 * 24);
                $_SESSION['user_id'] = $user_id;

                $_SESSION['status_id'] = $status_id;

                header('Location:index.php');
            }
            else{
                $error_message = 'No rows affected';
            }
        }else {
//error - user feedback
            $error_message = 'Sorry, your username/password combo is incorrect. Try again.';
        }
    }//end if valid
} //end of login parser