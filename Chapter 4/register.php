<?php

include 'function.php';

error_reporting(0);

session_start();

if (isset($_SESSION['email'])) {
    header("Location:login.php");
}

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);

    if ($password == $cpassword) {
        $sql = "SELECT * FROM login WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO login (email, password)
					VALUES ('$email', '$password')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                echo "<script>alert('Wow! User Registration Completed.')</script>";
                $email = "";
                $_POST['password'] = "";
                $_POST['cpassword'] = "";
            } else {
                echo "<script>alert('Woops! Something Wrong Went.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Already Exists.')</script>";
        }
    } else {
        echo "<script>alert('Password Not Matched.')</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/register.css">

    <title>Register Form </title>
</head>

<body>
    <div class="login-page">
        <div class="form">
            <form action="" method="POST" class="login-email">
                <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>
                <input type="text" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
                <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
                <button name="submit" class="btn">Register</button>
                <p class="login-register-text">Have an account? <a href="login.php">Login Here</a>.</p>
            </form>
            </form>
        </div>
    </div>

</body>

</html>
