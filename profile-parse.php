<?php
if( $_POST['update_gender'] ){
$the_profile_id = $_GET['user_id'];
$the_gender = clean_string($_POST['changegender']);
if($the_gender == '' || strlen($the_gender) > 20){
    $feedback = 'There is an error:';
    $errors['body'] = 'Your gender must be between 1 and 20 characters';
}else{
    $updategender = "UPDATE users SET gender = '$the_gender' WHERE users.user_id = $the_profile_id LIMIT 1";
    $db->query($updategender);
    header("Refresh:0");
}

}
if( $_POST['update_location'] ){
    $the_profile_id = $_GET['user_id'];
    $the_location = clean_string($_POST['changelocation']);
    if($the_location == '' || strlen($the_location) > 100){
        $feedback = 'There is an error:';
        $errors['body'] = 'Your location must be between 0 and 100 characters';
    }else{
        $updatelocation = "UPDATE users SET location = '$the_location' WHERE users.user_id = $the_profile_id LIMIT 1";
        $db->query($updatelocation);
        header("Refresh:0");
    }

}
if( $_POST['update_bio'] ){
    $the_profile_id = $_GET['user_id'];
    $the_bio = clean_string($_POST['changebio']);
    if($the_bio == '' || strlen($the_bio) > 256){
        $feedback = 'There is an error:';
        $errors['body'] = 'Bio must be between 1 and 256 characters';
    }else{
        $updatebio = "UPDATE users SET bio = '$the_bio' WHERE users.user_id = $the_profile_id LIMIT 1";
        $db->query($updatebio);
        header("Refresh:0");
    }

}
if( $_POST['enable_moderator'] ){
    $the_profile_id = clean_string($_GET['user_id']);
    $promote = clean_int($_POST['enable_moderator']);
    $updatemoderator = "UPDATE users SET status_id = 3 WHERE users.user_id = $the_profile_id LIMIT 1";
    $db->query($updatemoderator);
    header("Refresh:0");
}
if( $_POST['disable_moderator'] ){
    $the_profile_id = clean_string($_GET['user_id']);
    $promote = clean_int($_POST['disable_moderator']);
    $updatemoderator = "UPDATE users SET status_id = 0 WHERE users.user_id = $the_profile_id LIMIT 1";
    $db->query($updatemoderator);
    header("Refresh:0");
}