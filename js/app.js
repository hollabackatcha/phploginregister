const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

signUpButton.addEventListener('click', () => {
  container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
  container.classList.remove("right-panel-active");
});

const showError = (message) => {
  const box = document.querySelector("#error_box");
  const p = document.querySelector("#error_box>p");
  p.innerText = message;
  box.classList.remove("hidden");
  box.classList.add("show");
};

const hideError = () => {
  const box = document.querySelector("#error_box");
  box.classList.remove("show");
  box.classList.add("hidden");
};

(function () {
  "use strict";

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll(".needs-validation");

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms).forEach(function (form) {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }

        form.classList.add("was-validated");
      },
      false
    );
  });
})();

document.querySelector('input#input_register-cnfm-pwd').addEventListener('input', (event) => {
  password = document.getElementById('input_register-pwd').value;
  if (event.target.value === password) {
    event.target.setCustomValidity("");
  } else {
    event.target.setCustomValidity("Passwords don't match.");
  }
})

document.getElementById("frm-register").addEventListener("submit", function (evt) {
  var response = grecaptcha.getResponse();
  if (response.length == 0) {
    showError('Captcha not verified!');
    evt.preventDefault();
    return false;
  }
});