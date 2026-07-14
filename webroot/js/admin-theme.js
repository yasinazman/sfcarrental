document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('darkModeToggle');
    const htmlTag = document.documentElement;

    if (toggleBtn) {
        toggleBtn.addEventListener('click', () => {
            let currentTheme = htmlTag.getAttribute('data-theme');
            let newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            htmlTag.setAttribute('data-theme', newTheme);
            
            localStorage.setItem('sf_theme', newTheme);
        });
    }
});