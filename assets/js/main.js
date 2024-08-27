document.getElementById("form").addEventListener("submit", function(event) {
  event.preventDefault();

  const formData = new FormData(this);
  const urlEncodedData = new URLSearchParams();

  // Converte o FormData em URL-encoded
  formData.forEach((value, key) => {
      urlEncodedData.append(key, value);
  });

  fetch('https://legalizefacil.com/api/', {
      method: 'POST',
      headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: urlEncodedData.toString() // Envia os dados como string URL-encoded
  })
  .then(response => response.json())
  .then(data => {
      if (data.next) {
          mostrarNotification(data.message, "success");
      } else {
          mostrarNotification(data.message, "error");
      }
  })
  .catch(error => {
      console.error("Erro ao enviar os dados:", error);
      mostrarNotification("Erro ao enviar os dados. Tente novamente.", "error");
  });
});

function mostrarNotification(mensagem, tipo) {
  const notification = document.createElement('div');
  notification.classList.add('notification');
  
  if (tipo === "success") {
      notification.style.backgroundColor = "rgb(0, 252, 0)";
  } else if (tipo === "error") {
      notification.style.backgroundColor = "#f44336";
  }
  
  notification.innerText = mensagem;
  
  document.body.appendChild(notification);

  setTimeout(() => {
      notification.classList.add('show');
  }, 100);

  setTimeout(() => {
      notification.classList.remove('show');
      setTimeout(() => {
          notification.remove();
      }, 400);
  }, 3000);
}
