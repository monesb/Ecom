function validateForm() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirm-password").value;
    var errorMsg = document.getElementById("error-msg");

    if (password !== confirmPassword) {
        errorMsg.textContent = "Les mots de passe ne correspondent pas.";
        errorMsg.style.color = "red";
        return false; // Empêche l'envoi du formulaire si les mots de passe ne correspondent pas
    }
    return true; // Continue l'envoi du formulaire si tout va bien
}

