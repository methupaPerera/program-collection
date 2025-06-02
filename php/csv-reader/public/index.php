<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transactions</title>

    <style>
        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border: 2px solid gray;
            border-collapse: collapse;
            text-align: center;
        }

        table tr th,
        table tr td {
            padding: 5px;
            border: 2px solid gray;
            padding: 0.5rem;
        }

        tfoot tr th,
        tfoot tr td {
            font-size: 20px;
        }

        tfoot tr th {
            text-align: right;
        }
    </style>
</head>

<body>
    <h1>CSV File Reader</h1>

    <?php

    $root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

    define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
    define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
    define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

    include APP_PATH . "app.php";
    include VIEWS_PATH . "transactions.php";

    ?>
</body>

</html>