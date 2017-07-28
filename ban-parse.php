<?php
if( $_POST['did_ban'] ){
            $the_profile_id = $_GET['user_id'];
            $updateban = "UPDATE users SET user_is_banned = '1' WHERE users.user_id = $the_profile_id LIMIT 1";
            $db->query($updateban);
            header("Refresh:0");
}
if( $_POST['did_unban'] ){
    $the_profile_id = $_GET['user_id'];
    $updateban = "UPDATE users SET user_is_banned = '0' WHERE users.user_id = $the_profile_id LIMIT 1";
    $db->query($updateban);
    header("Refresh:0");
}