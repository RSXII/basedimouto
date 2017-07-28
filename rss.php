<?php
require('dbconfig.php');
include_once('functions.php');
//for compatibility echo the xml tag otherwise it is confused by the <?
echo '<?xml version="1.0"?>';

//get all the recent posts from the database
$query = "SELECT posts.title, posts.post_id, posts.date_created, posts.body, users.username  FROM posts, users WHERE posts.user_id = users.user_id AND posts.is_published = 1 ORDER BY posts.date_created DESC LIMIT 10";
$result = $db->query($query);
if(! $result){
//    die();
    echo 'no results';
}
if($result->num_rows >= 1){
    ?>
    <rss version="2.0">
        <channel>
            <title>Ba$ed Forums RSS</title>
            <link>http://localhost/schultz_ryan/based_forum/siteroot/</link>
            <description>Subscribe to a thread to get updates</description>
            <?php while( $row = $result->fetch_assoc() ){ ?>
                <item>
                    <title><?php echo $row['title']; ?></title>
                    <link>http://localhost/schultz_ryan/based_forum/siteroot/post.php?post_id=<?php echo $row['post_id']; ?></link>
                    <guid>http://localhost/schultz_ryan/based_forum/siteroot/post.php?post_id=<?php echo $row['post_id']; ?></guid>
                    <author><?php echo $row['username']; ?></author>
                    <pubDate><?php echo rss_date($row['date_created']); ?></pubDate>
                    <description><?php echo $row['body']; ?></description>
                </item>
            <?php }//end while ?>
        </channel>

    </rss>

<?php } ?>