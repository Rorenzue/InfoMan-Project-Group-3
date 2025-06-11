<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NCIP</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="src/img_logo.png" alt="NCIP Logo" class="logo">
            <h4>Department of Social Welfare and Development</h4>
            <h2>National Commission on Indigenous Peoples</h2>
        </div>
        
        <div class="login-card">
            <h1>Welcome back, Admin!</h1>
            <p>Kindly enter your credentials to have access.</p>
            
            <form class="login-form" onsubmit="return validateLogin(event)">
                <div class="input-group">
                    <input type="email" id="email" placeholder="Enter your email" required>
                </div>
                <div class="input-group">
                    <input type="password" id="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="sign-in-btn">Sign in</button>
            </form>
        </div>
    </div>

    <script>
        function validateLogin(event) {
            event.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (email === 'clicel@gmail.com' && password === 'admin') {
                window.location.href = 'admin.php';
            } else {
                alert('Invalid credentials. Please try again.');
            }
            return false;
        }
    </script>
</body>
</html>