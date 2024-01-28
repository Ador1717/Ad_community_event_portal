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

    <style>
        .header {
            background-color: #f8f9fa; /* Example background color */
            padding: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="header">
    <h2 class="text-center login-title" style=" font-size: 48px; font-family: 'Lobster', cursive ">AD Community Event Portal</h2>
    <h3 class="text-center login-title" style=" font-size: 38px; font-family: 'Lobster', cursive ">ADMIN PAGE</h3>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top ">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="navbar-brand" href="#" data-toggle="modal" data-target="#userProfileModal">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a> <!-- Display logged in username -->
                <a href="#" data-toggle="modal" data-target="#userProfileModal">
                    <img src="http://localhost/profil.png" alt="Profile" style="height: 24px; vertical-align: middle;">
                </a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <a class="navbar-brand" href="/manage-event">Manage Events</a>
            <li class="nav-item">
                <a class="nav-link" href="#addEventSection">Add Event</a>
            </li>
            <a class="navbar-brand" href="/manage-reservations">Manage Reservation</a>
            <a class="navbar-brand" href="/admin-home">Manage users</a>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal" data-target="#addUserModal">Add User</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Modal Structure -->
<div class="modal fade" id="userProfileModal" tabindex="-1" role="dialog" aria-labelledby="userProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userProfileModalLabel">User Profile</h5>

                <button id="editProfileBtn" class="btn btn-outline-secondary ml-auto">
                    <i class="fas fa-pencil-alt"></i>
                </button>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div id="displayInfo">
                    <p>Username: <span id="displayUsername"><?php echo $_SESSION['username']; ?></span></p>
                    <p>Password: <span>********</span></p> <!-- Do not display the actual password -->
                    <p>Role: <span id="displayRole"><?php echo $_SESSION['role']; ?></span></p>
                    <p>Email: <span id="displayEmail"><?php echo isset($_SESSION['email']) ? $_SESSION['email'] : 'No email set'; ?></span></p>
                    <p>Posted At: <span id="displayPostedAt"><?php echo isset($_SESSION['posted_at']) ? $_SESSION['posted_at'] : 'No date set'; ?></span></p>
                </div>

                <div id="editInfo" style="display: none;">

                    <div id="passwordChangeSection">
                        <h5>Change Password</h5>
                        <input type="password" id="currentPassword" placeholder="Current Password" class="form-control mb-2">
                        <input type="password" id="newPassword" placeholder="New Password" class="form-control mb-2">
                        <input type="password" id="confirmNewPassword" placeholder="Confirm New Password" class="form-control mb-2">
                    </div>
                    <h5>Change Email</h5>
                    <input type="email" id="editEmail" value="<?php echo $_SESSION['email']; ?>" class="form-control mb-2">
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
<!-- Bootstrap JS and Popper.js -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>


    $(document).ready(function() {
        $('#editProfileBtn').click(function() {
            $('#displayInfo').toggle();
            $('#editInfo').toggle();
            $('#saveProfileBtn').toggle();
            $(this).html($('#editInfo').is(':visible') ? '<i class="fas fa-save"></i>' : '<i class="fas fa-pencil-alt"></i>');
        });

        // Handle save button click
        $('#saveProfileBtn').click(function() {
            var updatedInfo = {
                email: $('#editEmail').val(),
                role: $('#editRole').val()
            };

            if ($('#newPassword').val() !== '') {
                updatedInfo.currentPassword = $('#currentPassword').val();
                updatedInfo.newPassword = $('#newPassword').val();
                updatedInfo.confirmNewPassword = $('#confirmNewPassword').val();

                if(updatedInfo.newPassword !== updatedInfo.confirmNewPassword) {
                    alert("New passwords do not match.");
                    return; // Prevent form submission
                }
            }

            console.log(updatedInfo);
            $.ajax({
                url: '/update/user',
                type: 'POST',
                data: updatedInfo,
                success: function(response) {
                    $('#displayEmail').text(updatedInfo.email);
                    $('#displayRole').text(updatedInfo.role);
                    // Add other fields as necessary

                    // Optionally, switch back to the display view
                    $('#displayInfo').show();
                    $('#editInfo').hide();
                    $('#saveProfileBtn').hide();
                    $('#editProfileBtn').html('<i class="fas fa-pencil-alt"></i>');

                    // Handle additional response logic
                    console.log("Update successful:", response);
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

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: #2a2a72; color: white;">
            <div class="modal-header" style="border-bottom: none; background-color: #9c27b0;">
                <h5 class="modal-title" id="addUserModalLabel" style="color: white;">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Add User Form -->
                <form id="addUserForm">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Enter username" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" class="form-control">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn" style="background-color: #9c27b0; color: white;">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {

        $('#addUserForm').on('submit', function(event) {
            event.preventDefault();

            var userData = {
                username: $('#username').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                role: $('#role').val()
            };


            $.ajax({
                url: '/authentication/register',
                type: 'POST',
                data: userData,
                success: function(response) {
                    console.log(response);
                    $('#addUserModal').modal('hide');

                },
                error: function(xhr, status, error) {
                    console.log("Error adding user:", error);
                }
            });
        });
    });
</script>



