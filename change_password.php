<?php
include 'components/sessionstart.php';
include 'cursor.php';

// Check if user is logged in
if (!isset($_SESSION['CustID'])) {
    header('Location: Cust_Account.php');
    exit();
}

// Fetch customer details
$customer_id = $_SESSION['CustID'];
$select_user = $conn->prepare("SELECT * FROM `customer` WHERE CustID = ?");
$select_user->execute([$customer_id]);
$customer = $select_user->fetch(PDO::FETCH_ASSOC);

$message = [];
$message_class = "";

if (isset($_POST['update_password'])) {
    $old_pass = sha1($_POST['old_pass']);
    $new_pass = sha1($_POST['new_pass']);
    $retype_new_pass = sha1($_POST['retype_new_pass']);

    // Check if the old password matches
    if ($old_pass != $customer['CustPass']) {
        $message[] = 'Old password is incorrect!';
        $message_class = "error";
    } elseif ($new_pass != $retype_new_pass) {
        $message[] = 'New passwords do not match!';
        $message_class = "error";
    } else {
        $update_user = $conn->prepare("UPDATE `customer` SET CustPass = ? WHERE CustID = ?");
        $update_user->execute([$new_pass, $customer_id]);

        $message[] = 'Password updated successfully!';
        $message_class = "success";
    }
}

include 'header_User.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <title>Update Password</title>
    <style>
        body {
            background: linear-gradient(to right, #fff, #c9d6ff);
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto;
        }
        .popo {
            max-width: 600px;
            margin: 10px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .message {
            width: 41.5%;
            text-align: center;
            padding: 2px;
            border-radius: 8px;
            margin-bottom: 2px;
            font-size: 16px;
            margin-left: 29%;
        }
        .message.error {
            background-color: #f44336;
            color: white;
        }
        .message.success {
            background-color: #4CAF50;
            color: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            padding: 10px;
        }
        input[type="password"], input[type="text"] {
            width: 90%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        .button:hover {
            background-color: #45a049;
        }
        .password-popo {
            position: relative;
            width: fit-content;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <br><br><br><br>
    <?php if (!empty($message)): ?>
        <div class="message <?php echo $message_class; ?>">
            <?php foreach ($message as $msg): ?>
                <p><?php echo $msg; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <div class="popo">
        <h1 style="text-align: center">Update Password</h1>

        <form action="" method="post">
            <table>
                <tr>
                    <td><label for="old_pass">Old Password:</label></td>
                    <td>
                        <div class="password-popo">
                            <input type="password" id="old_pass" name="old_pass" required>
                            <span id="toggleOldPassword" class="toggle-password">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="new_pass">New Password:</label></td>
                    <td>
                        <div class="password-popo">
                            <input type="password" id="new_pass" name="new_pass" required>
                            <span id="toggleNewPassword" class="toggle-password">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="retype_new_pass">Retype New Password:</label></td>
                    <td>
                        <div class="password-popo">
                            <input type="password" id="retype_new_pass" name="retype_new_pass" required>
                            <span id="toggleRetypeNewPassword" class="toggle-password">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
            <button class="button" type="submit" name="update_password">Update</button>
        </form>
    </div>
    <br><br>
</body>
<?php include 'footer.php'; ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = (toggleId, inputId) => {
            const toggleButton = document.getElementById(toggleId);
            const inputField = document.getElementById(inputId);
            toggleButton.addEventListener('click', function() {
                const type = inputField.getAttribute('type') === 'password' ? 'text' : 'password';
                inputField.setAttribute('type', type);
                this.querySelector('i').classList.toggle('fa-eye');
                this.querySelector('i').classList.toggle('fa-eye-slash');
            });
        };

        togglePassword('toggleOldPassword', 'old_pass');
        togglePassword('toggleNewPassword', 'new_pass');
        togglePassword('toggleRetypeNewPassword', 'retype_new_pass');
    });
</script>
</html>
