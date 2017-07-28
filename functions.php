<?php
//CONVERTS DATETIME INTO AN EASY TO READ FORMAT
function convert_date($timestamp){
    $date = new DateTime($timestamp);
    return $date->format('F j Y g:i a');
}
function rss_date($timestamp){
    $date = new DateTime($timestamp);
    return $date->format('r');
}

//COUNT THE NUMBER OF COMMENTS ON ANY POST
//$post_id IS ANY VALID INT ON ANY VALID POST ID
//$one IS FOR A SINGLE COMMENT
//$many IS FOR 0 OR MORE THAN ONE COMMENT

function count_comments( $post_id, $one = ' comment', $many =' comments' ){
    //PULLS IN GLOBAL DATABASE CONNECTION DEFINED IN DBCONFIG
    global $db;
    //QUERY
    $query = "SELECT COUNT(*) AS total FROM comments WHERE post_id = $post_id";
    //RUN QUERY
    $result = $db->query($query);
    //CHECK QUERY
    if($result->num_rows > 0){
        while( $row = $result->fetch_assoc() ){
            //DISPLAY QUERY COUNT
            if( $row['total'] == 1 ){
                echo $row['total'] . $one;
            }else{
                echo $row['total'] . $many;
            }
        }// END WHILE
    } // END IF

}
//clean data from user inputs
function clean_string( $data ){
    global $db;
    return mysqli_real_escape_string($db, filter_var( $data, FILTER_SANITIZE_STRING ));
}
function clean_email( $data ){
    global $db;
    return mysqli_real_escape_string($db, filter_var( $data, FILTER_SANITIZE_EMAIL ));
}
function clean_int( $data ){
    global $db;
    return mysqli_real_escape_string($db, filter_var( $data, FILTER_SANITIZE_NUMBER_INT ));
}
function clean_boolean( $data ){
    global $db;
    $clean = mysqli_real_escape_string($db, filter_var( $data, FILTER_SANITIZE_NUMBER_INT ));
    if($clean != 1){
        $clean = 0;
    }
    return $clean;
}
//cleans the body post but allows blockquotes and em's
function clean_post_body( $data ){
    global $db;
    return mysqli_real_escape_string($db, strip_tags($data, '<blockquote><p><a><span>'));
}

//display html for success or errors
function show_feedback( $message, $list ){
    if( isset($message)){
        ?>
        <div class="feedback">
            <b><?php echo $message; ?></b>
            <?php
            if( !empty($list)){
                ?>
                <ul>
                    <?php foreach($list as $item ){ ?>
                        <li>
                            <?php echo $item; ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <?php
    }
}
//$current = an integer for the category that should be selected dynamically when editing posts
//display a dropdown menu of all categories
function category_dropdown( $current = 0 ){
    global $db;
    $query = "SELECT * FROM categories";
    $result = $db->query($query);
    if( $result->num_rows >= 1 ){
        ?>
        <select name="category_id" id="the_cat">
            <?php while( $row = $result->fetch_assoc() ){ ?>
                <option value="<?php echo $row['category_id']; ?>" <?php if( $current == $row['category_id']){ echo 'selected'; }?>>
                    <?php echo $row['name']; ?></option>
            <?php }//end while rows ?>
        </select>
    <?php }else{
        echo 'No Categories to Show';
    }
}
//takes an id and queries the database for the username associated with that id and echo's it
function get_author( $the_parent_id = 0 ){
    global $db;
    $reply_to_query = "SELECT users.username, posts.post_id, posts.parent_id FROM users, posts WHERE posts.post_id = $the_parent_id AND posts.user_id = users.user_id";
    $reply_to_result = $db->query($reply_to_query);
    if( $reply_to_result->num_rows > 0){
        while($reply_to_row = $reply_to_result->fetch_assoc()){ ?>
            <div class="replyToBox">
                <p><a href="#<?php echo $reply_to_row['post_id']?>" class="replyToLink" <?php echo 'onclick="' . "replyFunction(" . $reply_to_row['post_id'] . ')"' ?>>Replying to: <?php echo $reply_to_row['username']; ?></a></p>
            </div>
            <?php

        }//end while result
    } //end if results
}//end function
//function to pull the title and username from a post when clicking reply.
function reply_button_info($title, $username, $postid){
    echo 'onclick="reply_to_post(' . '\'' . $title . '\',\'' . $username . '\',\'' . $postid . '\')"';
};

function get_rank( $userid, $statusid ){ //displays the name of the rank depending on if they are a user or admin/moderator
        global $db;
        if($statusid == 0){
            $query = "SELECT rank.name FROM users, rank WHERE users.user_id = $userid AND users.points <= rank.points_needed ORDER BY points DESC LIMIT 1;";
            $rank_query = $db->query($query);
            $the_rank = $rank_query->fetch_assoc();
            echo $the_rank['name'];
        }else{
            $query = "SELECT mod_status.name, mod_status.color FROM mod_status, users WHERE users.user_id = $userid AND mod_status.status_id = $statusid LIMIT 1";
            $the_status = $db->query($query);
            $status_name = $the_status->fetch_assoc();
            echo $status_name['name'];
        }

};

function moderation_delete($status, $modid, $userstatus){
    if($status >= 1){ // checks if user is a moderator
        if($status <= $userstatus || $userstatus == 0){ // checks to ensure the moderator outranks the persons post they are deleting
            echo '<form method="post">
                <input type="hidden" name="did_delete" value="1">
                <input type="checkbox" name="delete[]" value="' . $modid  . '">
                <input type="submit" value="Delete Post">
                </form>';
        }//end check rank
    }//end check moderator
};
function check_ban($ban_id){
    if($ban_id == 1){
            echo '<span style="color: red;">Banned</span>';
    }
}
function check_rank($rank_id, $id){
    if($id == 0){
        if($rank_id == 1){
            echo 'Beginner';
        }
    }
    if($id == 1){
        if($rank_id == 1){
            echo '<span style="color: yellow;">Server Admin</span>';
        }else if($rank_id == 2){
                echo '<span style="color: #C00BC4;">Head Admin</span>';
        }else if($rank_id == 3){
            echo '<span style="color: #CD104B;">Moderator</span>';
        }
    }

}
