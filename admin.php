<?php
include('header.php');
include('admin-parse.php');
if($_SESSION['status_id'] == 1 || $_SESSION['status_id'] == 2 || $_SESSION['status_id'] == 3 || $_SESSION['status_id'] == 4){

?>


<main>
    <div class="">
        <section class="tos">
        <div style=" width: 100%; max-width: 1200px; min-width: 300px; margin: 0 auto;">
            <div class="row">
                <aside id="adminPanel">
                    <form method="post">
                        <input type="hidden" name="show_users" id="show_users" value="1">
                        <input type="submit" value="User List">
                    </form>
                    <form method="post">
                        <input type="hidden" name="show_posts" id="show_posts" value="1">
                        <input type="submit" value="Post List">
                    </form>
                    <form method="post">
                        <input type="hidden" name="show_options" id="show_options" value="1">
                        <input type="submit" value="Options">
                    </form>
                </aside>
                <section id="viewBox">
                    <?php
                    if(isset($results)){
                    while($row = $results->fetch_assoc()){
                     ?>
                    <section class="row">
                        <?php if(isset($row['user_id'])){

                        ?>
                    <div><a href="profile.php?user_id=<?php echo $row['user_id']; ?>" target="_blank"><?php echo $row['username']; ?></a></div>
                   <?php }//end if users
                        else if($row['category_id']){
                        ?>
                            <div><a href="post.php?post_id=<?php if($row['parent_id'] == 0){echo $row['post_id'];}else{echo $row['parent_id'];} ?>&category_id=<?php echo $row['category_id']; ?>" target="_blank"><?php echo $row['username']; ?></a></div>
                            <?php }//end if posts?>
                    <div><?php
                        if($row['status_id'] == 0){
                         check_rank($row['rank_id'], 0);}else{
                            check_rank($row['status_id'], 1);
                        } ?></div>
                    <div><?php echo convert_date($row['join_date']); ?></div>
                    <div><?php echo check_ban($row['user_is_banned']); ?></div>
                    </section>
                    <?php
                    }//end while
                    } // end if results ?>

                </section>
            </div>




        </div>
        </section>
    </div>
</main>
<?php }//end if admin
else{ header("Location:login.php"); }
include('footer.php'); ?>
</div>


<script src="layout.js"></script>
</body>
</html>