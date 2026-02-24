/**
 * Account Settings - Security
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
    (function () {
        const formChangePass = document.querySelector('#formChangePassword');

        // Form validation for Change password
        if (formChangePass) {
            const fv = FormValidation.formValidation(formChangePass, {
                fields: {
                    current_password: {
                        validators: {
                            notEmpty: {
                                message: 'Please current password'
                            },
                            stringLength: {
                                min: 4,
                                message: 'Password must be more than 4 characters'
                            }
                        }
                    },
                    password: {
                        validators: {
                            notEmpty: {
                                message: 'Please enter new password'
                            },
                            stringLength: {
                                min: 8,
                                message: 'Password must be more than 8 characters'
                            }
                        }
                    },
                    password_confirmation: {
                        validators: {
                            notEmpty: {
                                message: 'Please confirm new password'
                            },
                            identical: {
                                compare: function () {
                                    return formChangePass.querySelector('[name="password"]').value;
                                },
                                message: 'The password and its confirm are not the same'
                            },
                            stringLength: {
                                min: 8,
                                message: 'Password must be more than 8 characters'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap5: new FormValidation.plugins.Bootstrap5({
                        eleValidClass: '',
                        rowSelector: '.form-control-validation'
                    }),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    autoFocus: new FormValidation.plugins.AutoFocus()
                },
                init: instance => {
                    instance.on('plugins.message.placed', function (e) {
                        if (e.element.parentElement.classList.contains('input-group')) {
                            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                        }
                    });
                }
            });
        }
    })();
});
