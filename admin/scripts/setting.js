
let general_data, contact_data;
let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');
let team_s_form = document.getElementById('team_s_form');
general_form = document.getElementById("general_form");

let member_name_inp = document.getElementById('member_name_inp');
let member_pic_inp = document.getElementById('member_pic_inp');


contact_form = document.getElementById("contact_form");

function get_general() {

    let site_title = document.getElementById('site_title');
    let site_about = document.getElementById('site_about');
    let shutdown_toggle = document.getElementById('shutdown-toggle');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        general_data = JSON.parse(this.responseText);

        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;
        site_title_inp.value = general_data.site_title;
        site_about_inp.value = general_data.site_about;
        if (general_data.shutdown == 0) {
            shutdown_toggle.checked = false;
            shutdown_toggle.value = 0;
        } else {
            shutdown_toggle.checked = true;
            shutdown_toggle.value = 1;
        }
    }

    xhr.send('get_general');

}

general_form.addEventListener('submit', function (e) {
    e.preventDefault();
    upd_general(site_title_inp.value, site_about_inp.value);
})

function upd_shutdown(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        if (this.responseText == 1 && general_data.shutdown == 0) {
            alert('success', 'Site has been "Shutdown"!');
        } else {
            alert('success', 'Shutdhown mode off!');
        }
        get_general();
    }

    xhr.send('upd_shutdown=' + val);

}

function upd_general(site_title_val, site_about_val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {

        var myModal = document.getElementById('general');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        console.log(this.responseText);

        if (this.responseText == 1) {
            alert('success', 'Changes saved!');
            get_general();
        } else {
            alert('error', 'No changes made!');
        }
    }

    xhr.send('site_title=' + site_title_val + '&site_about=' + site_about_val + '&upd_general');
}

function contacts_inp(data) {
    contact_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];
    for (i = 0; i < data.length; i++) {
        document.getElementById(contact_inp_id[i]).value = data[i + 1];
    }
}

function get_contact() {
    let contacts_p_id = ['address', 'g-map', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw'];
    let iframe = document.getElementById('iframe');


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        contact_data = JSON.parse(this.responseText);
        contact_data = Object.values(contact_data);
        for (i = 0; i < contacts_p_id.length; i++) {
            document.getElementById(contacts_p_id[i]).innerText = contact_data[i + 1];
        }
        iframe.src = contact_data[9];
        contacts_inp(contact_data);
    }
    xhr.send('get_contact');
}


contact_form.addEventListener('submit', function (e) {
    e.preventDefault();
    upd_contact();
})

function upd_contact() {
    let index = ['address', 'gmap', 'pn1', 'pn2', 'email', 'fb', 'insta', 'tw', 'iframe'];
    let contact_inp_id = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'fb_inp', 'insta_inp', 'tw_inp', 'iframe_inp'];

    let data_str = "";

    for (i = 0; i < index.length; i++) {
        data_str += index[i] + "=" + document.getElementById(contact_inp_id[i]).value + "&";
    }

    data_str += "upd_contact";

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        var myModal = document.getElementById('Contact-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        console.log(this.response);
        if (this.responseText == 1) {
            alert('success', 'Changes saved!');
            get_contact();
        } else {
            alert('error', 'No changes made!');
        }

    }

    xhr.send(data_str);
}

team_s_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_member();
})

function add_member() {
    let data = new FormData();
    data.append('name', member_name_inp.value);
    data.append('picture', member_pic_inp.files[0]);
    data.append('add_member', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);

    xhr.onload = function () {

        var myModal = document.getElementById('team-s');
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
            alert('success', 'New Member added!');
            member_name_inp.value = '';
            member_pic_inp.value = '';
            get_members();
        }
    }

    xhr.send(data);
}

function get_members() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('team-data').innerHTML = this.responseText;
    }

    xhr.send('get_members');
}

function rem_member(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {

        if (this.responseText == 1) {
            alert('success', 'Member Deleted!');
            get_members();
        } else {
            alert('error', 'Server Down!');
        }
    }

    xhr.send('rem_member=' + val);
}

window.onload = function () {
    get_general();
    get_contact();
    get_members();
}
