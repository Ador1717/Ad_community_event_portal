<?php
global $eventController;
include __DIR__ . '/header/admin-header.php';
?>


<div class="container">
    <h2>Manage Events</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Picture Path</th>
            <th>Posted At</th>
            <th>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createEventModal">
                    Add Event
                </button>
            </th>

        </tr>
        </thead>
        <tbody>
        <?php foreach ($events as $event): ?>
            <tr>

                <td><?php echo htmlspecialchars($event['title']); ?></td>
                <td><?php echo htmlspecialchars($event['description']); ?></td>
                <td><?php echo htmlspecialchars($event['picture_path']); ?></td>
                <td><?php echo htmlspecialchars($event['post_time']); ?></td>
                <td>
                    <button class="btn btn-danger delete-event-btn" data-eventid="<?php echo $event['event_id']; ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('.delete-event-btn').on('click', function() {
            var eventId = $(this).data('eventid');
            var eventRow = $(this).closest('tr');

            if (confirm('Are you sure you want to delete this event?')) {
                $.ajax({
                    url: '/delete/event',
                    type: 'POST',
                    data: { event_id: eventId },
                    success: function(response) {
                        if (response.success) {
                            eventRow.fadeOut(400, function() {
                                $(this).remove();
                            });
                        } else {
                            alert('Failed to delete event: ' + (response.message || 'Error message not provided'));
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error deleting event: ' + textStatus);
                    }
                });
            }
        });
    });
</script>

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
                            row.fadeOut(400, function() { $(this).remove(); });
                            alert('Event deleted successfully');
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



<input type="hidden" id="currentUserId" value="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : ''; ?>">

<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Create New Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">


                <div id="eventStep1" class="event-step">
                    <div class="form-group">
                        <label for="eventPicture">Event Picture</label>
                        <input type="file" class="form-control-file" id="eventPicture" name="picture">
                    </div>
                    <button id="nextToStep2" class="btn btn-primary">Next</button>
                </div>


                <div id="eventStep2" class="event-step" style="display: none;">
                    <div class="form-group">
                        <img id="previewImage" src="#" alt="Event Image" style="max-width: 100%; height: auto;"/>
                    </div>
                    <div class="form-group">
                        <label for="eventTitle">Event Title</label>
                        <input type="text" class="form-control" id="eventTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDescription">Event Description</label>
                        <textarea class="form-control" id="eventDescription" name="description" rows="3" required></textarea>

                    </div>
                    <button id="submitEvent" class="btn btn-primary">Post Event</button>
                </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        $('#nextToStep2').click(function() {
            console.log("Next button clicked"); // Debugging line
            var pictureInput = document.getElementById('eventPicture');
            if(pictureInput.files && pictureInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                    $('#eventStep1').hide();
                    $('#eventStep2').show();
                };
                reader.readAsDataURL(pictureInput.files[0]);
            } else {
                alert("Please select a picture.");
            }
        });

        $('#submitEvent').click(function() {
            var formData = new FormData();
            formData.append('picture', $('#eventPicture')[0].files[0]);
            formData.append('title', $('#eventTitle').val());
            formData.append('description', $('#eventDescription').val());
            var userId = $('#currentUserId').val();
            console.log("User ID: ", userId);
            formData.append('user_id', userId);  /
            formData.append('post_time', new Date().toISOString());

            $.ajax({
                url: '/create-event-action', // Adjust this to your route
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert("Event created successfully!");
                    $('#createEventModal').modal('hide');

                },
                error: function() {
                    alert("Error creating event.");
                }
            });
        });
    });
</script>


<?php
include __DIR__ . '/header/footer.php';
?>


