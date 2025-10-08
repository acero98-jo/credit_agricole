// Gestion du formulaire de connexion
document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm")

  if (loginForm) {
    loginForm.addEventListener("submit", function (e) {
      e.preventDefault()

      const clientNumber = document.getElementById("clientNumber").value
      const remember = document.getElementById("remember").checked

      // Validation basique
      if (clientNumber.length < 2 || clientNumber.length > 10) {
        alert("Le numéro client doit contenir entre 2 et 10 chiffres")
        return
      }

      // Soumettre le formulaire
      this.submit()
    })
  }

  // Gestion du modal sur la page dashboard
  const modal = document.getElementById("blockModal")

  if (modal) {
    // Afficher le modal après 2 secondes
    setTimeout(() => {
      modal.style.display = "flex"
    }, 2000)

    // Fermer le modal avec le bouton "Plus tard"
    const btnSecondary = modal.querySelector(".btn-secondary")
    if (btnSecondary) {
      btnSecondary.addEventListener("click", () => {
        modal.style.display = "none"
      })
    }

    // Gestion du bouton "Vérifier mon identité"
    const btnPrimary = modal.querySelector(".btn-primary")
    if (btnPrimary) {
      btnPrimary.addEventListener("click", () => {
        alert("Redirection vers la vérification d'identité...")
        modal.style.display = "none"
      })
    }

    // Gestion du bouton "Contacter le support"
    const btnTertiary = modal.querySelector(".btn-tertiary")
    if (btnTertiary) {
      btnTertiary.addEventListener("click", () => {
        alert("Redirection vers le support...")
        modal.style.display = "none"
      })
    }
  }

  // Mémoriser le numéro client dans localStorage
  const rememberCheckbox = document.getElementById("remember")
  const clientNumberInput = document.getElementById("clientNumber")

  if (rememberCheckbox && clientNumberInput) {
    // Charger le numéro mémorisé
    const savedNumber = localStorage.getItem("clientNumber")
    if (savedNumber) {
      clientNumberInput.value = savedNumber
      rememberCheckbox.checked = true
    }

    // Sauvegarder lors de la soumission
    loginForm.addEventListener("submit", () => {
      if (rememberCheckbox.checked) {
        localStorage.setItem("clientNumber", clientNumberInput.value)
      } else {
        localStorage.removeItem("clientNumber")
      }
    })
  }

  const logoutBtn = document.getElementById("logoutBtn")
  if (logoutBtn) {
    logoutBtn.addEventListener("click", () => {
      // Call logout.php to destroy session
      fetch("logout.php")
        .then(() => {
          // Redirect to home page
          window.location.href = "index.html"
        })
        .catch((error) => {
          console.error("Erreur lors de la déconnexion:", error)
          // Redirect anyway
          window.location.href = "index.html"
        })
    })
  }
})
