<?php
/* === DEVELOPER BEGIN */
/**
 *  @desc Visualizza il form di login.
 *
 *  @status 0 
 */
/* === DEVELOPER END */
?>
<?php require __DIR__ . '/partials/' . 'header.php'; ?>

<?php require __DIR__ . '/partials/' . 'menu.php'; ?>

<div class="contaner-fluid bg-light">
  <div class="container py-5">
    <div class="row">
      <div class="col-4 offset-4">
        
        <div class="card">
        <article class="card-body">
        	<h4 class="card-title text-center mb-4 mt-1">Sign in</h4>
        	<hr>
        	<p class="text-success text-center">Some message goes here</p>
        	<form>
        	<div class="form-group">
        	<div class="input-group">
        		<div class="input-group-prepend">
        		    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
        		 </div>
        		<input name="" class="form-control" placeholder="Email or login" type="email">
        	</div> <!-- input-group.// -->
        	</div> <!-- form-group// -->
        	<div class="form-group">
        	<div class="input-group">
        		<div class="input-group-prepend">
        		    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
        		 </div>
        	    <input class="form-control" placeholder="******" type="password">
        	</div> <!-- input-group.// -->
        	</div> <!-- form-group// -->
        	<div class="form-group">
        	<button type="submit" class="btn btn-primary btn-block"> Login  </button>
        	</div> <!-- form-group// -->
        	<p class="text-center"><a href="#" class="btn">Forgot password?</a></p>
        	</form>
        </article>
        </div> <!-- card.// -->
      
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/partials/' . 'footer.php'; ?>