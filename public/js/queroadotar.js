function queroadotar(idPet,url){
    if(confirm('Vamos enviar um email ao doador informando o seu contato e interesse na adoção. Você confirma?')) {
        const data = {id: idPet};

        fetch(url, {
        method: "post",
        body: JSON.stringify(data),
        })
        .then((response) => response)
        .then((data) => {
            console.log("Success:", data);
        })
        .catch((error) => {
            console.log("Error:", error);
        });
    }
}