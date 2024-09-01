<?php 
    $showError = "false";
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include '_dbconnect.php';

        $addCatname = $_POST['addCategoryName'];
        $addcatDesc = $_POST['addCategoryDesc'];

        $sql = "SELECT * FROM `categories` WHERE category_name = '$addCatname'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);

        if($numRows == 0) { // its a new category
            // add this category in database
            $sql = "INSERT INTO `categories` (`category_name`, `category_description`, `created`) VALUES ('$addCatname', '$addcatDesc', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            header("Location: /forum/index.php");
        }
        header("Location: /forum/index.php");
    }
?>