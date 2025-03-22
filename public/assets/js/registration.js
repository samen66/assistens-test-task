document.addEventListener('DOMContentLoaded', function () {
    const registrationForm = document.getElementById('registration-form');
    const passwordInput = registrationForm.querySelector('input[name="password"]');
    const confirmPasswordInput = registrationForm.querySelector('input[name="confirm_password"]');

    // Function to display error message
    const showError = (input, message) => {
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('error-message');
        errorMessage.textContent = message;
        input.classList.add('error-input');
        input.parentNode.insertBefore(errorMessage, input);
    };

    // Function to remove error message
    const removeError = (input) => {
        const error = input.parentNode.querySelector('.error-message');
        if (error) {
            error.remove();
        }
        input.classList.remove('error-input');
    };

    // Form submission event
    registrationForm.addEventListener('submit', async function (event) {
        event.preventDefault();
        let isValid = true;

        // Remove previous errors
        removeError(passwordInput);
        removeError(confirmPasswordInput);

        // Check password length
        if (passwordInput.value.length < 8) {
            showError(passwordInput, 'Password must be at least 8 characters.');
            isValid = false;
        }

        // Check password match
        if (passwordInput.value !== confirmPasswordInput.value) {
            showError(confirmPasswordInput, 'Passwords do not match.');
            isValid = false;
        }

        if (isValid) {
            const formData = new FormData(registrationForm);
            const response = await fetch('/registration', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.errors) {
                showError(registrationForm.querySelector('input[name="email"]'), result.errors.email);
            } else {
                window.location.href = '/login';
            }
        }
    });

    // Remove error on input
    passwordInput.addEventListener('input', () => removeError(passwordInput));
    confirmPasswordInput.addEventListener('input', () => removeError(confirmPasswordInput));
});