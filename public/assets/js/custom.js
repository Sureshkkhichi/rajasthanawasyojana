document.addEventListener('DOMContentLoaded', function() {
    // Check for success flash message element
    const successEl = document.getElementById('swal-success-message');
    if (successEl && typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Success!',
            text: successEl.getAttribute('data-message'),
            icon: 'success',
            confirmButtonText: 'OK',
            confirmButtonColor: '#198754'
        });
    }

    // Check for error flash message element
    const errorEl = document.getElementById('swal-error-message');
    if (errorEl && typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Error!',
            text: errorEl.getAttribute('data-message'),
            icon: 'error',
            confirmButtonText: 'OK',
            confirmButtonColor: '#dc3545'
        });
    }
});

// Livewire event listeners
document.addEventListener('livewire:init', () => {
    Livewire.on('registrationClosed', () => {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                title: 'Registration Closed!',
                text: 'We are sorry, but registrations for this project have been closed.',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            }).then(() => {
                window.location.href = "/";
            });
        }
    });
});
