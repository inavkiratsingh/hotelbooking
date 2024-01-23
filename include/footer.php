<div class="container-fluid bg-white mt-5">
    <div class="row">
        <div class="col-lg-4 p-4">
            <h3 class="h-font fw-bold fs-3 mb-2">
                <?php echo $settings_r['site_title'] ?>
            </h3>
            <p>
                <?php echo $settings_r['site_about'] ?>
            </p>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">
                Links
            </h5>
            <a href="index.php" class="text-decoration-none d-inline-block mb-2 text-dark">Home</a><br>
            <a href="rooms.php" class="text-decoration-none d-inline-block mb-2 text-dark">Rooms</a><br>
            <a href="facilities.php" class="text-decoration-none d-inline-block mb-2 text-dark">Facilities</a><br>
            <a href="contact.php" class="text-decoration-none d-inline-block mb-2 text-dark">Contact Us</a><br>
            <a href="about.php" class="text-decoration-none d-inline-block mb-2 text-dark">About</a><br>
        </div>
        <div class="col-lg-4 p-4">
            <h5 class="mb-3">
                Follow Us
            </h5>
            <?php
            if ($contact_r['tw'] != '') {
                echo <<<data
                <a href="$contact_r[tw]" class="d-inline-block mb-2 text-decoration-none text-dark">                
                    <i class="bi bi-twitter me-1"></i> Twitter
                </a>
                data;
            }
            ?>
            <a href="<?php echo $contact_r['fb'] ?>" class="d-inline-block text-dark text-decoration-none mb-2">
                <i class="bi bi-facebook"></i> Facebook
            </a>
            <a href="<?php echo $contact_r['insta'] ?>" class="d-inline-block text-dark text-decoration-none ">
                <i class="bi bi-instagram"></i> Instagram
            </a>
        </div>
    </div>
</div>

<h6 class="bg-dark text-white text-center p-3 m-0">Designed and Developed by Navkirat</h6>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"
    integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>
    function setActive() {

        let navbar = document.getElementById("nav-bar");
        let a_tags = navbar.getElementsByTagName('a');

        for (i = 0; i < a_tags.length; i++) {
            let file = a_tags[i].href.split('/').pop();
            let file_name = file.split('.')[0];
            if (document.location.href.indexOf(file_name) >= 0) {
                a_tags[i].classList.add('active');
            }
        }

    }
    setActive();
</script>

<!-- login-register  -->
<script>

    function alert(type, msg, position = 'body') {
        let bs_class = (type == 'success') ? 'alert-success' : 'alert-danger';
        let element = document.createElement('div');
        element.innerHTML = `
        <div class="alert ${bs_class} alert-dismissible fade show custom-alert" role="alert">
            <strong class="me-3">${msg}</strong>
            <button class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>  
        `;
        if (position == 'body') {
            document.body.append(element);
            // element.classList.add('custom-alert');
        } else {
            document.getElementById(position).append(element);
        }
        setTimeout(remAlert, 3000);
    }

    function remAlert() {
        document.getElementsByClassName('alert')[0].remove();
    }


    let register_form = document.getElementById('register-form');
    register_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();
        data.append('name', register_form.elements['name'].value);
        data.append('email', register_form.elements['email'].value);
        data.append('phonenum', register_form.elements['mobile'].value);
        data.append('dob', register_form.elements['dob'].value);
        data.append('address', register_form.elements['address'].value);
        data.append('pincode', register_form.elements['pincode'].value);
        data.append('pass', register_form.elements['pass'].value);
        data.append('cpass', register_form.elements['cpass'].value);
        data.append('profile', register_form.elements['profile'].files[0]);
        data.append('register', '');

        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function () {
            if (this.responseText == 'pass_missmatch') {
                alert('error', 'Password Missmatch!');
            } else if (this.responseText == 'email_already') {
                alert('error', 'Email already exist!');
            } else if (this.responseText == 'phone_already') {
                alert('error', 'Phone no. already exist!');
            } else if (this.responseText == 'inv_img') {
                alert('error', 'Only jpg, png and jpeg images are allowed!');
            } else if (this.responseText == 'upd_failed') {
                alert('error', 'Image not uploaded server down!');
            } else if (this.responseText == 'mail_failed') {
                alert('error', 'Cannot send confirmation email! Server down');
            } else if (this.responseText == 'ins_failed') {
                alert('error', 'Registeration failed! server down!');
            } else {
                alert('success', 'Registeraton successfull!');
                register_form.reset();
            }
            console.log(this.responseText);
        }
        xhr.send(data);
    })



    let login_form = document.getElementById('login_form');
    login_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();
        data.append('email_mob', login_form.elements['email_mob'].value);
        data.append('pass', login_form.elements['pass'].value);
        data.append('login', '');

        var myModal = document.getElementById('loginModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function () {
            if (this.responseText == 'inv_email_mob') {
                alert('error', 'Invalid Email or Mobile!');
            } else if (this.responseText == 'not_verified') {
                alert('error', 'Email not verified!');
            } else if (this.responseText == 'inactive') {
                alert('error', 'Account suspended Please contact to Admin!');
            } else if (this.responseText == 'inv_pass') {
                alert('error', 'Incorrect Password!');
            } else {
                let fileurl = window.location.href.split('/').pop().split('?').shift();
                if (fileurl == 'room_details.php') {
                    window.location = window.location.href;
                } else {
                    window.location = window.location.pathname;
                }
            }
            // console.log(this.responseText);
        }
        xhr.send(data);
    })


    let forgot_form = document.getElementById('forgot_form');
    forgot_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();
        data.append('email', forgot_form.elements['email'].value);
        data.append('forgot_pass', '');

        var myModal = document.getElementById('forgotModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function () {
            if (this.responseText == 'inv_email') {
                alert('error', 'Invalid Email !');
            } else if (this.responseText == 'not_verified') {
                alert('error', 'Email not verified!');
            } else if (this.responseText == 'inactive') {
                alert('error', 'Account suspended Please contact to Admin!');
            } else if (this.responseText == 'mail_failed') {
                alert('error', 'Cannot send email! Server down');
            } else if (this.responseText == 'upd_failed') {
                alert('error', 'Account recovery failed! Server down');
            } else {
                alert('success', 'Reset link sent to email!');
                forgot_form.reset();
            }
            console.log(this.responseText);
        }
        xhr.send(data);
    })

    function checkLoginToBook(status, room_id) {
        if (status) {
            window.location.href = 'confirm_booking.php?id=' + room_id;
        } else {
            alert('error', 'Please login to book room!');
        }
    }

</script>