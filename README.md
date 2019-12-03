# emag-pingr

Dezvoltat pentru a verifica preturile produselor de pe emag.ro. Genereaza alerte cand scad preturile produselor inregistrate in `urls.txt`.

## Necesitati

In primul rand, e scris in PHP, deci aveti nevoie de acces la un server cu PHP 5.4+ instalat.

Pentru a crea mai usor request-uri ce tin cont de cookie-urile generate de emag, am folosit un tool numit Guzzle. Pentru asta, aveti nevoie [Composer](https://getcomposer.org/download/).

## Pasii de instalare

Descarcati sursa si instalati dependintele:

```
git clone git@github.com:degecko/emag-pingr.git
cd emag-pingr
composer init # enter la toate intrebarile
composer install
```

Introduceti toate adresele produselor de care sunteti interesati intr-un fisier numit `urls.txt`.

Setati un cronjob sa ruleze index.php in fiecare ora:

```
0 * * * * cd /full/path/to/emag-pingr && php index.php > log
```

Inlocuiti `/full/path/to` cu path-ul vostru catre proiect.

## Alertele

Alertele vor fi scrise in fisierul setat in variabila `$alertsFile` din `index.php`, deci va trebui sa modificati variabila cu path-ul catre un fisier pe care vreti sa-l scrie in cazul vostru, atunci cand exista alerte.

Eu l-am pus pe desktop, pentru ca il rulez pe PC si-mi sare in ochi daca apare ceva acolo.

Daca il rulati pe-un server, ar fi o idee sa va trimiteti un email cand apare o alerta.
