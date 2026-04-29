// Run when typing
document.getElementById("email").addEventListener("keyup", checkEmail);
document.getElementById("password").addEventListener("keyup", checkPassword);

// Password check
function checkPassword() {
  let password = document.getElementById("password").value;
  let email = document.getElementById("email").value;
  let msg = document.getElementById("message");
  let bar = document.getElementById("strengthBar");

  let strength = 0;

  const commonPasswords = ["123456", "password", "qwerty", "abc123", "111111"];

  // Reset
  bar.className = "strength";
  bar.style.width = "0%";

  if (password.length === 0) {
    msg.innerHTML = "";
    return;
  }

  if (commonPasswords.includes(password.toLowerCase())) {
    msg.innerHTML = "❌ Very weak (common password)";
    msg.style.color = "red";
    return;
  }

  if (/(.)\1\1/.test(password)) {
    msg.innerHTML = "❌ Avoid repeated characters";
    msg.style.color = "red";
    bar.style.width = "20%";
    return;
  }

  if (email && password.includes(email.split("@")[0])) {
    msg.innerHTML = "❌ Password should not contain email name";
    msg.style.color = "red";
    bar.style.width = "20%";
    return;
  }

  if (password.length >= 8) strength++;
  if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
  if (/\d/.test(password)) strength++;
  if (/[!@#$%^&*]/.test(password)) strength++;

  if (strength <= 2) {
    msg.innerHTML = "❌ Weak password";
    msg.style.color = "red";
    bar.classList.add("weak");
  } 
  else if (strength === 3) {
    msg.innerHTML = "⚠️ Medium password";
    msg.style.color = "orange";
    bar.classList.add("medium");
  } 
  else {
    msg.innerHTML = "✅ Strong (OWASP level)";
    msg.style.color = "green";
    bar.classList.add("strong");
  }
}

// Toggle password
function togglePassword() {
  let pass = document.getElementById("password");
  pass.type = pass.type === "password" ? "text" : "password";
}

// Email validation
function checkEmail() {
  let email = document.getElementById("email").value;
  let result = document.getElementById("emailResult");

  let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  if (pattern.test(email)) {
    result.innerHTML = "Valid Email ✅";
    result.style.color = "green";
  } else {
    result.innerHTML = "Invalid Email ❌";
    result.style.color = "red";
  }
}
