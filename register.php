<?php
require 'config/config.php';
require 'form_handlers/register_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Registration</title>
</head>
<body>
<div class="background-image"></div>
<div class="background-container">
    <h1>Register to POSTICKS</h1>
    <h3>something</h3>
    <table>
        <tr>
            <td colspan="2" style="width: 70%">
                <img src="images/network_posticks.png" style="width: 95%" alt="network">
            </td>
            <td>
                <form style="alignment: right" action="register.php" method="POST">
                    <label><input name="reg_first_name" placeholder="First Name" type="text"
                                  value="<?php if(isset($_SESSION['reg_first_name'])) echo $_SESSION['reg_first_name']?>" required></label><br>
                    <label class="error_message">
                        <?php if (in_array("First name must be between 2 and 25 characters<br>", $error_array))
                            echo "First name must be between 2 and 25 characters<br>"; ?>
                    </label>
                    <label><input name="reg_last_name" placeholder="Last Name" type="text"
                                  value="<?php if(isset($_SESSION['reg_last_name'])) echo $_SESSION['reg_last_name']?>" required></label><br>
                    <label class="error_message">
                        <?php if (in_array("Last name must be between 2 and 25 characters<br>", $error_array))
                            echo "Last name must be between 2 and 25 characters<br>"; ?>
                    </label>
                    <label><input name="reg_email" placeholder="Email" type="email"
                                  value="<?php if(isset($_SESSION['reg_email'])) echo $_SESSION['reg_email']?>" required></label><br>
                    <label class="error_message">
                        <?php if (in_array("Email already in use<br>", $error_array))
                            echo "Email already in use<br>";
                        if (in_array("Invalid email format<br>", $error_array))
                            echo "Invalid email format<br>"; ?>
                    </label>
                    <label><input name="reg_password" placeholder="Password" type="password" required></label><br>
                    <label class="error_message">
                        <?php if (in_array("Password must be between 5 and 30 characters<br>", $error_array))
                            echo "Password must be between 5 and 30 characters<br>";
                        if (in_array("Your password can only contain english characters or numbers<br>", $error_array))
                            echo "Your password can only contain english characters or numbers<br>"; ?>
                    </label>
                    <label><input name="reg_confirm_password" placeholder="Confirm Password" type="password" required></label><br>
                    <label class="error_message">
                        <?php if (in_array("Passwords don't match2<br>", $error_array))
                            echo "Passwords don't match2<br>"; ?>
                    </label>
                    Male<label><input name="reg_gender" placeholder="Male" type="radio" value="male"></label>
                    Female<label><input name="reg_gender" placeholder="Female" type="radio" value="female"></label><br>
                    <input name="register_button" type="submit" value="Register">
                </form>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
