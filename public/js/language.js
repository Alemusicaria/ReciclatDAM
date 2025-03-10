document.addEventListener('DOMContentLoaded', function () {
    const languageDropdownItems = document.querySelectorAll('.dropdown-item[data-lang]');
    languageDropdownItems.forEach(item => {
        item.addEventListener('click', function () {
            const newLanguage = this.getAttribute('data-lang');
            localStorage.setItem('language', newLanguage);

            fetch('/set-locale', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ locale: newLanguage })
            }).then(() => {
                location.reload(); // Reload to apply the new language
            });
        });
    });
});