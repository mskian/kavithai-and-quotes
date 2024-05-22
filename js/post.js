function showNotification(message, type) {
    const notificationContainer = document.getElementById('notification-container');
    const notificationClass = type === 'success' ? 'is-success' : type === 'error' ? 'is-danger' : 'is-warning';
    const notification = document.createElement('div');
    notification.className = `notification ${notificationClass}`;
    notification.innerHTML = `
        <button class="delete"></button>
        ${message}
    `;
    notificationContainer.appendChild(notification);
    notification.style.display = 'block';

    // Close notification on click
    notification.querySelector('.delete').addEventListener('click', () => {
        notification.style.display = 'none';
        notificationContainer.removeChild(notification);
    });

    // Auto close after 5 seconds
    setTimeout(() => {
        if (notificationContainer.contains(notification)) {
            notification.style.display = 'none';
            notificationContainer.removeChild(notification);
        }
    }, 5000);
}

// Function to fetch user data and determine whether to show login or register form
function checkUserStatus() {
    fetch('/api/check_user_status.php')
        .then(response => response.json())
        .then(data => {
            if (data.message === 'unauthorized') {
                // User is not logged in, show login and register forms, hide quote form
                document.getElementById('login-form').style.display = 'block';
                document.getElementById('register-form').style.display = 'block';
                document.getElementById('quote-form').style.display = 'none';
            } else {
                // User is logged in, hide login and register forms, show quote form
                document.getElementById('login-form').style.display = 'none';
                document.getElementById('register-form').style.display = 'none';
                document.getElementById('quote-form').style.display = 'block';
            }
        })
        .catch(error => {
            showNotification('Error checking user status: ' + error.message, 'error');
        });
}

// Function to register a new user
function registerUser() {
    const usernameInput = document.getElementById('register-username');
    const emailInput = document.getElementById('register-email');
    const passwordInput = document.getElementById('register-password');

    const username = usernameInput.value.trim();
    const email = emailInput.value.trim();
    const password = passwordInput.value;

    // Basic validation
    if (!username || !email || !password) {
        showNotification('Please fill in all fields', 'warning');
        return;
    }

    // Validate email format
    if (!isValidEmail(email)) {
        showNotification('Invalid email format', 'warning');
        return;
    }

    fetch('/api/register.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, email, password })
    })
    .then(response => {
        //if (!response.ok) {
        //    throw new Error('Failed to register');
        //}
        return response.json();
    })
    .then(data => {
        // Show success message
        showNotification(data.message, 'success');
        
        // Reset form fields
        usernameInput.value = '';
        emailInput.value = '';
        passwordInput.value = '';

        // Optionally, redirect or reload the page after registration
        // setTimeout(() => {
        //     window.location.reload();
        // }, 3000);
    })
    .catch(error => {
        // Show error message
        showNotification(error.message);
    });
}

// Function to check if an email is valid
function isValidEmail(email) {
    // Regular expression for validating email format
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function validateUsername(username) {
    const usernameRegex = /^[a-zA-Z0-9_]{4,20}$/;
    return usernameRegex.test(username);
}

// Function to login an existing user
function loginUser() {
    const user = document.getElementById('login-user').value;
    const password = document.getElementById('login-password').value;

    // Basic validation
    if (!user || !password) {
        showNotification('Please enter username and password', 'warning');
        return;
    }

    // If username is provided, validate its length
    if (!validateUsername(user)) {
        showNotification('Username must be between 4 and 20 characters.', 'warning');
        return;
    }

    fetch('/api/login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            "username": user,
            "password": password
        })
    })
    .then(response => {
       // if (!response.ok) {
       //     throw new Error('Failed to login');
       // }
        return response.json();
    })
    .then(data => {
        showNotification(data.message, 'success');
        // Reset form fields
        user.value = '';
        password.value = '';
        checkUserStatus();
        //setTimeout(() => {
        //     window.location.reload();
        //}, 3000);
    })
    .catch(error => {
        showNotification(error.message, 'danger');
    });
}

// Function to post a new quote
function postQuote() {
    const quoteText = document.getElementById('quote-text').value;
    const tags = document.getElementById('categorySelect').value;
    const authorName = document.getElementById('author-name').value;
    const date = document.getElementById('quote-date').value;

    // Basic validation
    if (!quoteText || !authorName || !date) {
        showNotification('Please fill in all fields', 'warning');
        return;
    }

    fetch('/api/submit.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quote_text: quoteText, author_name: authorName, date: date, tags: tags })
    })
    .then(response => {
        //if (!response.ok) {
       //     throw new Error('Failed to post quote');
        //}
        return response.json();
    })
    .then(data => {
        showNotification(data.message, 'success');
        document.getElementById('quote-text').value = '';
        document.getElementById('author-name').value = '';
        document.getElementById('quote-date').value = '';
    })
    .catch(error => {
        showNotification(error.message);
    });
}

// Call checkUserStatus function when the page loads
document.addEventListener('DOMContentLoaded', () => {
    checkUserStatus();
});

document.addEventListener('DOMContentLoaded', function() {
    const logoutButton = document.getElementById('logoutButton');

    logoutButton.addEventListener('click', function() {
        logout();
    });
});

function logout() {
    fetch('/api/logout.php', {
        method: 'GET',

    })
    .then(response => {
            return response.json();
    })
    .then(data => {
        if (data.message) {
            window.location.href = '/post';
        } else {
            showNotification(data.message);
        }
    })
    .catch(error => {
        showNotification(error.message);
    });
}