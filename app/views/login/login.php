<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Art-Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
</head>
<body class="bg-danger p-5 text-white ">
<div class="container">
    <section>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                background: linear-gradient(to bottom, rgb(30, 144, 255), #add8e6);
                background-attachment: fixed;
            }
            /* Other styles */
        </style>
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <h2 class="text-center login-title" style=" font-size: 48px; font-family: 'Lobster', cursive ">AD Community Event Portal</h2>
                    <h2 class="text-center" style="margin-bottom: 3rem;">Login</h2>
                    <div class="form-frame" style="border: 1px solid #6e8cda;
                                padding: 20px;
                                margin: 0 auto;
                                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                                border-radius: 8px;
                                width: 150%;
                                max-width: 500px;">
                        <form action="/authentication/login" method="post">
                            <div class="mb-3">
                                <label for="usernameInput" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" id="usernameInput" >
                                <div class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="passwordInput" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="passwordInput">
                            </div>
                            <div class="mb-2"  >
                                <a href="path_to_forgot_password.php" class="form-link">Forgot Password?</a>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="checkMeOut">
                                <label class="form-check-label" for="checkMeOut">Check me out</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                            <button type="reset" class="btn btn-secondary">Clear</button>
                            <div class="mt-4 text-center">
                                <a href="/register" class="btn btn-link">Don't have an account? Register here!</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>

