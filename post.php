<?php include('header.php');
?>
   <main>
      <?php
      $postget = $_GET['post_id'];
      $catget = $_GET['category_id'];
      $postquery = "SELECT users.username, users.user_id, posts.user_id, users.profile_pic, users.rank_id, users.status_id, users.user_is_banned, posts.post_id, posts.title, posts.date_created, posts.link_image, posts.category_id AS postcat, posts.body, categories.category_id, categories.catname FROM posts, categories, users WHERE posts.post_id = $postget AND users.user_id = posts.user_id AND posts.is_published = 1 LIMIT 1";
      $postreply = "SELECT posts.title, posts.body, posts.date_created, posts.post_id, users.username, users.profile_pic, users.user_id, users.rank_id, users.status_id, posts.link_image, posts.parent_id AS replyparent FROM posts, users WHERE posts.thread_id = $postget AND posts.user_id = users.user_id AND posts.parent_id != 0 ORDER BY date_created ASC";
      $results = $db->query($postquery);
      $replyresults = $db->query($postreply);
      if($results->num_rows > 0){
      ?>

       <div class="sectionContainer">
           <?php while($row = $results->fetch_assoc()){

            ?><div class="headlineTitle">
               <h2><?php echo $row['title']; ?></h2>
                <h4>Thread started by: <a href="profile.php?user_id=<?php echo $row['user_id']; ?>"><span><?php echo $row['username']; ?></span></a> on <?php echo convert_date($row['date_created']); ?></h4>
               </div>

       <section class="post" id="<?php echo $row['post_id'] ?>">

           <section class="postHeader">
               <div class="userStats">
                   <div class="postAvatar">
                       <?php if($row['user_is_banned']){ ?>
                           <div class="banBox" style="">BANNED!</div>
                       <?php } ?>
                       <div class="avatar" style="background: url(uploads/<?php echo $row['profile_pic']; ?>_thumbnail.jpg); background-size: cover;"></div>
                   </div>
                   <div class="infoBox">
                       <p class="byUser"><a href="profile.php?user_id=<?php echo $row['user_id']; ?>"><?php echo $row['username']; ?></a></p>
                       <div class="postRank" style="color:<?php if($row['status_id']  == 0){ echo '#D1DCF0';}else if($row['status_id'] == 1){echo 'yellow';}else if($row['status_id'] == 2){echo '#C00BC4';}else if($row['status_id'] == 3){ echo '#CD104B';}else{echo '#0EDE70';}; ?> "><?php get_rank($row['user_id'], $row['status_id']);?></div>

                   </div>
                   <section class="moderatePost"><?php moderation_delete($_SESSION['status_id'], $row['post_id'], $row['status_id']); ?></section>

               </div>
               <div class="userInfo">

                   <p class="postTitle"><a href="post.php?post_id=<?php echo $row['post_id']; ?>&category_id=<?php echo $row['category_id']; ?>"><?php echo $row['title']; ?></a></p>
                   <div class="postTime"><p>Posted on: &nbsp;<?php echo convert_date($row['date_created']); ?></p></div>

               </div>
           </section>
           <section class="postBody">
               <?php if($row['link_image'] != 'none'){ ?>
                <div class="linkImageContainer" style="background: url(<?php echo $row['link_image'] ?>); background-size: cover; background-repeat: no-repeat; background-position: center; display: block;">
                    <a href="<?php echo $row['link_image']; ?>" target="_blank"> </a>
                </div>
               <?php } //end if image is linked?>
               <?php echo $row['body']; ?>

               <p class="replyButton"><span  <?php reply_button_info($row['title'],$row['username'], $row['post_id']); ?>><a
                               href="#writePost">Reply</a></span></p>

           </section>
           <div class="replyToBox">
           </div>
       </section>
           <?php
           if($replyresults->num_rows > 0){
               while($replyrow = $replyresults->fetch_assoc()){
                   ?>
                   <section class="post" id="<?php echo $replyrow['post_id'] ?>">
                       <section class="postHeader">
                           <div class="userStats">
                               <div class="postAvatar">
                                   <?php if($replyrow['user_is_banned']){ ?>
                                       <div class="banBox" style="">BANNED!</div>
                                   <?php } ?>
                                   <div class="avatar" style="background: url(uploads/<?php echo $replyrow['profile_pic']; ?>_thumbnail.jpg); background-size: cover;"></div>
                               </div>
                               <div class="infoBox">
                                   <p class="byUser"><a href="profile.php?user_id=<?php echo $replyrow['user_id']; ?>"><?php echo $replyrow['username']; ?></a></p>
                                   <div class="postRank" style="color:<?php if($replyrow['status_id']  == 0){ echo '#D1DCF0';}else if($replyrow['status_id'] == 1){echo 'yellow';}else if($replyrow['status_id'] == 2){echo '#C00BC4';}else if($row['status_id'] == 3){ echo '#CD104B';}else{echo '#0EDE70';}; ?> "><?php get_rank($replyrow['user_id'], $replyrow['status_id']);?></div>

                               </div>
                               <section class="moderatePost"><?php moderation_delete($_SESSION['status_id'], $replyrow['post_id'], $replyrow['status_id']); ?></section>

                           </div>
                           <div class="userInfo">

                               <p class="postTitle"><a href="post.php?post_id=<?php echo $replyrow['post_id']; ?>&category_id=<?php echo $replyrow['category_id']; ?>"><?php echo $replyrow['title']; ?></a></p>
                               <div class="postTime"><p>Posted on: &nbsp;<?php echo convert_date($replyrow['date_created']); ?></p></div>

                           </div>
                       </section>
                       <section class="postBody">
                           <?php if($replyrow['link_image'] != 'none'){ ?>

                               <div class="linkImageContainer" style="background: url(<?php echo $replyrow['link_image'] ?>); background-size: cover; background-repeat: no-repeat; background-position: center; overflow: hidden;">
                                   <a href="<?php echo $replyrow['link_image']; ?>" target="_blank"> </a>
                               </div>

                           <?php } //end if image is linked?>
                           <div class="message"><?php echo $replyrow['body']; ?></div>
                           <p class="replyButton"><span <?php reply_button_info($replyrow['title'],$replyrow['username'], $replyrow['post_id']); ?>><a
                                           href="#writePost">Reply</a></span></p>
                       </section>
                       <?php get_author($replyrow['replyparent']); ?>


                   </section>
           <?php
               }//end while replies

           }//end if replies

            }//end post loop
           };//end if results
           ?>
</div>
       <div id="writePost">
       <?php if(isset($_SESSION['user_id'])){

        ?>
            <div id="post_info_box">
                <?php show_feedback( $feedback, $errors); ?>
                <p>Replying to: <span id="reply_to_title">TITLE</span></p>
                <p> by: <span id="reply_to_user">USER</span></p>
            </div>
           <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?post_id=<?php echo $postget ?>&category_id=<?php echo $catget ?>#writePost">


               <input type="text" name="the_post_title" required maxlength="40" id="the_post_title" placeholder="Please write a title for your post">
               <textarea name="the_post_body" id="the_post_body" rows="8" placeholder="Please write a post" required maxlength="2000"></textarea>
               <input type="text" name="the_linked_image" placeholder="Paste link to an image to embed">

               <input type="submit" value="Post">
               <input type="hidden" name="reply_to_post" id="reply_to_post" value="<?php echo $_GET['post_id']; ?>">
               <input type="hidden" name="did_post" value="1">

           </form>

       <?php }//end if logged in
        else{
            ?>
            <p style="text-align: center;">Please Sign in to post</p>

            <?php
        }
       ?>
       </div>
   </main>
<?php include('footer.php'); ?>
</div>

<script src="layout.js"></script>
</body>
</html>