<?php
    $insert = false;
    $update = false;
    $delete = false;
    $threadid = $_GET['threadid'];

    include 'partials/_dbconnect.php'; // connection
    include 'partials/_header.php';
    $user_sno = 0;
    if(isset($_SESSION['sno'])) $user_sno =  $_SESSION['sno']; // got the logged in user

    if(isset($_GET['delete'])) {
        $sno = $_GET['delete']; // sno = comment unique id
        $delete = true;

        $sql = "DELETE FROM `comments` WHERE `comments`.`comment_id` = $sno"; // delete comment
        $result = mysqli_query($conn, $sql);
    }

    // collecting information to insert in the database
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset( $_POST['snoEdit'] )) { // update the comment
            $sno = $_POST['snoEdit']; // unique id of comment
            $upComment = $_POST["titleEdit"]; // comment

            if($sno != NULL) { // if nothing is selected, then do not update
                $sql = "UPDATE `comments` SET `comment_content` = '$upComment' WHERE `comments`.`comment_id` = $sno";
                $result = mysqli_query($conn, $sql);
                
                if($result) $update = true;
                else echo "Failed to update <br>";
            }
        }
        else if(isset( $_POST['sno'] )) { // insert record
            $comment = $_POST['comment'];

            $comment = str_replace("<", "&lt;", $comment);
            $comment = str_replace(">", "&gt;", $comment);

            $sno = $_POST['sno'];

            $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$threadid', '$sno', current_timestamp())";
            $result = mysqli_query($conn, $sql);
            
            if($result) $insert = true;
            else echo "Cannot add the comment";
        }
    }
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QueryHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit this comment</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php echo '<form action="/forum/thread.php?threadid='.$threadid.'" method="post">'; ?>
                    <div class="modal-body">

                        <input type="hidden" id="snoEdit" name="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Comment</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit"
                                aria-describedby="emailHelp">
                        </div>
                    </div>
                    <div class="modal-footer d-block mr-auto">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
    if($insert == true) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong> Your comment has been inserted.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    else if($update == true) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong> Your comment has been updated.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    else if($delete == true) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong> Your comment has been deleted.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <?php 
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `threads` WHERE thread_id = $id";
        $result = mysqli_query($conn, $sql);
        
        while($row = mysqli_fetch_assoc($result)) {
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $desc = $row['thread_desc'];
            $thread_user_id = $row['thread_user_id'];

            $sql2 = "SELECT user_name FROM `users` WHERE sno = $thread_user_id";
            $result2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_assoc($result2);

            $posted_by = $row2['user_name'];
        }
    ?>

    <?php 
        // $showAlert = false;
        // $method = $_SERVER['REQUEST_METHOD'];
        // if($method == 'POST') {
        //     // insert into comments db
        //     $comment = $_POST['comment'];

        //     $comment = str_replace("<", "&lt;", $comment);
        //     $comment = str_replace(">", "&gt;", $comment);

        //     $sno = $_POST['sno'];

        //     $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '$sno', current_timestamp())";
        //     $result = mysqli_query($conn, $sql);
        //     $showAlert = true;
        //     if($showAlert) {
        //         echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        //             <strong>Success! </strong> Your comment has been added.
        //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        //             </div>';
        //     }
        // }
    ?>

    <!-- category container starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title; ?> forums</h1>
            <p class="lead"> <?php echo $desc; ?> </p>
            <p>Posted by <b><?php echo $posted_by; ?></b></p>
            <hr class="my-4">
            <p>Never post personal information about another forum participant. Don't post anything that threatens or
                harms the reputation of any person or organization.
                Don't post anything that could be considered intolerant of a person's race, culture, appearance, gender,
                sexual preference, religion or age.</p>
        </div>
    </div>

    <?php 

    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '<div class="container">
                <h1 class="py-2">Post a comment</h1>

                <form action=" '.$_SERVER["REQUEST_URI"].' " method="post">

                <div class="form-group">
                    <label for="" class="exampleformControlTextarea1">Type your comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                    <input type="hidden" name="sno" value="'.$_SESSION["sno"].'">
                </div>
                <button type="submit" class="btn btn-success">Post Comment</button>
                 </form>
            </div>';
    }
    else {
        echo '<div class="container">
                <h1 class="py-2">Post a comment</h1>
                <p class="lead">Please log in to comment</p>
            </div>';
    }
    
    ?>

    <div class="container">
        <h1 class="py-3">Discussion</h1>

        <?php 
            $id = $_GET['threadid'];
            $sql = "SELECT * FROM `comments` WHERE thread_id = $id";
            $result = mysqli_query($conn, $sql);
            $noresult = true;

            while($row = mysqli_fetch_assoc($result)) {
                $noresult = false;
                $id = $row['comment_id']; // unique comment id
                $content = $row['comment_content'];
                $comment_time = $row['comment_time'];

                $comment_user_id = $row['comment_by']; // commenter unique id
                $sql2 = "SELECT user_name FROM `users` WHERE sno = $comment_user_id";
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);

                if(isset($_SESSION['loggedin']) && $_SESSION['sno'] == $comment_user_id) {
                    echo '
                    <div class="media my-3">
                        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png"
                            width="34px" class="mr-3" alt="...">
                        <div class="media-body">
                            <p class="my-0"><b><a href="profile.php?user_id='.$comment_user_id.'">'.$row2['user_name'].'</a></b> on '.$comment_time.'
                                <button class="edit btn btn-outline-success" id='.$id.'>Select</button> 
                                <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                                <button class="delete btn btn-outline-danger" id=d'.$id.'>Delete</button> <br>
                                <h6>'.$content.'</h6>
                            </p>
                            
                        </div>
                    </div>';
                }
                else {
                    echo '
                    <div class="media my-3">
                        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png"
                            width="34px" class="mr-3" alt="...">
                        <div class="media-body">
                        <p class="my-0"><b><a href="profile.php?user_id='.$comment_user_id.'">'.$row2['user_name'].'</a></b> at '.$comment_time.'
                            
                        </p>
                            '.$content.'
                        </div>
                    </div>';
                }
            }
            if($noresult) {
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">No comment found</p>
                            <p class="lead">Be the first person to comment.</p>
                        </div>
                    </div>';
            }
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


    <script>
        edits = document.getElementsByClassName('edit'); // if select button is pressed, then
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                //console.log("edit ", e.target.parentNode.parentNode);
                tr = e.target.parentNode.parentNode;
                //console.log(tr.getElementsByTagName("h6")[0].innerText);
                comment = tr.getElementsByTagName("h6")[0].innerText;
                //console.log(comment, e.target.id);

                titleEdit.value = comment;
                snoEdit.value = e.target.id; // comment unique id
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                sno = e.target.id.substr(1,); // which comment
                var threadID = "<?php echo $threadid; ?>"; //from  which thread?

                if (confirm("Are you sure to delete this note?")) {
                    console.log("yes");
                    window.location = `/forum/thread.php?delete=${sno}&threadid=${threadID}`; // sno = thread unique id
                }
                else console.log("no");
            })
        })
    </script>
    
    <!--Prevet Resubmission from page reload-->
    <script>
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</body>
</html>