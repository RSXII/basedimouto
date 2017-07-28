<?php include('header.php'); ?>
   <main class="indexList">
       <section class="forumWelcome">
        <h1>Welcome to the Ba$ed Imouto Forums</h1>
       </section>
       <?php
       $categoryquery = "SELECT category_id, catname, description FROM categories";
       $catresults = $db->query($categoryquery);
       if($catresults->num_rows > 0){
           while($catrow = $catresults->fetch_assoc()){
               $cat_id = $catrow['category_id'];
       $query = "SELECT users.username, users.user_id, users.profile_pic, users.status_id, users.user_is_banned, posts.title, posts.link_image, posts.body, posts.post_id, posts.date_created, categories.category_id, categories.catname AS catname FROM users, posts, categories
                  WHERE users.user_id = posts.user_id AND posts.category_id = categories.category_id AND is_published = 1 AND categories.category_id = $cat_id AND parent_id = 0 ORDER BY date_created DESC LIMIT 3";
       $results = $db->query($query);

       ?>
       <div class="sectionContainer">
       <section class="category" style="text-align: center;">
           <h3><a href="category.php?category_id=<?php echo $catrow['category_id']; ?>&category_name=<?php echo $catrow['catname']; ?>"><?php echo $catrow['catname']; ?></a></h3>
           <p><?php echo $catrow['description']; ?></p>
       </section>
           <?php while($row = $results->fetch_assoc()){

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

                <a href="post.php?post_id=<?php echo $row['post_id']; ?>&category_id=<?php echo $row['category_id']; ?>">
                <div class="userInfo">

                <p class="postTitle"><?php echo $row['title']; ?></p>
                    <div class="postTime"><p>Posted on: &nbsp;<?php echo convert_date($row['date_created']); ?></p></div>

                </div> </a>
            </section>
           <?php if($row['category_id'] == 1){ ?>
           <section class="postBody">
               <?php if($row['link_image'] != 'none'){ ?>
                   <div class="linkImageContainer" style="background: url(<?php echo $row['link_image'] ?>); background-size: cover; background-repeat: no-repeat; background-position: center; width: 200px; height: 200px; margin: 0 auto; display: block;">
                       <a href="<?php echo $row['link_image']; ?>" target="_blank"> </a>
                   </div>
               <?php } //end if image is linked?>
               <p><?php echo $row['body']; ?></p>
           </section>
           <?php } // end display body if announcements category ?>
       </section>
           <?php }//end post loop ?>
</div>
       <?php }//end category loop
       }
       ?>
   </main>
<?php include('footer.php'); ?>
</div>

<script src="layout.js"></script>
</body>
</html>