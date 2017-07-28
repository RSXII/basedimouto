<?php include('header.php'); ?>
   <main class="catList">
      <?php
      $categoryget = $_GET['category_id'];
      $categoryname = $_GET['category_name'];
      $postquery = "SELECT posts.title, posts.body, posts.post_id, posts.link_image, posts.user_id, users.user_id, users.username, users.profile_pic, users.user_is_banned, users.rank_id, users.status_id, categories.category_id, categories.catname FROM posts, categories, users WHERE categories.category_id = $categoryget AND posts.user_id = users.user_id AND posts.category_id = $categoryget AND posts.parent_id = 0 ORDER BY posts.date_created DESC";
      $results = $db->query($postquery);
      ?>
      <div class="sectionContainer">
       <section class="category" style="text-align: center;">
           <h3><?php echo $categoryname; ?></h3>
       </section>
          <?php
          if($results->num_rows > 0){
            while($row = $results->fetch_assoc()){
            ?>
                <section class="post">
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
                            <div class="linkImageContainer" style="background: url(<?php echo $row['link_image'] ?>); background-size: cover; background-repeat: no-repeat; background-position: center; width: 200px; height: 200px; margin: 0 auto; display: block;">
                                <a href="<?php echo $row['link_image']; ?>" target="_blank"> </a>
                            </div>
                        <?php } //end if image is linked?>
                        <p><?php echo $row['body']; ?></p>
                    </section>
                </section>
           <?php
          }// end while
           }//end if

           ?>
</div>

       <div id="writePost">
           <?php if(isset($_SESSION['user_id'])){
                if($_SESSION['status_id'] >= 1 && $_GET['category_id'] == 1){ ?>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?category_id=<?php echo $categoryget ?>&category_name=<?php echo $categoryname ?>#writePost">


                   <input type="text" name="the_post_title" required maxlength="40" id="the_post_title" placeholder="Please write a title for your post">
                   <textarea name="the_post_body" id="the_post_body" rows="8" placeholder="Please write a post" required maxlength="2000"></textarea>

                   <input type="submit" value="Post">
                   <input type="hidden" name="reply_to_post" id="reply_to_post" value="0">
                   <input type="hidden" name="did_post" value="1">

               </form>
                    <?php
                }else if($_SESSION['status_id'] == 0 && $_GET['category_id'] == 1){
                     ?>
                    <p style="text-align: center;">Users can not post in Announcements</p>
                    <?php
                }else{


               ?>
               <div id="post_info_box">
                   <?php show_feedback( $feedback, $errors); ?>
                   <p>Create a thread in <?php echo $_GET['category_name']; ?></p>
               </div>
               <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>?category_id=<?php echo $categoryget ?>&category_name=<?php echo $categoryname ?>#writePost">


                   <input type="text" name="the_post_title" required maxlength="40" id="the_post_title" placeholder="Please write a title for your post">
                   <textarea name="the_post_body" id="the_post_body" rows="8" placeholder="Please write a post" required maxlength="2000"></textarea>
                   <input type="text" name="the_linked_image" placeholder="Paste link to an image to embed">

                   <input type="submit" value="Post">
                   <input type="hidden" name="reply_to_post" id="reply_to_post" value="0">
                   <input type="hidden" name="did_post" value="1">

               </form>

           <?php }//end check announcements for privileges
                }//end if logged in
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