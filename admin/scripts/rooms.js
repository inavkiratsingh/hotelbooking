let add_room_form = document.getElementById('add_room_form');
let edit_room_form = document.getElementById('edit_room_form');
let add_image_form = document.getElementById('add_image_form');

add_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_rooms();
});
edit_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    edit_room();
});

add_image_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_image();
})

function add_rooms() {
    let data = new FormData();
    data.append('name', add_room_form.elements['name'].value);
    data.append('area', add_room_form.elements['area'].value);
    data.append('price', add_room_form.elements['price'].value);
    data.append('quantity', add_room_form.elements['quantity'].value);
    data.append('adult', add_room_form.elements['adult'].value);
    data.append('children', add_room_form.elements['child'].value);
    data.append('desc', add_room_form.elements['desc'].value);

    let features = [];
    add_room_form.elements['features'].forEach(el => {
        if (el.checked) {
            features.push(el.value);
        }
    });
    let facilities = [];
    add_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });

    data.append('features', JSON.stringify(features))
    data.append('facilities', JSON.stringify(facilities))
    data.append('add_room', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_crud.php", true);

    xhr.onload = function () {

        var myModal = document.getElementById('add-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        console.log(this.responseText);

        if (this.responseText == 1) {
            alert('success', 'Room added!');
            add_room_form.reset();
            getall_rooms();
        } else {
            alert('error', 'Server Down!');
        }
    }

    xhr.send(data);
}

function getall_rooms() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('room-data').innerHTML = this.responseText;
    }
    xhr.send('getall_rooms');
}

function edit_details(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        let data = JSON.parse(this.responseText);
        edit_room_form.elements['name'].value = data.roomdata.name;
        edit_room_form.elements['area'].value = data.roomdata.area;
        edit_room_form.elements['price'].value = data.roomdata.price;
        edit_room_form.elements['quantity'].value = data.roomdata.quantity;
        edit_room_form.elements['adult'].value = data.roomdata.adult;
        edit_room_form.elements['child'].value = data.roomdata.children;
        edit_room_form.elements['desc'].value = data.roomdata.description;
        edit_room_form.elements['room_id'].value = data.roomdata.id;

        edit_room_form.elements['facilities'].forEach(el => {
            if (data.facilities.includes(Number(el.value))) {
                el.checked = true;
            }
        });

        edit_room_form.elements['features'].forEach(el => {
            if (data.features.includes(Number(el.value))) {
                el.checked = true;
            }
        });
    }

    xhr.send('get_room=' + id);
}

function edit_room() {
    let data = new FormData();
    data.append('room_id', edit_room_form.elements['room_id'].value);
    data.append('name', edit_room_form.elements['name'].value);
    data.append('area', edit_room_form.elements['area'].value);
    data.append('price', edit_room_form.elements['price'].value);
    data.append('quantity', edit_room_form.elements['quantity'].value);
    data.append('adult', edit_room_form.elements['adult'].value);
    data.append('children', edit_room_form.elements['child'].value);
    data.append('desc', edit_room_form.elements['desc'].value);

    let features = [];
    edit_room_form.elements['features'].forEach(el => {
        if (el.checked) {
            features.push(el.value);
        }
    });
    let facilities = [];
    edit_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });

    data.append('features', JSON.stringify(features))
    data.append('facilities', JSON.stringify(facilities))
    data.append('edit_room', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_crud.php", true);

    xhr.onload = function () {

        var myModal = document.getElementById('edit-room');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        console.log(this.responseText);

        if (this.responseText == 1) {
            alert('success', 'Room Data Edited!');
            edit_room_form.reset();
            getall_rooms();
        } else {
            alert('error', 'Server Down!');
        }
    }

    xhr.send(data);
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        console.log(this.responseText);
        if (this.response == 1) {
            alert('success', 'Status toggled!');
            getall_rooms();
        } else {
            alert('error', 'Server down');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}

function add_image() {
    let data = new FormData();
    data.append('image', add_image_form.elements['image'].files[0]);
    data.append('room_id', add_image_form.elements['room_id'].value);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_crud.php", true);

    xhr.onload = function () {
        console.log(this.responseText);

        if (this.responseText == 'inv_img') {
            alert('error', 'Only jpg,webp and jpeg images are allowed!');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image size should be less than 2 mb!');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Image updation failed due to server error!');
        } else {
            alert('success', 'New Image added!');
            room_images(add_image_form.elements['room_id'].value, document.querySelector('#room-img .model-title').innerText);
            add_image_form.reset();
        }
    }

    xhr.send(data);
}

function room_images(room_id, room_name) {
    document.querySelector('#room-img .model-title').innerText = room_name;
    add_image_form.elements['room_id'].value = room_id;
    add_image_form.elements['image'].value = '';

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('room-image-data').innerHTML = this.responseText;
    }
    xhr.send('get_room_images=' + room_id);
}

function rem_image(imgid, roomid) {
    let data = new FormData();
    data.append('image_id', imgid);
    data.append('room_id', roomid);
    data.append('rem_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_crud.php", true);

    xhr.onload = function () {
        console.log(this.responseText);

        if (this.response == 1) {
            alert('success', 'Image removed!');
            room_images(roomid, document.querySelector('#room-img .model-title').innerText);
        } else {
            alert('error', 'Failed removal!');
        }
    }

    xhr.send(data);
}

function thumb_image(imgid, roomid) {
    let data = new FormData();
    data.append('image_id', imgid);
    data.append('room_id', roomid);
    data.append('thumb_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/room_crud.php", true);

    xhr.onload = function () {
        console.log(this.responseText);

        if (this.response == 1) {
            alert('success', 'Thumbnail changed!');
            room_images(roomid, document.querySelector('#room-img .model-title').innerText);
        } else {
            alert('error', 'Failed to change thumbnail!');
        }
    }

    xhr.send(data);
}

function rem_room(roomid) {

    if (confirm("Are you sure to remove the Room")) {
        let data = new FormData();
        data.append('room_id', roomid);
        data.append('remove_room', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/room_crud.php", true);

        xhr.onload = function () {
            console.log(this.responseText);

            if (this.response == 1) {
                alert('success', 'Room removed!');
                getall_rooms();
            } else {
                alert('error', 'Failed to remove!');
            }
        }

        xhr.send(data);
    }
}

window.onload = function () {
    getall_rooms();
}
