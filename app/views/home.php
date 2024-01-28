<?php
include __DIR__ . '/header/header.php';
?>

<input type="hidden" id="currentUserId" value="<?php echo $_SESSION['id'] ?? ''; ?>">
<!-- Event Creation Modal -->
<!-- Event Creation Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Create New Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">

                <!-- Step 1: Select Picture -->
                <div id="eventStep1" class="event-step">
                    <div class="form-group">
                        <label for="eventPicture">Event Picture</label>
                        <input type="file" class="form-control-file" id="eventPicture" name="picture">
                    </div>
                    <button id="nextToStep2" class="btn btn-primary">Next</button>
                </div>

                <!-- Step 2: Title and Description -->
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

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reserveEventModal" data-eventid="<?php echo $event['event_id']; ?>">Reserve</button>
            </div>
        </div>
    </div>
</div>
<div class="upcoming-event-banner text-center text-white py-5" style="position: relative; overflow: hidden; ">
    <img src="http://localhost/img_1.png" alt="Event Background" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: -1; object-fit: cover;">
    <div class="container" style="position: relative; z-index: 10; padding-top: 10%; padding-bottom: 10%;">
        <h2 class="font-weight-bold mb-3" style="font-family: Arial, sans-serif; font-size: 3rem;">DON'T MISS THE UPCOMING EVENT</h2>
        <p class="event-date mb-4" style="font-family: Arial, sans-serif; font-size: 1.5rem;">14 July, 2024 at 2:40pm</p>
        <p class="event-date mb-4" style="font-family: Arial, sans-serif; font-size: 1.5rem;">PROMOTE YOUR EVENTS!</p>
        <div class="countdown d-flex justify-content-center mb-4" style="display: flex; justify-content: center; font-size: 1.5rem; color: black;">
            <div class="mx-2" style="margin: 0 10px; font-size: 1.2rem;">12 <small>Days</small></div>
            <div class="mx-2" style="margin: 0 10px; font-size: 1.2rem;">14 <small>Hours</small></div>
            <div class="mx-2" style="margin: 0 10px; font-size: 1.2rem;">28 <small>Minutes</small></div>
            <div class="mx-2" style="margin: 0 10px; font-size: 1.2rem;">14 <small>Seconds</small></div>
        </div>
        <div class="button-container" style="font-family: Arial, sans-serif;">
            <button type="button" class="btn btn-primary btn-lg " data-toggle="modal" data-target="#createEventModal" style="margin-right: 10px; padding: 15px 30px; font-size: 1.5rem;">ADD EVENT NOW</button>
            <button type="button" class="btn btn-outline-light btn-lg"  id="scrollToEvents" style="padding: 15px 30px; font-size: 1.5rem;">GET INVITE</button>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row align-items-center" style="background: #7C5E10; color: white; padding: 20px;">
        <div class="col-md-6">
            <h3>About AD Community Events</h3>
            <p>
                AD Community Events brings together culture, music, and food enthusiasts to celebrate and participate in events all year round. From local festivals to cultural workshops, we offer a platform for communities to connect, share experiences, and create lasting memories. Join us in exploring a world of events tailored for every interest.
            </p>
            <a href="#" class="btn btn-light">See More</a>
        </div>
        <div class="col-md-6">
            <img src="http://localhost/img_2.png" alt="event 2022" style="width: 100%; height: auto;">
        </div>
    </div>
</div>



<div class="Events" id="latestEventsSection" style="padding: 50px">
    <h2 class="text-center login-title" style=" font-size: 48px;  padding-top: 100px ">Discover and register for event of your own choice  </h2>
    <p class="text-center login-title" style=" font-size: 28px ">LATEST EVENT:</p>
</div>


<div class="container mt-4" id="eventsContainer">
    <div class="row">
        <?php foreach ($events as $event): ?>
            <div class="col-md-4 mb-3">
                <div class="card" style="min-height: 450px; display: flex; flex-direction: column; justify-content: space-between; margin: 10px;">
                    <?php if (!empty($event['picture_path'])): ?>
                        <img src="/img/<?php echo htmlspecialchars($event['picture_path']); ?>" class="card-img-top" alt="Event Image" style="max-height: 200px; object-fit: cover;">


                    <?php endif; ?>
                    <div class="card-body" style="display: flex; flex-direction: column; justify-content: space-between; padding: 15px;">
                        <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($event['description']); ?></p>
                        <p class="text-muted"><small>Posted on <?php echo htmlspecialchars($event['post_time']); ?></small></p>
                    </div>
                    <button
                        type="button" class="btn btn-primary" data-toggle="modal" data-target="#reserveEventModal" data-eventid="<?php echo $event['event_id']; ?>">
                        Reserve
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="reserveEventModal" tabindex="-1" role="dialog" aria-labelledby="reserveEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="reserveEventModalLabel">Reserve Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="reserveEventForm">
                    <!-- Form fields here -->
                    <input type="hidden" id="reserveEventId" name="event_id" value="">
                    <div class="form-group">
                        <label for="notes">Additional Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary reserve-event-btn" data-target="#reserveEventModal" data-eventid="<?php echo $event['event_id']; ?>"> Submit Reservation</button>
                </form>
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
            formData.append('user_id', userId);
            console.log("User ID: ", userId);
            formData.append('post_time', new Date().toISOString());

            $.ajax({
                url: '/event/create',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert("Event created successfully!");
                    $('#createEventModal').modal('hide');
                    refreshEvents();
                },
                error: function() {
                    alert("Error creating event.");
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {

        function showReserveEventModal(eventId) {
            $('#reserveEventId').val(eventId);
            $('#reserveEventModal').modal('show');
        }
        $('#eventsContainer').on('click', '.reserve-event-btn', function() {
            var eventId = $(this).data('eventid');
            showReserveEventModal(eventId);
        });
        $('.reserve-event-btn').on('click', function() {
            var eventId = $(this).data('eventid');
            showReserveEventModal(eventId);
        });


        $('#reserveEventForm').on('submit', function(event) {
            event.preventDefault();

            var formData = {
                event_id: $('#reserveEventId').val(),
                notes: $('#notes').val()
            };


            $.ajax({
                url: '/create-reservation',
                type: 'POST',
                data: formData,
                success: function(response) {
                    //console.log(response);
                    if (response.success) {
                        alert("Reservation created successfully!");
                        $('#reserveEventModal').modal('hide');
                    } else {
                        alert("Failed to create reservation: " + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", xhr, status, error);
                    alert("Failed to create reservation. Technical error: " + error);
                }
            });
        });
    });
</script>

<script>
    function refreshEvents() {
        $.ajax({
            url: '/fetchEvents.php', // Adjust to your endpoint
            type: 'GET',
            success: function(events) {
                var eventsContainer = $('#eventsContainer .row').first();
                eventsContainer.empty();
                events.forEach(function (event) {
                    var eventPictureHtml = event.picture_path ? '<img src="/img/' + event.picture_path + '" class="card-img-top" alt="Event Image " style="max-height: 150px; object-fit: cover;>' : '';

                    // Use the correct modal target and data attributes
                    var eventHtml = '<div class="col-md-4 mb-4">' +
                        '<div class="card " style="min-height: 350px; display: flex; flex-direction: column; justify-content: space-between; margin: 10px;">' +
                        eventPictureHtml +
                        '<div class="card-body">' +
                        '<h5 class="card-title">' + event.title + '</h5>' +
                        '<p class="card-text">' + event.description + '</p>' +
                        '<p class="text-muted"><small>Posted on ' + event.post_time + '</small></p>' +
                        '</div>' +
                        '<button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#reserveEventModal" data-eventid="' + event.event_id + '">Reserve</button>' +
                        '</div>' +
                        '</div>';
                    eventsContainer.append(eventHtml);
                });
            },
            error: function(xhr, status, error) {
                console.error("Error fetching events:", status, error);
            }
        });
    }


    $(document).ready(function() {
        refreshEvents();
    });

</script>

<script>
    $(document).ready(function() {
        $('#scrollToEvents').click(function() {
            $('html, body').animate({
                scrollTop: $('#latestEventsSection').offset().top
            }, 1000);
        });

    });
</script>

<?php
include __DIR__ . '/header/footer.php';
?>






