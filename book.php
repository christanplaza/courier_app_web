<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>book</title>

   <!-- swiper css link  -->
   <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <!-- CSS only -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

   <!-- header section starts  -->

   <section class="header">

      <a href="index.php" class="logo nav-link">CF Transport</a>

      <nav class="navbar">
         <a class="nav-link" href="index.php">home</a>
         <a class="nav-link" href="about.php">about</a>
         <a class="nav-link" href="package.php">package</a>
         <a class="nav-link" href="book.php">book</a>
         <a class="nav-link" href="login.php">admin panel</a>
      </nav>

      <div id="menu-btn" class="fas fa-bars"></div>

   </section>

   <!-- header section ends -->

   <div class="heading" style="background:url(images/header-bg-3.png) no-repeat">
      <h1>Request now</h1>
   </div>

   <!-- booking section starts  -->

   <section class="booking">

      <h1 class="heading-title">Request for delivery!</h1>

      <?php if (isset($_SESSION['msg_type']) && isset($_SESSION['flash_message'])) : ?>
         <div class="alert alert-<?php echo $_SESSION["msg_type"]; ?> alert-dismissible fade show fs-1" role="alert">
            <?php echo $_SESSION["flash_message"]; ?>
         </div>
      <?php endif; ?>
      <?php unset($_SESSION['msg_type']);
      unset($_SESSION['flash_message']); ?>
      <form action="book_form.php" method="post" class="book-form">

         <div class="flex">
            <div class="inputBox">
               <span>name :</span>
               <input type="text" placeholder="enter your name" name="name" required>
            </div>
            <div class="inputBox">
               <span>email :</span>
               <input type="email" placeholder="enter your email" name="email" required>
            </div>
            <div class="inputBox">
               <span>phone :</span>
               <input type="number" placeholder="enter your number" name="contact_number" required>
            </div>
            <div class="inputBox">
               <span>pickup address :</span>
               <input type="text" placeholder="enter your pickup address" name="pickup_address" required>
            </div>
            <div class="inputBox">
               <span>delivery address :</span>
               <input type="text" placeholder="enter your delivery address" name="delivery_address" required>
            </div>
            <div class="inputBox">
               <span>note :</span>
               <input type="text" placeholder="delivery notes" name="note" required>
            </div>
            <div class="inputBox">
               <span>description :</span>
               <input type="text" placeholder="your order description" name="description" required>
            </div>
         </div>

         <input type="submit" value="submit" class="btn w-100 btn-dark fs-1" name="send">

      </form>

   </section>

   <!-- booking section ends -->


   <!-- footer section starts  -->

   <section class="footer">

      <div class="box-container">

         <div class="box">
            <h3>quick links</h3>
            <a href="index.php"> <i class="fas fa-angle-right"></i> home</a>
            <a href="about.php"> <i class="fas fa-angle-right"></i> about</a>
            <a href="package.php"> <i class="fas fa-angle-right"></i> package</a>
            <a href="book.php"> <i class="fas fa-angle-right"></i> book</a>
         </div>

         <div class="box">
            <h3>contact info</h3>
            <a href="#"> <i class="fas fa-phone"></i> 09123456789 </a>
            <a href="#"> <i class="fas fa-phone"></i> 09987654321 </a>
            <a href="#"> <i class="fas fa-envelope"></i> MIR4Trucking@gmail.com </a>
            <a href="#"> <i class="fas fa-map"></i> Negros Occidental, Bacolod City - 6100 </a>
         </div>

      </div>

      <div class="credit"> created by <span>Y. Carl & L. France</span> | all rights reserved! </div>

   </section>

   <!-- footer section ends -->

   <!-- swiper js link  -->
   <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

   <!-- custom js file link  -->
   <script src="js/script.js"></script><!-- JavaScript Bundle with Popper -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>