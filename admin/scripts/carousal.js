

let carousal_s_form = document.getElementById('carousal_s_form');
let carousal_picture_inp = document.getElementById('carousal_picture_inp');


carousal_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_image();
})

function add_image() {
    let data = new FormData();
    data.append('picture', carousal_picture_inp.files[0]);
    data.append('add_image', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousal_crud.php", true);

    xhr.onload = function () {

        var myModal = document.getElementById('carousal-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        console.log(this.responseText);

        if (this.responseText == 'inv_img') {
            alert('error', 'Only jpg and jpeg images are allowed!');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image size should be less than 2 mb!');
        } else if (this.responseText == 'upd_failed') {
            alert('error', 'Image updation failed due to server error!');
        } else {
            alert('success', 'New Image added!');
            carousal_picture_inp.value = '';
            get_carousals();
        }
    }

    xhr.send(data);
}

function get_carousals() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousal_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('carousal-data').innerHTML = this.responseText;
    }

    xhr.send('get_carousals');
}

function rem_image(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousal_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {

        if (this.responseText == 1) {
            alert('success', 'Image Deleted!');
            get_carousals();
        } else {
            alert('error', 'Server Down!');
        }
    }

    xhr.send('rem_image=' + val);
}

window.onload = function () {

    get_carousals();
}
