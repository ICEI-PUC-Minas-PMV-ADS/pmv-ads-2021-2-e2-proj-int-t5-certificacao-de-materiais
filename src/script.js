//console.log('hi');


function autenticar() {

    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    if (usuario_db.dados.email === email && usuario_db.dados.senha === password) {
        //  location.href = location.href.replace('login', '');
        alert('Login efetudado com sucesso');
        window.location = "index.html";
    } else {
        alert('Email ou senha inválidos');
    }
    return false;

}
