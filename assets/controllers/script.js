document.addEventListener("DOMContentLoaded", () => {
    const emailInput = document.getElementById('email');
    const emailText = document.querySelector('#isEmailValid');
    if (emailInput) {
        emailInput.addEventListener('change', () => {
            const email = emailInput.value.trim();
            if (!validateEmail(email)) {
                emailText.textContent = 'Email invalide !';
            } else {
                emailText.textContent =  '';
            }
        });
    }
})
document.addEventListener("DOMContentLoaded", () => {
    const passwordInput = document.getElementById('password');
    const passwordText = document.querySelector('#isPassValid');
    if (passwordInput) {
        passwordInput.addEventListener('change', () => {
            const password = passwordInput.value.trim();
            if (!validatePass(password)) {
                passwordText.textContent = 'Mot de passe invalide !';
            } else {
               passwordText.textContent =  '';
            }
        });
    }
})

document.addEventListener("DOMContentLoaded", () => {
    const confirmPasswordInput = document.getElementById('confirm-password');
    const confirmPasswordText = document.querySelector('#isPassSame');
    if (confirmPasswordInput) {
        confirmPasswordInput.addEventListener('change', () => {
            const confirmPassword = confirmPasswordInput.value.trim();
            if (!validatePass(confirmPassword)) {
                confirmPasswordText.textContent   = 'Mots de passe non identiques !';
            } else {
                confirmPasswordText .textContent  = '';
            }
        });
    }
})


function validatePass(pass) {
    let reg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
    return reg.test(pass);
}

function validateEmail(email) {
    let reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return reg.test(email);
}
  
// A faire sur select ?
document.addEventListener("DOMContentLoaded", () => {
    const titleInput = document.getElementById('title');
    const titleText = document.querySelector('#isTitleValid');
     if (titleInput) {
        titleInput.addEventListener('change', () => {
            const title = titleInput.value.trim();
            if (title.length > 26 || title.length < 5) {
            titleText.textContent = 'Le titre doit être compris entre 5 et 25 caractères.';
            } else {
              titleText.textContent = '';   
            }
        });
    }
})

document.addEventListener("DOMContentLoaded", () => {
    const priceInput = document.getElementById('price');
    const priceText = document.querySelector('#isPriceValid');
    if (priceInput) {
        priceInput.addEventListener('change', () => {
            const price = parseFloat(priceInput.value);
            if (isNaN(price) || price < 0) {
             priceText.textContent  = 'Le prix doit être un nombre positif.'
            } else {
            priceText.textContent = ''
            }
        });
    }
})

document.addEventListener("DOMContentLoaded", () => {
    const locationInput = document.getElementById('location');
    const locationText =document.querySelector('#isLocationValid');
    if (locationInput) {
        locationInput.addEventListener('change', () => {
            const location = locationInput.value.trim();
            if (location.length > 26 || location.length < 3) {
            locationText.textContent = 'Le nom de la ville doit être comprise entre 3 et 25 caractères.'
            } else {
               locationText.textContent = '' 
            }
        });
    }
})
  
document.addEventListener("DOMContentLoaded", () => {
    const descriptionInput = document.getElementById('description');
    const descriptionText = document.querySelector('#isDescriptionValid');
    if (descriptionInput) {
        descriptionInput.addEventListener('change', () => {
            const description = descriptionInput.value.trim();
            if (description.length > 101 || description.length < 25) {
            descriptionText.textContent = 'La description doit être comprise entre 25 et 100 caractères.'
            } else {
            descriptionText.textContent = ''
            }
        });
    }
})


     