<?php
include __DIR__ . '/header/admin-header.php';
?>

    <div class="container">
        <h2>Manage Reservations</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Username</th>
                <th>Event Title</th>
                <th>Notes</th>
                <th>Reservation Time</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?php echo htmlspecialchars($reservation['username']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['title']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['notes']); ?></td>
                    <td><?php echo htmlspecialchars($reservation['reservation_time']); ?></td>
                    <td>
                        <button class="btn btn-danger delete-reservation-btn" data-reservationid="<?php echo $reservation['reservation_id']; ?>">
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
            $('.delete-reservation-btn').on('click', function() {
                var reservationId = $(this).data('reservationid');
                var row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this reservation?')) {
                    $.ajax({
                        url: '/delete-reservation',
                        type: 'POST',
                        data: { reservation_id: reservationId },
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut(400, function() { $(this).remove(); });
                                alert('Reservation deleted successfully');
                            } else {
                                alert('Failed to delete reservation: ' + response.message);
                            }
                        },
                        error: function() {
                            alert('An error occurred while deleting the reservation.');
                        }
                    });
                }
            });
        });
    </script>

<?php
include __DIR__ . '/header/footer.php';
?>
