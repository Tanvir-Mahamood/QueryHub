<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <div class="container" style="margin: 30px;">
        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png" width="34px" class="mr-3" alt="...">
        <?php
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { // if you are logged in
                $user_id = $_GET['user_id'];
                //echo $user_id;

                echo "<br><b>User Information:</b><br>";
                $sql = "SELECT * FROM `users` WHERE sno = $user_id";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                echo "<u>Username:</u> ".$row['user_name']."<br>";
                if($_SESSION['sno'] == $row['sno']) echo "<u>Email:</u>    ".$row['user_email']."<br>"; // email security
                echo "<u>Joint</u>:    ".$row['timestamp']."<br><br>";

                echo "<hr><br><br><b>Threads:</b><br>";
        
                echo '<table class="table table-striped table-bordered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>title</th>';
                echo '<th>Description</th>';
                echo '<th>Date</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $sql = "SELECT * FROM `threads` WHERE thread_user_id = $user_id ";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row["thread_title"] . '</td>';
                    echo '<td>' . $row["thread_desc"] . '</td>';
                    echo '<td>' . $row["timestamp"] . '</td>';
                    echo '</tr>';

                }
                echo '</tbody>';
                echo '</table>';



                echo "<hr><br><br><b>Comments:</b><br>";

                echo '<table class="table table-striped table-bordered">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Comment</th>';
                echo '<th>Date</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                $sql = "SELECT * FROM `comments` WHERE comment_by = $user_id ";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row["comment_content"] . '</td>';
                    echo '<td>' . $row["comment_time"] . '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';

            }
            else echo "Please log in to continue.";
        ?>

    </div>
    
    <?php include 'partials/_footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>