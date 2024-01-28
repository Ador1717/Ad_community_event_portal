<?php
include __DIR__ . '/header/admin-header.php';
?>

<div class="container">
    <h2>Manage Users</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                    Add User
                </button>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>

                    <button class="btn btn-danger delete-user-btn" data-userid="<?php echo $user['id']; ?>">
                        Delete
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('.delete-user-btn').on('click', function() {
            var userId = $(this).data('userid');
            var userRow = $(this).closest('tr');

            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: '/delete/user',
                    type: 'POST',
                    data: { id: userId },
                    success: function(response) {

                        if (response.success) {
                            userRow.fadeOut(400, function() {
                                $(this).remove();
                            });
                        } else {
                            alert('Failed to delete user: ' + (response.message || 'Error message not provided'));
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting user: '+ textStatus);
                    }
                });
            }
        });
    });
</script>


<?php
include __DIR__ . '/header/footer.php';
?>
