class CMManager {

    async fetchTodosLaboratorios (){
        return fetch ('https://8adeac6a-e5f8-4abe-bf5b-e6ac95763bd9.mock.pstmn.io/api/LaboratorioCadastro/buscar').then(function(response){
            // // console.log(response.json())
            return response.json()})
    }

    async findbyMaterial (nomeMaterial) {
        
        // console.log('buscandoNomedoMaterial')
        // console.log(nomeMaterial)

        const todosLaboratorios = await this.fetchTodosLaboratorios()
        //criar varial de uma lista vazia
        console.log(todosLaboratorios)

        todosLaboratorios.data.forEach(element => {
                // console.log(element)
            if (element[nomeMaterial] > 0 ){
                // console.log('Esse laboratorio tem')
                //se ele entrar nesse if colocar o element na lista varia que eu cria na linha 15
            }
           
            
        });
        //retornar a lista com os laboratorios filtrados por material
    }

    async manipulateResultTableDom (){

        const table=document.querySelector('#resultTable')
        const filter=document.querySelector('#textinput')

        // console.log(filter)
        
        // const listFiltrada = await this.findbyMaterial()
        const listFiltrada = { "data": [ { "NomeLaboratorio": "laboratorio1", "CNPJ": "156465165164", "Areia": 0, "Cimento": 0, "Ferro": 1, "Endereco": "156465165164" }, { "NomeLaboratorio": "laboratorio2", "CNPJ": "156465165164", "Areia": 0, "Cimento": 0, "Ferro": 1, "Endereco": "156465165164" }, { "NomeLaboratorio": "laboratorio3", "CNPJ": "156465165164", "Areia": 0, "Cimento": 0, "Ferro": 1, "Endereco": "156465165164" }, { "NomeLaboratorio": "laboratorio4", "CNPJ": "156465165164", "Areia": 0, "Cimento": 0, "Ferro": 1, "Endereco": "156465165164" }, { "NomeLaboratorio": "laboratorio5", "CNPJ": "156465165164", "Areia": 1, "Cimento": 0, "Ferro": 1, "Endereco": "156465165164" } ] }

        // console.log(listFiltrada)

        listFiltrada.data.forEach(element => {
        
            // Insert a row at the end of the table
            let newRow = table.insertRow(-1);

            // console.log("newrow")

            // Insert a cell in the row at index 0
            let nome = newRow.insertCell(0);
            
            // console.log("nome")
            
            // Append a text node to the cell
            let nomeText = document.createTextNode(element['name']);
            nome.appendChild(nomeText);

        });
    }
}
// Triggres

var form=document.querySelector('#findform')

form.addEventListener('submit',el=>{c=new CMManager();c.manipulateResultTableDom('')})