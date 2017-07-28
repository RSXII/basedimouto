<?php
//parse the form if submitted
if($_POST['did_register']){
    //sanitize everything
    $username = clean_string($_POST['username']);
    $email = clean_email($_POST['email']);
    $password = clean_string($_POST['password']);
    $policy = clean_int($_POST['policy']);
    //validate everything
    $valid = true;
    //username is blank or greater than 40 characters
    if( $username =='' || strlen($username) > 40 ){
        $valid = false;
        $errors['username'] = 'Your username must be between 1 - 40 characters long';
    }else{
        //is the username already taken
        $query = "SELECT username FROM users WHERE username = '$username' LIMIT 1";
        $result = $db->query($query);
        //if one result is found, the username is taken already;
        if( $result->num_rows == 1 ){
            $valid = false;
            $errors['username'] = 'We\'re sorry.  This username is already taken.';
        }//end if result found
    }//end username test

    //email is blank or invalid email address
    if( !filter_var($email, FILTER_VALIDATE_EMAIL) ){
        $valid = false;
        $errors['email'] = 'Please provide a valid email address';
    }else{
        $query = "SELECT email FROM users WHERE email = '$email' LIMIT 1";
        $result = $db->query($query);

        if($result->num_rows == 1){
            //has the email already been registered
            $valid = false;
            $errors['email'] = 'We\'re sorry.  This email is already in use.';
        }
    }
    if(strlen($password) < 8){
        $valid = false;
        $errors['password'] = 'You\'re password needs to be at least 8 characters';
    }
    //password is less than 8 characters
    //if the policy box is not checked
    if($policy !=1){
        $valid = false;
        $errors['policy'] = 'Please agree to the terms of service before registering';
    }
    //if valid, add the user to the database
    if($valid){
        //hash the password before storage
        $password = sha1($password . SALT );
        $query = "INSERT INTO users (username, password, email, profile_likes, rank_id, points, join_date, status_id) VALUES ('$username', '$password', '$email', 0, 1, 0, now(), 0)";
        $result = $db->query($query);
        if( $db->affected_rows == 1 ){
            //success and redirect to login
            header('Location:login.php');
        }else{
            $feedback = 'Oops!  Something went wrong on our end.  Please try again later.';
        }
    }else{
        $feedback = 'Please fix the following errors.';
    }//end if valid
    //if valid and added to DB, redirect to the login form

}//end parser