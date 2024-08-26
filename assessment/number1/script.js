document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting by default

    // Get the input values
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Simple validation
    if (username === '' || password === '') {
        alert('Please enter both username and password.');
    } else {
        alert('Form submitted successfully!');
    }
});
