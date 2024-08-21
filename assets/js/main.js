document.getElementById("form").addEventListener("submit", function(event) {
    event.preventDefault();

    const formData = new FormData(this);
  
    fetch('URL_DO_SEU_BACKEND', {
        method: 'POST',
        body: formData 
      })
      .then(response => response.text())
      .then(data => {
        document.getElementById("resposta").innerText = "Resposta do servidor: " + data;
      })
      .catch(error => {
        console.error("Erro ao enviar os dados:", error);
        document.getElementById("resposta").innerText = "Erro ao enviar os dados.";
      });
    });
  