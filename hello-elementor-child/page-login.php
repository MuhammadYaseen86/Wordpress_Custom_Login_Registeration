<?php get_header(); ?>
<div class="container">
    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
        <p id="profile-name" class="profile-name-card"></p>
        <form name="loginform" id="loginform" method="post"> 
			<div class="form-group">
		      	<label class="login" for="user_email">Email address</label>
		      	<input id="user_email" type="text" size="20" value="" name="user_email" class="form-control">
		    </div>
		    <div class="form-group tkdf-pass-group">
			    <label class="login" for="user_pass">Password:</label>
			    <span class="tkdf-left-icon">
			      	<img src="<?php echo esc_url($flag_url); ?>"> 
			    </span>
			    <input id="user_pass" type="password" class="form-control tkdf-pass-field" name="user_pass" >
	         	<span toggle="#password-field" class="fa fa-fw fa-eye toggle-password"></span>
		    </div>
		    <div class="tkdf-login-checkbox">
		    	<input id="checkboxG5" type="checkbox" value="forever" name="rememberme" class="css-checkbox"/>
				<label for="checkboxG5" class="css-label">
					<span class="tkdf-login-sign-text">Keep me signed in</span>
				</label>
		    </div>
		    <input type="hidden" value="<?php echo get_site_url() . '/dashboard'; ?>" name="redirect_to" id="redirect_url">
			<input type="hidden" value="1" name="testcookie">
		    <button id="wp-submit" type="submit" value="Login" name="wp_submit" class="btn btn-lg tkdf-login-btn">Log in</button>
  		</form>
        <span class="login-footer">If you don't have an account so <a href="<?php echo get_site_url() . '/signup' ?>" class="forgot-password">Signup</a></span>
    </div>
</div>

<?php echo do_shortcode('[prayer_times]'); ?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<?php get_footer(); ?>