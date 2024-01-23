function get_users() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    }
    xhr.send('get_users');
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        console.log(this.responseText);
        if (this.response == 1) {
            alert('success', 'Status toggled!');
            get_users();
        } else {
            alert('error', 'Server down');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}

function rem_user(userid) {

    if (confirm("Do you want to remove this user?")) {
        let data = new FormData();
        data.append('user_id', userid);
        data.append('remove_user', '');

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/users.php", true);

        xhr.onload = function () {
            console.log(this.responseText);

            if (this.response == 1) {
                alert('success', 'User removed!');
                get_users();
            } else {
                alert('error', 'Failed to remove!');
            }
        }

        xhr.send(data);
    }
}

function search_user(username){
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/users.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function () {
        document.getElementById('users-data').innerHTML = this.responseText;
    }
    xhr.send('search_users&name='+username);
}

window.onload = function () {
    get_users();
}
