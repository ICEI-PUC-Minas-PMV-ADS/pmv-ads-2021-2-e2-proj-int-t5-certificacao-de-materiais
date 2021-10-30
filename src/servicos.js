//Formulario

function formSubmit(evento) {
    const formData = new FormData(evento.target);
    const {tipo, nome, email, telefone, localizacao, mensagem} = {...Object.fromEntries(formData.entries())};

    if (tipo) {
        gravar({tipo, nome, email, telefone, localizacao, mensagem});
        evento.target.reset();
    }
}

function gravar(informacao) {
    const tipo = informacao.tipo;
    let tabela = JSON.parse(window.localStorage.getItem("db_cadastros")) ?? {};

    if (tabela.registros && Array.isArray(tabela.registros)) {
        tabela.registros.push({id: tabela.registros.length + 1, ...informacao});
    } else {
        tabela.registros = [({id: 1, ...informacao})];
    }

    window.localStorage.setItem("db_cadastros", JSON.stringify(tabela));

    carregarConstrutorasLaboratorios();
}

function recuperar(tipo) {
    let tabela = JSON.parse(window.localStorage.getItem("db_cadastros")) ?? {}
    return tabela.registros;
}

function carregarConstrutorasLaboratorios() {
    const listaResultados = document.querySelector("#lista-resultados");

    while(listaResultados.tBodies[0].firstChild) {
        listaResultados.tBodies[0].removeChild(listaResultados.tBodies[0].firstChild);
    };

    let resultados = recuperar("construtoras");

    for(let resultado of resultados) {
        let tr = listaResultados.tBodies[0].insertRow();
        let {id, nome, email, localizacao, tipo} = resultado;
        let colunas = [id, nome, email, localizacao, tipo];
        for(let coluna of colunas) {
            let td = tr.insertCell();
            let content = document.createTextNode(coluna);
            td.appendChild(content);
        }
    }
}

window.onload = function() {
    carregarConstrutorasLaboratorios();
}
