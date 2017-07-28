<?php include('header.php'); ?>
<?php include('register-parse.php') ?>

   <main>
       <div class="register">
           <section class="inputContainer">
               <h1>Create an Account</h1>
               <p>Sign up to begin posting</p>

               <?php show_feedback( $feedback, $errors ); ?>
               <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                   <label for="the_username">Choose a Username</label><br>
                   <span class="hint">Username must be under 40 characters</span>
                   <input type="text" name="username" required maxlength="40" id="the_username">

                   <label for="the_email">Email Address</label>
                   <input type="email" name="email" id="the_email" required>

                   <label for="the_password">Password</label><br>
                   <span class="hint">Password must be at least 8 characters long</span>
                   <input type="password" name="password" id="the_password" required>

                   <label for="">
                       <input type="checkbox" name="policy" value="1">
                       Yes, I agree to the <a href="privacy.php" id="tos">terms of service.</a>
                   </label>
                   <input type="submit" value="Register">
                   <input type="hidden" name="did_register" value="1">
               </form>
               <div class="row loginreg">
                   <p class="col-xs-6 col-sm-6 col-md-6"><a href="login.php">LOGIN</a></p>
                   <p class="col-xs-6 col-sm-6 col-md-6"><a href="register.php">REGISTER</a></p>
               </div>

           </section>


       </div>
   </main>
<?php include('footer.php'); ?>
</div>


<script src="layout.js"></script>
</body>
</html>