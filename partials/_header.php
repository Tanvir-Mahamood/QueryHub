<?php 
session_start();

echo '<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">QueryHub</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Top category
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">';
            
            $sql = "SELECT category_name, category_id FROM `categories` LIMIT 3";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)) {
              echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
            }
            echo '</ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>';

      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '<form class="d-flex" role="search" mathod="get" action="search.php">
        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCategory">Add Category</button>
        <p class="text-light my-0 mx-2">Welcome '.$_SESSION['username'].'</p>
        <a href="partials/_logout.php" class="btn btn-success" data-bs-target="#loginModal">Logout</a>';
      }
      else {
        echo '<div class="mx-2">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>';
      }

      echo '</div>
    </div>
  </div>
</nav>';


include 'partials/_loginmodal.php';
include 'partials/_signupmodal.php';
include 'partials/_addcategory.php';


if(isset($_GET['signupResponse']) && $_GET['signupResponse'] == 1) {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Signup Complete! </strong> You can login now.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}
if(isset($_GET['loginResponse']) && $_GET['loginResponse'] == 1) {
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Login Complete! </strong> Enjoy.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
}

?>