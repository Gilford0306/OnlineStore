const themeToggle = document.querySelector('#theme-toggle');
const body = document.body;

// Проверка сохраненной темы в localStorage при загрузке страницы
const savedTheme = localStorage.getItem('theme');
if (savedTheme) {
    body.classList.add(savedTheme);
}

// Обработчик события для переключения темы
themeToggle.addEventListener('click', () => {
    if (body.classList.contains('dark-theme')) {
        body.classList.remove('dark-theme');
        localStorage.setItem('theme', 'light-theme');
    } else {
        body.classList.add('dark-theme');
        localStorage.setItem('theme', 'dark-theme');
    }
});