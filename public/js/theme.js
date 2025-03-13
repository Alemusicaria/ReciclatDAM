document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('theme-toggle');
    const currentTheme = localStorage.getItem('theme') || 'light';
    document.body.classList.add(currentTheme);
    document.querySelector('nav').classList.add(currentTheme);

    themeToggle.addEventListener('click', function () {
        const newTheme = document.body.classList.contains('light') ? 'dark' : 'light';
        document.body.classList.remove('light', 'dark');
        document.body.classList.add(newTheme);
        document.querySelector('nav').classList.remove('light', 'dark');
        document.querySelector('nav').classList.add(newTheme);
        localStorage.setItem('theme', newTheme);
    });
});