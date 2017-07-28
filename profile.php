<?php
include('header.php');
$the_profile_id = $_GET['user_id'];
$query = "SELECT username, email, gender, location, bio, profile_pic, status_id, user_is_banned, user_id FROM users WHERE user_id = $the_profile_id";
$results = $db->query($query);
$viewed_profile_pic;
$is_user_banned;
include('image-parser.php');
include('profile-parse.php');
?>

   <main>
       <div id="profileLayout">

           <?php
           if($results->num_rows > 0){
               while($row = $results->fetch_assoc()){
                   $viewed_profile_pic = $row['profile_pic'];
                   $is_user_banned = $row['user_is_banned'];?>
           <div id="profilePicture">
               <div class="ppContainer">

               </div>

               <?php if($the_profile_id == $session_user){
                   show_feedback($feedback, $errors);
                   ?>
                <button id="changeProfilePictureButton">Change Profile Picture</button>

               <section id="change_profile_picture">
                   <form action="<?php echo $_SERVER['PHP_SELF'] ?>?user_id=<?php echo $the_profile_id ?>" method="post"
                         enctype="multipart/form-data">

                       <label><h4>Change your User Picture</h4></label>
                       <input type="file" name="uploadedfile">

                       <input type="submit" value="Save User Picture">

                       <input type="hidden" name="did_upload" value="1">
                   </form>

               </section>
               <?php } ?>
           </div>
          <div>
              <p><span>Name:</span>&nbsp; <?php echo $row['username']; ?></p>
              <span class="postRank" style="color:<?php if($row['status_id']  == 0){ echo '#D1DCF0';}else if($row['status_id'] == 1){echo 'yellow';}else if($row['status_id'] == 2){echo '#C00BC4';}else if($row['status_id'] == 3){ echo '#CD104B';}else{echo '#0EDE70';}; ?> "><?php get_rank($row['user_id'], $row['status_id']);?></span>
          </div>



           <?php if($the_profile_id == $session_user || $_SESSION['status_id']){ ?>
           <div>
               <p><span>Email:</span>&nbsp; <?php echo $row['email']; ?></p>
               <?php if($the_profile_id == $session_user || $_SESSION['status_id'] == 1){ ?>
                   <button>Change Email</button>
               <?php } ?>
           </div>
           <?php } //end if user?>
           <div>
               <p><span>Gender:</span>&nbsp; <?php echo $row['gender']; ?></p>
               <?php if($the_profile_id == $session_user){ ?>
                   <button id="changeGenderButton">Change Gender</button>
                   <section id="change_gender">
                       <form method="post">

                           <label><h4>Change your gender</h4></label>
                           <input type="text" name="changegender">

                           <input type="submit" value="Update">

                           <input type="hidden" name="update_gender" value="1">
                       </form>

                   </section>
               <?php } ?>
           </div>
           <div>
               <p><span>Location:</span>&nbsp; <?php echo $row['location']; ?></p>
               <?php if($the_profile_id == $session_user){ ?>
                   <button id="changeLocationButton">Change Location</button>
                   <section id="change_location">
                       <form method="post">

                           <label><h4>Change your location</h4></label>
                           <input type="text" name="changelocation">

                           <input type="submit" value="Update">

                           <input type="hidden" name="update_location" value="1">
                       </form>

                   </section>
               <?php } ?>
           </div>
           <div id="user_bio">
               <span>Bio:</span>&nbsp; <?php echo $row['bio']; ?>
               <?php if($the_profile_id == $session_user){ ?>
                   <br>
                   <br>
                   <button id="changeBioButton">Edit Bio</button>
                   <section id="change_bio">
                       <form method="post">

                           <label><h4>Change your bio</h4></label>
                           <textarea name="changebio" id="" cols="30" rows="10"></textarea>

                           <input type="submit" value="Update">

                           <input type="hidden" name="update_bio" value="1">
                       </form>

                   </section>

               <?php } ?>
           </div>
           <?php
               if($_SESSION['status_id'] >= 1 && $_SESSION['user_id'] != $the_profile_id){
                    if($_SESSION['status_id'] <= $row['status_id'] OR $row['status_id'] == 0){

                  ?>
                   <div>
                       <form action="<?php echo $_SERVER['PHP_SELF'] ?>?user_id=<?php echo $the_profile_id ?>" method="post"
                             enctype="multipart/form-data">
                           <?php if($row['user_is_banned'] == 0){
                               include('ban-parse.php');
                            ?>
                           <input type="submit" value="BAN USER" style="color: red;">
                               <input type="hidden" name="did_ban" value="1">
                           <?php }else{
                               include('ban-parse.php'); ?>
                               <input type="submit" value="UNBAN USER" style="color: greenyellow;">
                               <input type="hidden" name="did_unban" value="1">
                           <?php  }; //end ban button conditional?>

                       </form>
                   </div>
               <?php
                    }//end if logged in user outranks profile to ban
               }//end if moderator enable ban
                   if( ($_SESSION['status_id'] == 1 || $_SESSION['status_id'] == 2) && ($_SESSION['status_id'] < $row['status_id'] || $row['status_id'] == 0) ){
                       if($row['status_id'] == 0){
                   ?>
                       <form method="post">
                           <input type="hidden" name="enable_moderator" value="1">
                           <input type="submit" value="Promote to Moderator" style="color: #ffb243;">
                       </form>
                   <?php
                       }//end if regular user then promote
                       else{
                        ?>
                           <form method="post">
                               <input type="hidden" name="disable_moderator" value="1">
                               <input type="submit" value="Demote to User" style="color: #ff726d;">
                           </form>
                       <?php
                       }//end if a moderator then demote
                   }//end if administrator or head moderator
             }//end while user results
           }//end if logged in
           else{ ?>
               <div>
                   <p><span><h2>YOU ARE NOT LOGGED IN!</h2></span></p>
               </div>
               <?php } //end else if not logged in?>

       </div>
   </main>



<?php include('footer.php'); ?>
</div>


<script src="layout.js"></script>
<style>
.ppContainer{
    background: url(uploads/<?php echo $viewed_profile_pic; ?>_medium.jpg);
}
</style>
</body>
</html>