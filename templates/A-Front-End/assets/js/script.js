// Injection des composants
fetch("components/header.html")
    .then(res => res.text())
    .then(html => document.getElementById("header").innerHTML = html);

fetch("components/hero.html")
    .then(res => res.text())
    .then(html => document.getElementById("hero").innerHTML = html);

fetch("components/footer.html")
    .then(res => res.text())
    .then(html => document.getElementById("footer").innerHTML = html);

// Burger menu
document.addEventListener("click", e => {
    if (e.target.classList.contains("burger")) {
        document.querySelector(".main-nav").classList.toggle("open");
    }
});
