const inputs = document.querySelectorAll(".input");

// Input focus/blur styling
function addcl() {
  let parent = this.parentNode.parentNode;
  parent.classList.add("focus");
}

function remcl() {
  let parent = this.parentNode.parentNode;
  if (this.value === "") {
    parent.classList.remove("focus");
  }
}

inputs.forEach(input => {
  input.addEventListener("focus", addcl);
  input.addEventListener("blur", remcl);
});

// Toggle password checkbox
document.getElementById("showPassword").addEventListener("change", function () {
  const passwordInput = document.getElementById("password");
  passwordInput.type = this.checked ? "text" : "password";
});

// Fade out login error
document.addEventListener("DOMContentLoaded", function () {
  const errorElement = document.getElementById("loginError");
  if (errorElement) {
    setTimeout(() => {
      errorElement.classList.add("fade-out");
      setTimeout(() => errorElement.style.display = "none", 500);
    }, 3000);
  }
});
