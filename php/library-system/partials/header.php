<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIBSYS - Library System</title>

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" 
    />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <style>
        .avatar {
            width: 8rem;
        }

        .profile {
            width: 50%;
        }

        .cards {
            width: 50%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        @media (max-width: 992px) {
            .profile {
                width: 100%;
            }
            
            .cards {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold text-uppercase" href="home.php">LIBSYS</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto text-center">
                    <?php                     
                    if (isset($_SESSION["user"])) {
                        echo "<li class='nav-item'>
                                  <a class='nav-link' href='home.php'>Home</a>
                              </li>
                              <li class='nav-item'>
                                  <a class='nav-link' href='members.php'>Members</a>
                              </li>
                              <li class='nav-item'>
                                  <a class='nav-link' href='books.php'>Books</a>
                              </li>
                              <li class='nav-item'>
                                  <a class='nav-link' href='checkouts.php'>Checkouts</a>
                              </li>
                              <li class='nav-item'>
                                  <a class='nav-link' href='auth/logout.php'>Log out <i class='bi bi-box-arrow-in-left'></i></a>
                              </li>";
                    } else {
                        echo "<li class='nav-item'>
                                  <a class='nav-link' href='login.php'>Log in <i class='bi bi-box-arrow-in-right'></i></a>
                              </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>