<?php
//show users list
if($_POST['show_users']){
 $query = "SELECT *  FROM users ORDER BY username ASC";
 $results = $db->query($query);
}
//show posts list
if($_POST['show_posts']){
    $query = "SELECT title AS username, date_created AS join_date, body AS status_id, category_id, post_id, parent_id FROM posts WHERE is_published = 1 ORDER BY date_created DESC LIMIT 20";
    $results = $db->query($query);
}