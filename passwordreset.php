<?php
session_start();
require 'connection.php';
if (!isset($_SESSION['username'])) {
    header('location: index.php');
}
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Your Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .center {
            width: 50%;
            height: 80%;
            margin: 30vh auto;
        }

        .input-container {
            margin: 25px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="center">
        <h3>
            Hello <?php echo $username; ?>, you've requested to reset your password. Please enter a new
            password for your account.
        </h3>
        <form method="POST" class="needs-validation" novalidate>
            <div class="input-container has-validation">
                <input id="input_pwd" type="password" name="password" class="form-control" placeholder="Password" pattern="^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,}$" required />
                <div class="input-container invalid-feedback">
                    Your password must be minimum 8 characters and have at least one
                    small letter, capital letter, special & numeric characters.
                </div>
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="input-container has-validation">
                <input type="password" id="input_cnfm-pwd" class="form-control" name="password-cnfm" placeholder="Confirm Password" required />
                <div class="invalid-feedback">Passwords do not match.</div>
                <div class="valid-feedback">Looks good!</div>
            </div>
            <div class="input-container">
                <button class="btn btn-dark" type="submit">Submit</button>
            </div>
        </form>
    </div>
    <script>
        (function() {
            "use strict";

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll(".needs-validation");

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms).forEach(function(form) {
                form.addEventListener(
                    "submit",
                    function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        form.classList.add("was-validated");
                    },
                    false
                );
            });
        })();

        document
            .querySelector("input#input_cnfm-pwd")
            .addEventListener("input", (event) => {
                password = document.getElementById("input_pwd").value;
                if (event.target.value === password) {
                    event.target.setCustomValidity("");
                } else {
                    event.target.setCustomValidity("Passwords don't match.");
                }
            });
    </script>
    <?php
    if (isset($_POST['password'])) {
        $username = $_SESSION['username'];
        $password = $_POST['password'];
        if ($password === $_SESSION['password']) {
            echo "<div class='error'>New password can't be old password.</div>";
        } else {
            $pwd = password_hash($password, PASSWORD_DEFAULT);
            $datetime = date_add(new DateTime('now'), date_interval_create_from_date_string("60 days"))->format('Y-m-d H:i:s');

            try {
                $sql = $connection->prepare("UPDATE registertable SET password = ?, expiry_date = ? WHERE username = ? ;");
                $sql->bindParam(1, $pwd, PDO::PARAM_STR);
                $sql->bindParam(2, $datetime, PDO::PARAM_STR);
                $sql->bindParam(3, $username, PDO::PARAM_STR);
                $sql->execute();
                echo "DONE";
                session_destroy();
                header('location: index.php');
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    ?>
</body>

</html>