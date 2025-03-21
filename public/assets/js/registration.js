document.addEventListener('DOMContentLoaded', function () {
    const registrationForm = document.getElementById('registration-form');
    const passwordInput = registrationForm.querySelector('input[name="password"]');
    const confirmPasswordInput = registrationForm.querySelector('input[name="confirm_password"]');

    registrationForm.addEventListener('submit', function (event) {
        // Проверка паролей
        if (passwordInput.value !== confirmPasswordInput.value) {
            event.preventDefault(); // Отменяем отправку формы
        }
    });
});document.addEventListener('DOMContentLoaded', function () {
    const registrationForm = document.getElementById('registration-form');
    const passwordInput = registrationForm.querySelector('input[name="password"]');
    const confirmPasswordInput = registrationForm.querySelector('input[name="confirm_password"]');

    // Функция для отображения сообщения об ошибке
    const showError = (input, message) => {
        const errorMessage = document.createElement('div');
        errorMessage.classList.add('error-message');
        errorMessage.textContent = message;
        input.classList.add('error-input');
        input.parentNode.insertBefore(errorMessage, input);
    };

    // Функция для удаления сообщения об ошибке
    const removeError = (input) => {
        const error = input.parentNode.querySelector('.error-message');
        if (error) {
            error.remove();
        }
        input.classList.remove('error-input');
    };

    // Событие на отправку формы
    registrationForm.addEventListener('submit', function (event) {
        let isValid = true;

        // Удаляем предыдущие ошибки
        removeError(passwordInput);
        removeError(confirmPasswordInput);

        // Проверяем длину пароля
        if (passwordInput.value.length < 8) {
            showError(passwordInput, 'Password must be at least 8 characters.');
            isValid = false;
        }

        // Проверяем совпадение паролей
        if (passwordInput.value !== confirmPasswordInput.value) {
            showError(confirmPasswordInput, 'Passwords do not match.');
            isValid = false;
        }

        // Если есть ошибки, отменяем отправку формы
        if (!isValid) {
            event.preventDefault();
        }
    });

    // Событие для удаления ошибки при вводе
    passwordInput.addEventListener('input', () => removeError(passwordInput));
    confirmPasswordInput.addEventListener('input', () => removeError(confirmPasswordInput));
});