<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticketing98 - Login</title>
    <?php include "components/head.php" ?>
    <script src="js/formHelper.js"></script>
</head>
<body>
<div class="centered-container window">
    <section>
        <div class="title-bar">
            <div class="title-bar-text">Register to Ticketing98</div>
        </div>
        <form class="window-body" id="login-form" method="post">
            <!-- Email -->
            <div class="field-row-stacked">
                <label for="email">Email</label>
                <input id="email" name="username" placeholder="Email" required type="email">
                <div class="hidden font-13px error-message" id="email-error">
                    <img alt="Error Email" height="16" src="icons/msg_error-2.png" width="16">
                    <span></span>
                </div>
            </div>
            <!-- Name -->
            <div class="field-row-stacked">
                <label for="name">Name</label>
                <input id="name" name="username" placeholder="Name" required type="text">
                <div class="hidden font-13px error-message" id="name-error">
                    <img alt="Error Name" height="16" src="icons/msg_error-2.png" width="16">
                    <span></span>
                </div>
            </div>
            <!-- Password -->
            <div class="field-row-stacked">
                <label for="password">Password</label>
                <input id="password" name="password" placeholder="Password" required type="password">
                <div class="hidden font-13px error-message" id="password-error">
                    <img alt="Error Password" height="16" src="icons/msg_error-2.png" width="16">
                    <span></span>
                </div>
            </div>
            <!-- Confirm Password-->
            <div class="field-row-stacked">
                <label for="confirm-password">Confirm Password</label>
                <input id="confirm-password" name="confirm-password" placeholder="Confirm Password" required
                       type="password">
                <div class="hidden font-13px error-message" id="confirm-password-error">
                    <img alt="Error Confirm Password" height="16" src="icons/msg_error-2.png" width="16">
                    <span></span>
                </div>
            </div>
            <br/>
            <div style="text-align: right"><input type="submit" value="Register"></div>
        </form>
        <script>
            document.getElementById('login-form').addEventListener('submit', (e) => {
                e.preventDefault();
                let email = document.getElementById('email');
                let name = document.getElementById('name');
                let password = document.getElementById('password');
                let confirmPassword = document.getElementById('confirm-password');

                let valid = true;

                valid &= checkInput(email, 'email-error', [emptyCondition("Email is required!"), emailCondition("Not a valid email address!")]);
                valid &= checkInput(name, 'name-error', [emptyCondition("A name is required!")]);
                valid &= checkInput(password, 'password-error', [emptyCondition("Password is required!")]);
                valid &= checkInput(confirmPassword, 'confirm-password-error', [emptyCondition("You must confirm your password!"), {
                    errorPredicate: (input) => input.value !== password.value,
                    message: "Password does not match!"
                }]);
                if (valid) location.href = 'login.html'
            })
        </script>
    </section>
</div>
</body>
</html>