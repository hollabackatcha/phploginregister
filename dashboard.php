<?php
require 'connection.php';
session_start();
if (!isset($_SESSION['login'])) {
    header('location: index.php');
}
class TableRows extends RecursiveIteratorIterator
{
    function __construct($it)
    {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current()
    {
        return "<td>" . parent::current() . "</td>";
    }

    function beginChildren()
    {
        echo "<tr>";
    }

    function endChildren()
    {
        echo "</tr>\n";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Operation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <div class="container">
        <H1 class="my-3">Dashboard</H1>
        <button class="btn btn-danger my-5 mr-3"><a href="logout.php" class="text-light"> Log Out</a>
        </button>
        <button class="btn btn-danger my-5 mr-3"><a href="passwordreset.php" class="text-light"> Reset Password</a>
        </button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.N</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Password</th>
                    <th scope="col">Expiry Date</th>
                </tr>
            </thead>
            <?php
            $sql = $connection->prepare("SELECT * FROM registertable");
            $sql->execute();

            $result = $sql->setFetchMode(PDO::FETCH_ASSOC);
            try {
                foreach (new TableRows(new RecursiveArrayIterator($sql->fetchAll())) as $k => $v) {
                    echo $v;
                }
            } catch (PDOException $e) {
                $message = $e->getMessage();
                echo "Couldn't fetch data: $message";
            }

            ?>
        </table>
    </div>
</body>

</html>