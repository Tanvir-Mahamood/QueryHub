<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QueryHub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
        integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous">
    </script>

    <style>
        #maincontainer {
            min-height: 78vh;
        }
    </style>
</head>

<body>
    <?php include 'partials/_dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    <!-- search result stars here -->
    <!--
        search technique in mysql:
            alter table threads add FULLTEXT(`thread_title`, `thread_desc`);
            SELECT * FROM threads WHERE MATCH(thread_title, thread_desc) AGAINST ('your query')
    -->
    
    <div class="container my-3" id="maincontainer">
        <?php 
            $noresult = true;
            $searchQuery = $_GET['search'];
            echo ' <h1 class="py-2">Search result for <em>"'.$searchQuery.'"</em></h1>';
            $sql = "SELECT * FROM threads WHERE MATCH(thread_title, thread_desc) AGAINST ('$searchQuery')";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)) {
                $noresult = false;
                $title = $row['thread_title'];
                $desc = $row['thread_desc'];
                $thread_id = $row['thread_id'];
                $url = "thread.php?threadid=".$thread_id;

                echo '
                    <div class="result">
                        <h3><a href="'.$url.'" class="text-dark">'.$title.'</a></h3>
                        <p>'.$desc.'</p>
                    </div>';
            }
            if($noresult) {
                echo '
                    <div class="jumbotron jumbotron-fluid bg-secondary">
                        <div class="container">
                            <p class="display-4">No result found</p>
                            <p class="lead">Suggestions:<ul>
                            <li >Make sure that all words are spelled correctly.</li>
                            <li> Try different keywords.</li>
                            <li> Try more general keywords.</li>
                            <li> Try fewer keywords.</p></li>
                            </ul>
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
</body>

</html>