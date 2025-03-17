document.addEventListener("DOMContentLoaded", function () {

    const showErrorMessage = (message, elementName) => {
        const formElement = document.querySelector(`[name="${elementName}"]`);
        if (formElement) {
            formElement.classList.add("is-invalid");

            let errorElement = formElement.closest(".mb-3").querySelector(".invalid-feedback");
            if (!errorElement) {
                errorElement = document.createElement("div");
                errorElement.classList.add("invalid-feedback");
                formElement.closest(".mb-3").appendChild(errorElement);
            }
            errorElement.innerText = message;
        }
    };

    const clearFormErrors = () => {
        const invalidFields = document.querySelectorAll(".is-invalid");
        invalidFields.forEach((field) => {
            field.classList.remove("is-invalid");

            const errorElement = field.closest(".mb-3").querySelector(".invalid-feedback");
            if (errorElement) {
                errorElement.remove();
            }
        });
    };

    const showAuthErrorMessage = (message) => {
        let existingErrorElement = document.querySelector('.auth-error-message');
        if (existingErrorElement) existingErrorElement.remove();

        const errorAlert = document.createElement('div');
        errorAlert.classList.add('alert', 'alert-danger', 'auth-error-message');
        errorAlert.innerText = message;

        const form = document.querySelector('form');
        if (form) {
            form.insertBefore(errorAlert, form.firstChild);
        }
    };

    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error === 'unauthorized') {
        showAuthErrorMessage('Необходимо войти в систему. Пожалуйста, авторизуйтесь.');
    }

    const fetchForm = (formId, callback) => {
        const form = document.getElementById(formId);
        if (!form) return;

        const path = form.getAttribute('action');
        const method = form.getAttribute('method');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const values = {};
            clearFormErrors();

            Array.from(form.elements).forEach((element) => {
                if (element.tagName === 'INPUT' && element.name) {
                    values[element.name] = element.value;
                    element.classList.remove("is-invalid");
                    const errorElement = element.closest(".mb-3").querySelector(".invalid-feedback");
                    if (errorElement) errorElement.remove();
                }
            });

            const response = await fetch(path, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(values),
            });

            if (!response.ok) {
                const jsonResponse = await response.json();
                if (response.status === 401) {
                    showAuthErrorMessage(jsonResponse.message || 'Неверные данные для входа.');
                } else if (jsonResponse.errors) {
                    Object.entries(jsonResponse.errors).forEach(([key, value]) => {
                        showErrorMessage(value, key);
                    });
                } else if (jsonResponse.message) {
                    showAuthErrorMessage(jsonResponse.message);
                }
                return;
            }

            callback(response);
        });
    };

    fetchForm('register-form', () => {
        window.location.href = '/login';
    });

    fetchForm('login-form', () => {
        window.location.href = '/dashboard';
    });

    // Обработчик формы выхода
    fetchForm('logout-form', () => {
        window.location.href = '/login';
    });
});
