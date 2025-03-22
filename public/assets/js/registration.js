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

    // Remove error on input
    passwordInput.addEventListener('input', () => removeError(passwordInput));
    confirmPasswordInput.addEventListener('input', () => removeError(confirmPasswordInput));
});