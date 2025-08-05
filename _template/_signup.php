<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<?php
$signup=false;
if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email_address']) && !empty($_POST['phonenumber']))
{
$username=$_POST['username'];
$password=$_POST['password'];
$email=$_POST['email_address'];
$phonenumber=$_POST['phonenumber'];
$error=user::signup($username,$password,$email,$phonenumber);
$signup=true;
}
?>
<?php
   if($signup){
      if (!$error)
 {
        ?> 
  <main class="container">
  <div class="bg-light p-5 rounded mt-3">
    <h1>signup success</h1>
    <p class="lead">Now you can login form<a href="<?=get_config('base_path')?>login.php">here</a>.</a>.</p>
  </div>
</main>
  <?php
      } else {
        ?>
     <main class="container">
        <div class="bg-light p-5 rounded mt-3">
          <h1>signup failed</h1>
            <p class="lead">Something went wrong, <?=$error?></p>
        </div>
      </main>
<?php
      }
  }else{
    ?>

<main class="form-signin w-100 m-auto"> 
    <form method="post" action="signup.php">
         <img class="mb-4" src="https://labs.selfmade.ninja/assets/brand/logo-text-opt.svg" alt="" height="50"> 
        <h1 class="h3 mb-3 fw-normal">Please signup</h1>
    <div class="form-floating"> 
        <input name="username" type="text" class="form-control" id="floatingInputUsername" placeholder="username"> 
        <label for="floatingInputUsername">username</label> 
    </div>
        <div class="form-floating">
         <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">         
         <label for="floatingPassword">Password</label>
    </div>
        <div class="form-floating"> 
        <input name="email_address" type="email" class="form-control" id="floatingInput" placeholder="name@example.com"> 
        <label for="floatingInput">Email address</label> 
    </div> 
    <div class="form-floating"> 
        <input name="phonenumber" type="text" class="form-control" id="floatingInputphone" placeholder="phonenumber"> 
        <label for="floatingInputphonenumber">phonenumber</label> 
    </div>



            <button class="btn btn-primary w-100 py-2 hvr-back-pulse" type="submit">Sign in</button> 
        </form> 
</main>

<?php
}
?>
