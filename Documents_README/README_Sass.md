Adiktionstudio@DESKTOP-U14HNLN MINGW64 /c/ENV/ecoride/app (feature/live-sass-complier)
$ php bin/console sass:build --watch

Parfait — tu as bien suivi les étapes 👍
Mais ici, on voit deux indices importants :

can't cd to /etc/ssl/certs
et
Error setting certificate file: /etc/ssl/certs/ca-certificates.crt

➡️ Cela veut dire que ton conteneur PHP n’a même pas le dossier /etc/ssl/certs (ou il a été vidé dans ton image Docker).
C’est pourquoi curl ne trouve pas de certificat à utiliser pour HTTPS.

🧩 1. Vérifie si le dossier existe

Dans ton conteneur, tape :

ls -l /etc/ssl


S’il te dit No such file or directory, alors on va le recréer à la main 👇

🧰 2. Corriger manuellement (solution express)

Toujours dans ton conteneur :

mkdir -p /etc/ssl/certs
apt-get install --reinstall -y ca-certificates
update-ca-certificates


Puis relance :

php bin/console sass:build --watch


👉 Cette fois, la commande devrait télécharger Dart Sass correctement depuis GitHub.

💡 3. (Optionnel mais conseillé)

Si ça refait la même erreur après ça, on peut forcer Symfony à ignorer SSL pour le téléchargement (non recommandé, mais utile pour tester) :

php -d curl.cainfo= php bin/console sass:build --watch

🧱 4. Si ça marche, pérennise-le

Tu pourras ensuite ajouter ceci à ton Dockerfile PHP pour éviter le problème à chaque build :

RUN apt-get update && \
    apt-get install -y ca-certificates curl && \
    mkdir -p /etc/ssl/certs && \
    update-ca-certificates

    