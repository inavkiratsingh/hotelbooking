function get_bookings(search = '') {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('bookings-data').innerHTML = this.responseText;
    }
    xhr.send('get_bookings&search=' + search);
}

let assign_room_form = document.getElementById('assign_room_form');

function assign_room(booking_id) {
    assign_room_form.elements['booking_id'].value = booking_id;
}

assign_room_form.addEventListener('submit', function (e) {
    e.preventDefault();

    let data = new FormData();
    data.append('room_num', assign_room_form.elements['room_num'].value);
    data.append('booking_id', assign_room_form.elements['booking_id'].value);
    data.append('assign_room', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/new_bookings.php", true);

    xhr.onload = function () {

        var myModal = document.getElementById('assign-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        console.log(this.responseText);

        if (this.responseText == 1) {
            alert('success', 'Room number alloted');
            assign_room_form.reset();
            get_bookings();
        } else {
            alert('error', 'Server down !');
        }
    }

    xhr.send(data);
})

function cancel_booking(id) {
    if (confirm("Do you want to cancel this this?")) {
        let data = new FormData();
        data.append('booking_id', id);
        data.append('cancel_booking', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/new_bookings.php", true);

        xhr.onload = function () {
            console.log(this.responseText);

            if (this.response == 1) {
                alert('success', 'Booking canceled!');
                get_bookings();
            } else {
                alert('error', 'Server down!');
            }
        }

        xhr.send(data);
    }
}




window.onload = function () {
    get_bookings();
}
