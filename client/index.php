<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Crop Monitoring - Login</title>
    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="login-container">
        <form class="login-card login-form" novalidate>
            <div class="login-header">
                <img src="assets/images/coffee crop logo.png" alt="Coffee Crop Logo" class="login-logo">
                <h2 class="login-title">Coffee Crop Monitoring</h2>
                <div class="login-subtitle">Administrator Access</div>
            </div>

            <div class="login-error" id="loginError" style="display: none;"></div>

            <div class="login-form-group">
                <label for="username" class="login-label">Username</label>
                <input
                    id="username"
                    name="username"
                    type="text"
                    class="login-input"
                    placeholder="Enter your username"
                    autocomplete="username"
                    autofocus
                    required
                >
                <div class="login-field-error" id="username-error"></div>
            </div>

            <div class="login-form-group">
                <label for="password" class="login-label">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="login-input"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
                <div class="login-field-error" id="password-error"></div>
            </div>

            <button type="submit" class="login-button">Sign in</button>
        </form>
    </div>

    <style>
        /* ===============================
           ROOT VARIABLES
           =============================== */
        :root {
            --dark-green: #055035;
            --dark-brown: #6b4423;
            --light-gray: #f5f5f5;
            --border-gray: #e9ecef;
            --error-red: #b00020;
            --shadow-color: rgba(0, 0, 0, 0.15);
            --font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* ===============================
           GLOBAL STYLES
           =============================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }

        /* ===============================
           LOGIN PAGE CONTAINER
           =============================== */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.5)), url('assets/images/bg1.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 20px;
        }

        /* ===============================
           LOGIN CARD (FORM)
           =============================== */
        .login-card {
            background: white;
            padding: 2rem;
            padding-bottom: 3rem;
            border-radius: 8px;
            box-shadow: 0 10px 20px var(--shadow-color);
            width: 100%;
            max-width: 400px;
            border: 1px solid var(--border-gray);
        }

        /* ===============================
           LOGIN HEADER
           =============================== */
        .login-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2.25rem;
        }

        .login-logo {
            height: 56px;
            width: auto;
        }

        .login-title {
            font-size: 1.48rem;
            font-weight: bold;
            color: var(--dark-green);
            text-align: center;
            margin-bottom: 0.05rem;
        }

        .login-subtitle {
            font-size: 0.95rem;
            font-weight: 400;
            color: var(--dark-brown);
            text-align: center;
            margin-bottom: 0;
        }

        /* ===============================
           ERROR MESSAGE
           =============================== */
        .login-error {
            color: var(--error-red);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background-color: rgba(176, 0, 32, 0.08);
            border-radius: 4px;
            border-left: 3px solid var(--error-red);
        }

        /* ===============================
           FORM GROUP
           =============================== */
        .login-form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        /* ===============================
           LABEL
           =============================== */
        .login-label {
            font-weight: 400;
            color: var(--dark-green);
            font-size: 0.9rem;
            display: block;
            margin-bottom: 0;
        }

        /* ===============================
           INPUT FIELD
           =============================== */
        .login-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid var(--border-gray);
            font-size: 0.9rem;
            font-family: inherit;
            outline: none;
            transition: all 0.3s ease;
            background-color: #fff;
        }

        .login-input:focus {
            border-color: var(--dark-green);
            box-shadow: 0 0 0 3px rgba(5, 80, 53, 0.08);
        }

        .login-input:hover:not(:focus) {
            border-color: #d0d0d0;
        }

        .login-input::placeholder {
            color: #999;
            font-weight: 500;
        }

        /* Error state for input */
        .login-input.error {
            border-color: var(--error-red);
            box-shadow: 0 0 0 3px rgba(176, 0, 32, 0.08);
        }

        /* ===============================
           FIELD ERROR MESSAGE
           =============================== */
        .login-field-error {
            color: var(--error-red);
            font-size: 0.85rem;
            margin-top: 0.15rem;
            margin-bottom: 0;
            min-height: 0;
        }

        /* ===============================
           SUBMIT BUTTON
           =============================== */
        .login-button {
            width: 100%;
            padding: 0.75rem 1rem;
            margin-top: 0.75rem;
            border-radius: 8px;
            border: none;
            background-color: var(--dark-green);
            color: white;
            font-weight: 700;
            font-size: 0.95rem;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-button:hover:not(:disabled) {
            background-color: #033d2a;
            box-shadow: 0 4px 12px rgba(5, 80, 53, 0.3);
        }

        .login-button:active:not(:disabled) {
            transform: scale(0.98);
        }

        .login-button:disabled {
            opacity: 0.85;
            cursor: not-allowed;
            filter: grayscale(0.1);
        }

        /* ===============================
           RESPONSIVE DESIGN
           =============================== */
        @media (max-width: 480px) {
            .login-card {
                padding: 1.5rem;
                padding-bottom: 2rem;
                margin: 1rem;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .login-input {
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }
    </style>

    <script>
        // Configuration
        const API_BASE_URL = 'http://localhost:5000/api';
        const LOGIN_ENDPOINT = `${API_BASE_URL}/auth/login`;

        // Get form elements
        const loginForm = document.querySelector('.login-form');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const loginError = document.getElementById('loginError');
        const usernameError = document.getElementById('username-error');
        const passwordError = document.getElementById('password-error');
        const loginButton = document.querySelector('.login-button');

        // Form submission handler
        loginForm.addEventListener('submit', handleLogin);

        async function handleLogin(e) {
            e.preventDefault();
            
            // Clear previous errors
            clearErrors();
            
            // Get form values
            const username = usernameInput.value.trim();
            const password = passwordInput.value.trim();
            
            // Validate inputs
            if (!username) {
                showFieldError(usernameInput, 'Username is required');
                return;
            }
            
            if (!password) {
                showFieldError(passwordInput, 'Password is required');
                return;
            }
            
            // Disable button while submitting
            loginButton.disabled = true;
            loginButton.textContent = 'Signing in...';
            
            try {
                const response = await fetch(LOGIN_ENDPOINT, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ username, password })
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    // Show error message
                    showError(data.error || 'Login failed. Please try again.');
                    loginButton.disabled = false;
                    loginButton.textContent = 'Sign in';
                    return;
                }
                
                // Store token in localStorage
                if (data.token) {
                    localStorage.setItem('authToken', data.token);
                    localStorage.setItem('user', JSON.stringify(data.user));
                    
                    // Redirect to layout/dashboard page
                    window.location.href = 'src/layout/layout.php';
                } else {
                    showError('No token received. Please try again.');
                    loginButton.disabled = false;
                    loginButton.textContent = 'Sign in';
                }
            } catch (error) {
                console.error('Login error:', error);
                showError('Connection error. Please check if the server is running.');
                loginButton.disabled = false;
                loginButton.textContent = 'Sign in';
            }
        }
        
        function clearErrors() {
            loginError.style.display = 'none';
            loginError.textContent = '';
            usernameInput.classList.remove('error');
            passwordInput.classList.remove('error');
            usernameError.textContent = '';
            passwordError.textContent = '';
        }
        
        function showError(message) {
            loginError.textContent = message;
            loginError.style.display = 'block';
        }
        
        function showFieldError(inputElement, message) {
            const fieldErrorId = inputElement.id + '-error';
            const fieldError = document.getElementById(fieldErrorId);
            
            inputElement.classList.add('error');
            if (fieldError) {
                fieldError.textContent = message;
            }
        }
    </script>
</body>
</html>
