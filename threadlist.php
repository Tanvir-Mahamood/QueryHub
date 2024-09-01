<?php
    $insert = false;
    $update = false;
    $delete = false;
    $catID = $_GET['catid'];

    include 'partials/_dbconnect.php'; // connection
    include 'partials/_header.php';
    $user_sno = 0;
    if(isset($_SESSION['sno'])) $user_sno =  $_SESSION['sno']; // got the logged in user

    if(isset($_GET['delete'])) {
        $sno = $_GET['delete']; // sno = thread unique id
        /*echo $sno;*/
        $delete = true;

        $sql = "DELETE FROM `comments` WHERE `comments`.`thread_id` = $sno"; // delete comment
        $result = mysqli_query($conn, $sql);

        $sql = "DELETE FROM `threads` WHERE `threads`.`thread_id` = $sno"; // delete thread
        $result = mysqli_query($conn, $sql);
    }

    // collecting information to insert in the database
    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        if(isset( $_POST['snoEdit'] )) { // update the record
            $sno = $_POST['snoEdit'];
            $title = $_POST["titleEdit"];
            $description = $_POST["descriptionEdit"];

            if($sno != NULL) { // if nothing is selected, then do not update
                $sql = "UPDATE `threads` SET `thread_title` = '$title', `thread_desc` = '$description' WHERE `threads`.`thread_id` = $sno";
                $result = mysqli_query($conn, $sql);
                
                if($result) $update = true;
                else echo "Failed to update <br>";
            }
        }
        else if(isset( $_POST['sno'] )) { // insert record
            $th_title = $_POST['title'];
            $th_desc =  $_POST['desc'];
            $sno = $_POST['sno'];

            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES 
            ('$th_title', '$th_desc', '$catID', '$sno', current_timestamp())";
            $result = mysqli_query($conn, $sql);

            if($result) $insert = true;
            else echo "Failed to insert <br>";
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
                    <h1 class="modal-title fs-5" id="editModalLabel">Edit this note</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php echo '<form action="/forum/threadlist.php?catid='.$catID.'" method="post">'; ?>
                    <div class="modal-body">

                        <input type="hidden" id="snoEdit" name="snoEdit">
                        <div class="mb-3">
                            <label for="title" class="form-label">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit"
                                aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for="desc">Note Description</label>
                            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit"
                                rows="3"></textarea>
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
          <strong>Success! </strong> Your thread has been inserted.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    else if($update == true) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong> Your thread has been updated.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    else if($delete == true) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success! </strong> Your thread has been deleted.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <?php 
        $id = $_GET['catid'];
        //$id = $catID;
        $sql = "SELECT * FROM `categories` WHERE category_id = $id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $catname = $row['category_name'];
            $catdesc = $row['category_description'];
        }
    ?>

    <?php 
        // $showAlert = false;
        // $method = $_SERVER['REQUEST_METHOD'];
        // //echo $method;
        // if($method == 'POST') {
        //     // insert threads into db
        //     $th_title = $_POST['title'];
        //     $th_desc =  $_POST['desc'];
        //     $sno = $_POST['sno'];

        //     $sql = "INSERT INTO `threads` (`thread_id`, `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES 
        //     (NULL, '$th_title', '$th_desc', '$id', '$sno', current_timestamp())";
        //     $result = mysqli_query($conn, $sql);
        //     $showAlert = true;
        //     if($showAlert) {
        //         echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        //             <strong>Success! </strong> Your thread has been added. Please wait for community to response.
        //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        //             </div>';
        //     }
        // }
    ?>

    <!-- category container starts here -->
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> forums</h1>
            <p class="lead"> <?php echo $catdesc; ?> </p>
            <hr class="my-4">
            <p>Never post personal information about another forum participant. Don't post anything that threatens or
                harms the reputation of any person or organization.
                Don't post anything that could be considered intolerant of a person's race, culture, appearance, gender,
                sexual preference, religion or age.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>

    <?php 
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '<div class="container">
            <h1 class="py-2">Start a discussion</h1>

            <form action="'.$_SERVER["REQUEST_URI"].' " method="post">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Problem Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible</div>
                </div>
                    <input type="hidden" name="sno" value="'.$_SESSION['sno'].'">
                <div class="form-group">
                    <label for="" class="exampleformControlTextarea1">Ellaborate your concern</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>';
    }
    else {
        echo '<div class="container">
                <h1 class="py-2">Start a discussion</h1>
                <p class="lead">Please log in to ask</p>
            </div>';
    }
    ?>

    <!--CRUD Button functionality-->
    <div class="container">
        <h1 class="py-3">Browse Question</h1>

        <?php 
            $id = $_GET['catid'];
            $sql = "SELECT * FROM `threads` WHERE thread_cat_id = $id";
            $result = mysqli_query($conn, $sql);
            $noresult = true;

            while($row = mysqli_fetch_assoc($result)) {
                $noresult = false;
                $id = $row['thread_id']; // unique id of thread
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_time = $row['timestamp'];

                $title  = str_replace("<", "&lt;", $title);
                $title  = str_replace(">", "&gt;", $title );

                $desc = str_replace("<", "&lt;", $desc);
                $desc = str_replace(">", "&gt;", $desc);

                $thread_user_id = $row['thread_user_id']; // unique id for thread writer
                $sql2 = "SELECT user_name FROM `users` WHERE sno = $thread_user_id"; // finding the thread writer name
                $result2 = mysqli_query($conn, $sql2);
                $row2 = mysqli_fetch_assoc($result2);

                if(isset($_SESSION['loggedin']) && $_SESSION['sno'] == $thread_user_id) {
                    echo '
                    <div class="media my-3">
                        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png"
                            width="34px" class="mr-3" alt="..."> 
                        <div class="media-body">
                            <h6 class="my-0"><b><a href="profile.php?user_id='.$thread_user_id.'">'.$row2['user_name'].'</a></b> on '.$thread_time.' . Options:
                            <button class="edit btn btn-outline-success" id='.$id.'>Select</button> 
                            <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editModal">Edit</button>
                            <button class="delete btn btn-outline-danger" id=d'.$id.'>Delete</button> </h6>
                            <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
                            <h5>'.$desc.'</h5>
                        </div>
                    </div>';
                }
                else {
                    echo '
                    <div class="media my-3">
                        <img src="https://w7.pngwing.com/pngs/178/595/png-transparent-user-profile-computer-icons-login-user-avatars-thumbnail.png"
                            width="34px" class="mr-3" alt="..."> 
                        <div class="media-body">
                            <h6 class="my-0"><b><a href="profile.php?user_id='.$thread_user_id.'">'.$row2['user_name'].'</a></b> at '.$thread_time.'</h6>
                            <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='.$id.'">'.$title.'</a></h5>
                            '.$desc.'
                        </div>
                    </div>';
                }
            }

            if($noresult) {
                echo '<div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">No result found</p>
                            <p class="lead">Be the first person to ask a question.</p>
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
                //console.log(tr.getElementsByTagName("h5")[0].getElementsByTagName("a")[0].innerText);
                //console.log(tr.getElementsByTagName("h5")[1].innerText);
                threadTitle = tr.getElementsByTagName("h5")[0].getElementsByTagName("a")[0].innerText;
                threadDescription = tr.getElementsByTagName("h5")[1].innerText;
                //console.log(threadTitle, threadDescription, e.target.id);

                titleEdit.value = threadTitle;
                descriptionEdit.value = threadDescription;
                snoEdit.value = e.target.id; // thread unique id
                //console.log(e.target.id);
            })
        })

        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                sno = e.target.id.substr(1,);
                //console.log(sno);
                var catID = "<?php echo $catID; ?>";

                if (confirm("Are you sure to delete this note?")) {
                    console.log("yes");
                    window.location = `/forum/threadlist.php?delete=${sno}&catid=${catID}`; // sno = thread unique id
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