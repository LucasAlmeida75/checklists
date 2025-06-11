function compararSenhas() {
    const password        = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;

    if (password !== confirmPassword) {
        event.preventDefault();
        alert('As senhas não coincidem. Por favor, tente novamente.');
    }
}

window.onload = function() {
    document.getElementById('registerForm').addEventListener('submit', compararSenhas);
}
