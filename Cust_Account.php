<?php
include 'components/sessionstart.php';
include 'cursor.php';
include 'header_User.php';

$message = [];
$message_class = "";

// login
if(isset($_POST['login_submit'])){
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `customer` WHERE CustEmail = ? AND CustPass = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $_SESSION['CustID'] = $row['CustID'];
        header('Location: home.php'); // Check the file path
        exit();
    } else {
       $message[] = 'Incorrect username or password!';
       $message_class = "error";
    }
}

// register
if(isset($_POST['register_submit'])){
    $username = $_POST['username'];
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $retypepass = $_POST['retypepass'];

    // Check if passwords match
    if($pass !== $retypepass){
        $message[] = 'Passwords do not match!';
        $message_class = "error";
    } else {
        $pass = sha1($pass);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $select_user = $conn->prepare("SELECT * FROM `customer` WHERE CustUsername = ? OR CustEmail = ?");
        $select_user->execute([$username, $email]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if($select_user->rowCount() > 0){
            $message[] = 'Username or email already exists!';
            $message_class = "error";
        } else {
            $insert_user = $conn->prepare("INSERT INTO `customer`(CustUsername, CustEmail, CustPass) VALUES(?,?,?)");
            $insert_user->execute([$username, $email, $pass]);
            $message[] = 'Registered successfully, login now please!';
            $message_class = "success";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Hollow Login/Register</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto;
        }

        body{
            background-color: #c9d6ff;
            background: linear-gradient(to right, #fff, #c9d6ff);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            height: 100vh;
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto;
        }

        .tapowey{
            background-color: #fff;
            border-radius: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            position: relative;
            overflow: hidden;
            width: 768px;
            max-width: 100%;
            min-height: 480px;
        }

        .tapowey p{
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 0.3px;
            margin: 20px 0;
        }

        .tapowey span{
            font-size: 12px;
        }

        .tapowey a{
            font-size: 13px;
            text-decoration: none;
            margin: 15px 0 10px;
        }
        .form-tapowey .sign-in {
            background-color: red;
        }
        .tapowey button{
            background-color: #A3BAC3;
            color: #fff;
            font-size: 12px;
            padding: 10px 45px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 10px;
            cursor: pointer;
        }

        .tapowey button.hidden{
            background-color: transparent;
            border-color: #fff;
        }

        .tapowey form{
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            height: 100%;
        }

        .tapowey input{
            background-color: #eee;
            border: none;
            margin: 8px 0;
            padding: 10px 15px;
            font-size: 13px;
            border-radius: 8px;
            width: 100%;
            outline: none;
        }

        .form-tapowey{
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
        }

        .sign-in{
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .tapowey.active .sign-in{
            transform: translateX(100%);
        }

        .sign-up{
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .tapowey.active .sign-up{
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: move 0.6s;
        }

        @keyframes move{
            0%, 49.99%{
                opacity: 0;
                z-index: 1;
            }
            50%, 100%{
                opacity: 1;
                z-index: 5;
            }
        }
        .toggle-tapowey{
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all 0.6s ease-in-out;
            border-radius: 100px 0 0 100px;
            z-index: 1000;
        }
        .tapowey.active .toggle-tapowey{
            transform: translateX(-100%);
            border-radius: 0 100px 100px 0;
        }

        .toggle{
            background-color: lightblue;
            height: 100%;
            background: #A3BAC3;
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .tapowey.active .toggle{
            transform: translateX(50%);
        }

        .toggle-panel{
            position: absolute;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 30px;
            text-align: center;
            top: 0;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .toggle-left{
            transform: translateX(-200%);
        }

        .tapowey.active .toggle-left{
            transform: translateX(0);
        }

        .toggle-right{
            right: 0;
            transform: translateX(0);
        }

        .tapowey.active .toggle-right{
            transform: translateX(250%);
        }
        .error-message {
            background-color: #ffcccc;
            color: #ff0000;
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 12px;
        }
        .success-message {
            background-color: #ccffcc;
            color: #00cc00;
            text-align: center;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 12px;
        }
        .adminlogin {
            margin-top: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 170px;
            height: 50px;
            text-align: center;
        }

        .login-link {
            font-size: 14px;
            font-weight: 600;
            color: black;
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-link:hover {
            color: #A3BAC3;
        }
    </style>
</head>

<body>
    <br><br><br>
    <!-- Message section -->
    <?php if(isset($message) && !empty($message)): ?>
        <div class="<?php echo $message_class; ?>-message">
            <?php foreach($message as $msg): ?>
                <p><?php echo $msg; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
     
    <div class="tapowey" id="tapowey">
        <!-- Register -->
        <div class="form-tapowey sign-up">
            <form action="" method="post">
                <h1>Create Account</h1>
                <input type="text" name="username" required maxlength="10" placeholder="Username (Max 10 characters)">
                <input type="email" name="email" required placeholder="Email">
                <input type="password" name="pass" required placeholder="Password">
                <input type="password" name="retypepass" required placeholder="Re-type Password">
                <button type="submit" class="btn" name="register_submit">Sign Up</button>
            </form>
        </div>
        <!-- Log In  -->
        <div class="form-tapowey sign-in">
            <form action="" method="post">
                <h1>Sign In</h1>
                <input type="email" name="email" required placeholder="Email">
                <input type="password" name="pass" required placeholder="Password">
                <a href="#" style="color: black">Forget Your Password?</a>
                <button type="submit" class="btn" name="login_submit">Log In</button>
            </form>
        </div>
        <!-- Transition -->
        <div class="toggle-tapowey">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Log in into your account to continue shopping!</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello !</h1>
                    <p>New here? Click the button below to register first before continue shopping at our store!</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <div class="adminlogin">
        <i class="fa-solid fa-user-tie"></i>
        &nbsp&nbsp
        <a href="admin/admin_login.php" class="login-link">Admin Login</a>
    </div>

    <!-- for transition thingy -->
    <script>
        const tapowey = document.getElementById('tapowey');
        const registerBtn = document.getElementById('register');
        const loginBtn = document.getElementById('login');

        registerBtn.addEventListener('click', () => {
            tapowey.classList.add("active");
        });

        loginBtn.addEventListener('click', () => {
            tapowey.classList.remove("active");
        });
    </script>
</body>
</html>
