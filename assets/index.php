<?php
    include('includes/connection.php');
    session_start();
    if(!isset($_GET['change'])){
        if(isset($_SESSION['community'])){
            header('Location: main.php');
            exit();
        }
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Scrollable List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/fontawesome.min.css"
    integrity="sha384-jLKHWM3JRmfMU0A5x5AkjWkw/EYfGUAGagvnfryNV3F9VqM98XiIH7VBGVoxVSc7" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .carousel-item {
            height: 500px; /* set the desired height for the carousel item */
            overflow: hidden; /* hide any content that exceeds the height */
        }

        .carousel-item img {
            width: 100%; /* make the image fill the width of the carousel item */
            height: 100%; /* make the image fill the height of the carousel item */
            object-fit: contain; /* maintain aspect ratio and fit the image within the carousel item */
        }
    </style>
</head>
<body>
    <div class="container my-5">
    <?php
        $sql = "SELECT * FROM Community";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            // Handle the error, e.g., display an error message
            echo "Error executing the query: " . mysqli_error($conn);
            return;
        }

        $carouselItems = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $carouselItems[] = array(
                'c_id' => $row['id'],
                'thumb' => $row['thumb'],
                'name' => $row['name'],
                'description' => $row['description']
            );
        }
        ?>

        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php foreach ($carouselItems as $i => $item) : ?>
                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?= $i ?>" <?= $i == 0 ? 'class="active" aria-current="true"' : '' ?> aria-label="Slide <?= $i ?>"></button>
                <?php endforeach; ?>
            </div>

            <div class="carousel-inner">
                <?php foreach ($carouselItems as $i => $item) : ?>
                    <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>" data-bs-interval="<?= $i == 0 ? '10000' : '3000' ?>">
                    <a href="selectedCommunity.php?c_id=<?php echo $item['c_id']; ?>">
                        <img src="dashboard-ui/dist/imgs/community/<?= htmlspecialchars($item['thumb']) ?>" class="d-block w-100" alt="...">
                    </a>
                        <div class="carousel-caption d-none d-md-block" style="background-color:white;display:block;max-width:fit-content;margin:auto;padding:20px 80px;">
                            <h5><?= htmlspecialchars($item['name']) ?></h5>
                            <p><?= htmlspecialchars($item['description']) ?>.</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>
</body>
</html>