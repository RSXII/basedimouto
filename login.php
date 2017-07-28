<?php
include('header.php');


?>


   <main>
       <div class="register">
           <section class="inputContainer">
               <h1>Log into your account</h1>

               <?php show_feedback( $feedback, $errors ); ?>
               <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                   <label for="the_username">Username</label><br>
                   <input type="text" name="username" required maxlength="40" id="the_username">

                   <label for="the_password">Password</label><br>
                   <input type="password" name="password" id="the_password" required>

                   <input type="submit" value="Log in">
                   <input type="hidden" name="did_login" value="1">
               </form>
               <div class="row loginreg">
                   <p class="col-sm-6"><a href="login.php">LOGIN</a></p>
                   <p class="col-sm-6"><a href="register.php">REGISTER</a></p>
               </div>
           </section>

       </div>
   </main>
<?php include('footer.php'); ?>
</div>


<script src="layout.js"></script>
</body>
</html>