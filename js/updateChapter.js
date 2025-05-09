document.addEventListener("DOMContentLoaded", () => {
    const select = document.querySelector("select[name='id_chapter']");
    const titoloInput = document.getElementById("titolo-modifica");
    const riassuntoTextarea = document.getElementById("riassunto-modifica");
  
    select.addEventListener("change", () => {
      const selectedId = select.value;
  
      fetch(`../php-actions/get_chapter_data.php?id=${selectedId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            titoloInput.placeholder = data.titolo;
            riassuntoTextarea.placeholder = data.riassunto;
          } else {
            titoloInput.placeholder = "Titolo non trovato";
            riassuntoTextarea.placeholder = "Riassunto non disponibile";
          }
        })
        .catch(error => {
          console.error("Errore nel fetch capitolo:", error);
        });
    });
  });
  