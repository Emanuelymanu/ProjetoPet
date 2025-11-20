document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');

    // Função para atualizar o ícone do botão de alternância de tema
    const updateThemeToggleButtonIcon = (theme) => {
        if (themeToggle) {
            if (theme === 'dark') {
                themeToggle.innerHTML = '<i class="bi bi-sun"></i>'; // Ícone de sol para tema escuro
                themeToggle.title = 'Alternar para tema claro';
            } else {
                themeToggle.innerHTML = '<i class="bi bi-moon-stars"></i>'; // Ícone de lua para tema claro
                themeToggle.title = 'Alternar para tema escuro';
            }
        }
    };

    // Função para definir o tema e salvar no localStorage
    const setTheme = (theme) => {
        document.body.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        updateThemeToggleButtonIcon(theme);
    };

    // Configuração inicial:
    // O script inline em painel2.php já define o data-theme no body e no localStorage.
    // Aqui, apenas garantimos que o ícone do botão esteja correto com base no tema aplicado.
    const currentBodyTheme = document.body.getAttribute('data-theme');
    if (currentBodyTheme) {
        updateThemeToggleButtonIcon(currentBodyTheme);
    }

    // Alterna o tema ao clicar no botão
    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.body.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme);
        });
    }
});