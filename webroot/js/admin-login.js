// JavaScript logic for Admin Login page
document.addEventListener('DOMContentLoaded', function() {
    
    const themeToggleBtn = document.getElementById('theme-toggle');
    const themeIcon = document.getElementById('theme-icon');
    const htmlElement = document.documentElement; // Targets the <html> tag

    // Function to check and apply saved theme on load
    function checkStoredTheme() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            if (savedTheme === 'light') {
                htmlElement.setAttribute('data-theme', 'light');
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                htmlElement.removeAttribute('data-theme'); // default (dark)
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
        }
    }

    // Call function on load to apply saved theme
    checkStoredTheme();

    themeToggleBtn.addEventListener('click', function() {
        // Check current theme
        const currentTheme = htmlElement.getAttribute('data-theme');
        
        if (currentTheme === 'light') {
            // Switch to Dark Mode
            htmlElement.removeAttribute('data-theme');
            themeIcon.classList.remove('fa-sun');
            themeIcon.classList.add('fa-moon');
            localStorage.setItem('theme', 'dark'); // Save user preference
        } else {
            // Switch to Light Mode
            htmlElement.setAttribute('data-theme', 'light');
            themeIcon.classList.remove('fa-moon');
            themeIcon.classList.add('fa-sun');
            localStorage.setItem('theme', 'light'); // Save user preference
        }
    });

});