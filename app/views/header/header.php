<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        .header {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;


            .theme-switch input {
                display:none;
            }

            #eventsContainer .row {
                flex: 0 1 auto;
            }

        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 transition duration-500 ease-in-out">

<div class="header">
    <h2 class="text-center login-title" style=" font-size: 48px; font-family: 'Lobster', cursive ">AD Community Event Portal</h2>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top " >

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" >
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item d-flex align-items-center"  style="margin-left: 50px;">
                <a class="navbar-brand" href="#">Home</a>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createEventModal">
                    Add Event
                </button>
            </li>
        </ul>
        <ul class="navbar-nav">
            <a class="navbar-brand d-flex align-items-center" href="#" data-toggle="modal" data-target="#userProfileModal">
                Welcome, <?php echo htmlspecialchars($_SESSION['username']);  ?>
                <img src="http://localhost/profil.png" alt="Profile" style="height: 24px; vertical-align: middle; margin-right: 5px;">
            </a>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="modal fade" id="userProfileModal" tabindex="-1" role="dialog" aria-labelledby="userProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userProfileModalLabel">User Profile</h5>

                <!-- Edit Icon -->
                <button id="editProfileBtn" class="btn btn-outline-secondary ml-auto">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Non-editable display -->
                <div id="displayInfo">
                    <p>Username: <span id="displayUsername"><?php echo $_SESSION['username']; ?></span></p>
                    <p>Password: <span>********</span></p> <!-- Do not display the actual password -->
                    <p>Role: <span id="displayRole"><?php echo $_SESSION['role']; ?></span></p>
                    <p>Email: <span id="displayEmail"><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'No email set'; ?></span></p>
                </div>

                <div id="editInfo" style="display: none;">
                    <div class="form-group">
                        <label for="editEmail">Change Email</label>
                        <input type="email" id="editEmail" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="editRole"> Change Role  </label>
                        <select id="editRole" class="form-control">
                            <option value="user" <?php echo $_SESSION['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo $_SESSION['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>

                </div>

                <button id="saveProfileBtn" class="btn btn-primary" style="display: none;">Save</button>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Your page content goes here -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

<script>
    $(document).ready(function() {
        $('#editProfileBtn').click(function() {
            $('#displayInfo').toggle();
            $('#editInfo').toggle();
            $('#saveProfileBtn').toggle();
            $(this).html($('#editInfo').is(':visible') ? '<i class="fas fa-save"></i>' : '<i class="fas fa-pencil-alt"></i>');
        });


        $('#saveProfileBtn').click(function() {
            var updatedInfo = {

                email: $('#editEmail').val(),
                role: $('#editRole').val()
            };

            $.ajax({
                url: '/user/update',
                type: 'POST',
                data: updatedInfo,
                success: function(response) {
                    $('#displayEmail').text(updatedInfo.email);
                    $('#displayRole').text(updatedInfo.role);

                    $('#displayInfo').show();
                    $('#editInfo').hide();
                    $('#saveProfileBtn').hide();
                    $('#editProfileBtn').html('<i class="fas fa-pencil-alt"></i>');

                },
                error: function(xhr, status, error) {
                    if (xhr.status >= 400) {
                        var response = JSON.parse(xhr.responseText);
                        alert("Error: " + response.message);
                    } else {
                        alert("An error occurred: " + error);
                    }
                }
            });
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

