function validateForm() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    if (username.length < 3 || password.length < 6) {
        alert("Username must be at least 3 characters and password at least 6 characters.");
        return false; }
        return true;
    }
