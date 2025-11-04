// assets/js/register.js

console.log("register.js chargé !");

document.addEventListener('DOMContentLoaded', () => {
  // flags
  let firstname = false;
  let lastname = false;
  let username = false;
  let email = false;
  let rgpd = false;
  let password = false;

  // éléments
  const firstnameInput = document.querySelector('#registration_form_firstname');
  const lastnameInput  = document.querySelector('#registration_form_lastname');
  const usernameInput  = document.querySelector('#registration_form_username');
  const emailInput     = document.querySelector('#registration_form_email');
  const rgpdCheckbox   = document.querySelector('#registration_form_agreeTerms');
  const passwordInput  = document.querySelector('#registration_form_plainPassword');
  const entropyElement = document.querySelector('#entropy');
  const barElement     = document.querySelector('#password-bar');
  const submitBtn      = document.querySelector('#submit-button');

  // sécurité : logs et return si éléments manquants
  if (!firstnameInput || !lastnameInput || !usernameInput || !emailInput || !rgpdCheckbox || !passwordInput || !submitBtn) {
    console.warn('register.js : un ou plusieurs éléments du formulaire sont introuvables :', {
      firstname: !!firstnameInput,
      lastname: !!lastnameInput,
      username: !!usernameInput,
      email: !!emailInput,
      rgpd: !!rgpdCheckbox,
      password: !!passwordInput,
      button: !!submitBtn
    });
    return;
  }

  // listeners
  firstnameInput.addEventListener('input', function() { firstname = this.value.trim().length >= 2; checkAll(); });
  lastnameInput.addEventListener('input',  function() { lastname  = this.value.trim().length >= 2; checkAll(); });
  usernameInput.addEventListener('input',  function() { username  = this.value.trim().length >= 3; checkAll(); });
  emailInput.addEventListener('input',     function() { email     = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.value.trim()); checkAll(); });
  rgpdCheckbox.addEventListener('change',  function() { rgpd = this.checked; checkAll(); });
  passwordInput.addEventListener('input',  function() { checkPassword(this.value); });

  function checkAll() {
    if (firstname && lastname && username && email && rgpd && password) {
      submitBtn.removeAttribute('disabled');
    } else {
      submitBtn.setAttribute('disabled', 'disabled');
    }
  }

  const PasswordStrength = {
    VERY_WEAK: 'Très faible',
    WEAK: 'Faible',
    MEDIUM: 'Moyen',
    STRONG: 'Fort',
    VERY_STRONG: 'Très fort'
  };

  function checkPassword(pwd) {
    if (!entropyElement || !barElement) return;

    const result = evaluatePasswordStrength(pwd);

    // reset classes
    entropyElement.classList.remove('text-red','text-orange','text-green');

    let width = 10;
    let color = '#e74c3c'; // red default
    switch (result) {
        case PasswordStrength.VERY_WEAK:
        case PasswordStrength.WEAK:
            entropyElement.classList.add('text-red');
            password = false;
            width = 20;
            color = '#e74c3c';
        break;
        case PasswordStrength.MEDIUM:
            entropyElement.classList.add('text-orange');
            password = false;
            width = 50;
            color = '#f39c12';
        break;
        case PasswordStrength.STRONG:
            entropyElement.classList.add('text-green');
            password = true;
            width = 80;
            color = '#2ecc71';
        break;
        case PasswordStrength.VERY_STRONG:
            entropyElement.classList.add('text-green');
            password = true;
            width = 100;
            color = '#27ae60';
        break;
    default:
        password = false;
    }

    barElement.style.width = width + '%';
    barElement.style.backgroundColor = color;
    entropyElement.textContent = result;

    checkAll();
  }

  function evaluatePasswordStrength(pwd) {
    const len = pwd.length;
    if (len === 0) return PasswordStrength.VERY_WEAK;

    const hasLower = /[a-z]/.test(pwd);
    const hasUpper = /[A-Z]/.test(pwd);
    const hasDigit = /\d/.test(pwd);
    const hasSymbol = /[^a-zA-Z0-9]/.test(pwd);

    const variety = [hasLower, hasUpper, hasDigit, hasSymbol].filter(Boolean).length;

    // Score simple : longueur * variété
    const score = len * variety;

    if (score >= 60) return PasswordStrength.VERY_STRONG;
    if (score >= 40) return PasswordStrength.STRONG;
    if (score >= 25) return PasswordStrength.MEDIUM;
    if (score >= 12) return PasswordStrength.WEAK;
    return PasswordStrength.VERY_WEAK;
  }
});
