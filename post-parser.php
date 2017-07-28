<?php

if( $_POST['did_post'] ){
    //extract and sanitize
    $title = clean_string( $_POST['the_post_title'] );
    $body = clean_post_body( $_POST['the_post_body'] );
    $parent_id = clean_int( $_POST['reply_to_post'] );
    $userid = clean_int($_SESSION['user_id']);
    $linked_image = clean_string( $_POST['the_linked_image'] );
    $threadid = $_GET['post_id'];
    if( isset($threadid) ){
        $threadid = clean_int($_GET['post_id']);
    }else{
        $threadid = 0;
    }
    $categoryid = clean_int($_GET['category_id']);
    //validate
    $valid = true;
    //post title is blank or too long
    if( $title == '' || strlen($title) > 256){
        $valid = false;
        $errors['title'] = 'Please enter a valid title. (Maximum of 256 characters)';
    }
    //post body is blank
    if( $body == '' || strlen($body) > 2000){
        $valid = false;
        $errors['body'] = 'Body Field cannot be blank or more than 2000 characters';
    }
    if( $linked_image == '' ){
        $linked_image = 'none';
    }
    //if valid, add to DB
    if($valid){
        $ban_test = "SELECT user_id FROM users WHERE user_id = $userid AND user_is_banned = 1";
        $bantest = $db->query($ban_test);
        if($bantest->num_rows == 0){

            $duplicate_test = "SELECT user_id, title, body, parent_id, category_id, thread_id FROM posts WHERE user_id = $userid AND title = '$title' AND body = '$body' AND category_id = $categoryid AND thread_id = $threadid AND parent_id = $parent_id";
            $dupresult = $db->query($duplicate_test);
            if($dupresult->num_rows == 0){
                $postquery = "INSERT INTO posts (user_id, title, body, date_created, allow_comments, is_published, is_locked, parent_id, category_id, thread_id, link_image) VALUES ($userid, '$title', '$body', now(), 1, 1, 0, $parent_id, $categoryid, $threadid, '$linked_image')";
                //run it
                $result = $db->query($postquery);
                //check it
                if( $db->affected_rows == 1){
                    if($threadid == 0){
                        $newid = $db->insert_id;
                        $updateid = "UPDATE posts SET thread_id = $newid WHERE post_id = $newid";
                        $db->query($updateid);
                    };
                }else{
                    $feedback = 'Oops!  Something went wrong on our end and your post could not be posted.  Please try again shortly';
                }
            }else{
                $feedback = 'You cannot post a duplicate post';
            }
        }else{  //end if banned
            $feedback = 'YOU ARE BANNED!';
        }

        //end if valid
    }else{
        $feedback = 'There are errors in the comment submission.  Please fix the following:';
    }

    //give user feedback
    //end of comment parser
}
if( $_POST['did_delete'] ){
    //which posts did they check
    $list = $_POST['delete'];
    foreach( $list as $post_id ){
        $query = "DELETE FROM posts WHERE post_id = $post_id OR thread_id = $post_id";
        $result = $db->query($query);
    }//end of for each
}//end of delete parser

