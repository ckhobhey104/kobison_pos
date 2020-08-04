const DOMAIN = "http://localhost/kobison_pharmacy/public_html";

const http = new ProcessHttp();

// Function to show Alert
function showAlert(message, className, element, before) {
  const div = document.createElement("div");
  div.className = `alert ${className}`;
  div.appendChild(document.createTextNode(message));
  // const container = document.querySelector('.container');
  const container = document.querySelector(element);
  // const card = document.querySelector('.card-register');
  const card = document.querySelector(before);
  container.insertBefore(div, card);
  setTimeout(function () {
    document.querySelector(".alert").remove();
  }, 3000);
}
//Clear Fields
function clearFields() {
  document.getElementById("fullName").value = "";
  document.getElementById("email").value = "";
  document.getElementById("userName").value = "";
  document.getElementById("inputPassword").value = "";
  document.getElementById("confirmPassword").value = "";
  document.getElementById("usertype").value = "";
}
const register_user_form = document.getElementById("register_user_form");
const login_user_form = document.getElementById("login_user_form");
if (register_user_form !== null) {
  register_user_form.addEventListener("submit", registerUser);
}
if (login_user_form !== null) {
  login_user_form.addEventListener("submit", loginUser);
}
const edit_user_form = document.getElementById("editUserProfileForm");
if (edit_user_form !== null) {
  edit_user_form.addEventListener("submit", editUserProfile);
}
const userProfileTable = document.getElementById("users_profile");
if (userProfileTable !== null) {
  userProfileTable.addEventListener("click", getUserInfo);
}
const userPasswordForm = document.getElementById("changeUserPasswordForm");
if (userPasswordForm !== null) {
  userPasswordForm.addEventListener("submit", changeUserPassword);
}

function registerUser() {
  const fullname = document.getElementById("fullName");
  const email = document.getElementById("email");
  const username = document.getElementById("userName");
  const password = document.getElementById("inputPassword");
  const confirmPassword = document.getElementById("confirmPassword");
  const usertype = document.getElementById("usertype");

  //Check if username is empty
  if (fullname.value.length < 6) {
    showAlert("Fullname too short", "error", ".container", ".card-register");
  } else if (username.value.length < 3) {
    showAlert("Username too short", "error", ".container", ".card-register");
  } else if (password.value.length < 6) {
    showAlert(
      "Password length too short",
      "error",
      ".container",
      ".card-register"
    );
  } else if (password.value !== confirmPassword.value) {
    showAlert(
      "Passwords do not match",
      "error",
      ".container",
      ".card-register"
    );
  } else {
    const data = {
      fullname: fullname.value,
      email: email.value,
      username: username.value,
      password: confirmPassword.value,
      usertype: usertype.value,
    };

    http.post(DOMAIN + "/includes/process.php", data, function (err, post) {
      if (err) {
        showAlert(err, "error", ".container", ".card-register");
      } else {
        console.log(post);
        showAlert(post, "success", ".container", ".card-register");
        clearFields();
      }
    });
  }
}

function loginUser() {
  const email = document.getElementById("inputEmail");
  const password = document.getElementById("inputPassword");
  const data = {
    loginEmail: email.value,
    loginPass: password.value,
  };
  document.querySelector(".overlay").style.display = "block";
  http.post(DOMAIN + "/includes/process.php", data, function (err, post) {
    if (err) {
      document.querySelector(".overlay").style.display = "none";
      showAlert(err, "error", ".container", ".card-login");
    } else {
      if (post === "LOGIN_SUCCESSFUL") {
        document.querySelector(".overlay").style.display = "none";
        window.location.href = DOMAIN + "/users_dashboard.php";
      } else {
        document.querySelector(".overlay").style.display = "none";
        showAlert("Invalid Credentials", "error", ".container", ".card-login");
        email.value = "";
        password.value = "";
      }

      console.log(post);
    }
  });
}
// GET USER INFO
function getUserInfo(e) {
  if (e.target.classList.contains("edit_user_profile")) {
    let details = e.target.getAttribute("edit_details");
    let data = [];
    data = details.split(",");
    document.getElementById("userProfileName").textContent = data[1];
    document.getElementById("edit_user_id").value = data[0];
    document.getElementById("edit_fullname").value = data[1];
    document.getElementById("edit_username").value = data[3];
    document.getElementById("edit_email").value = data[2];
    document.getElementById("edit_user_type").value = data[4];
    document.getElementById("edit_user_status").value = data[5];
  } else if (e.target.classList.contains("change_user_pass")) {
    let details = e.target.getAttribute("change_details");
    let data = [];
    data = details.split(",");
    document.getElementById("user_id_pwd").value = data[0];
    document.getElementById("changePasswordProfileName").textContent = data[1];
  }
}
// EDIT USER PROFILE
function editUserProfile() {
  let data = {
    edit_user_id: document.getElementById("edit_user_id").value,
    edit_fullname: document.getElementById("edit_fullname").value,
    edit_username: document.getElementById("edit_username").value,
    edit_email: document.getElementById("edit_email").value,
    edit_user_type: document.getElementById("edit_user_type").value,
    edit_user_status: document.getElementById("edit_user_status").value,
  };
  http.put(DOMAIN + "/includes/process.php?editUsersProfile", data, function (
    err,
    put
  ) {
    if (err) {
      console.log(err);
    } else {
      window.location.href = DOMAIN + "/viewUserProfile.php?msg=" + put;
    }
  });
}

function changeUserPassword() {
  let data = {
    change_id: document.getElementById("user_id_pwd").value,
    oldPwd: document.getElementById("old_password").value,
    newPwd: document.getElementById("new_password").value,
  };
  http.put(DOMAIN + "/includes/process.php?changeUserPassword", data, function (
    err,
    put
  ) {
    if (err) {
      console.log(err);
    } else {
      window.location.href = DOMAIN + "/viewUserProfile.php?msg=" + put;
    }
  });
}
