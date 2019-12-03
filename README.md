# emag-pingr

Dezvoltat pentru a verifica preturile produselor de pe emag.ro. Genereaza alerte cand scad preturile produselor inregistrate in `urls.txt`.

## Necesitati

In primul rand, e scris in PHP, deci aveti nevoie de acces la un server cu PHP 5.4+ instalat.

Pentru a crea mai usor request-uri ce tin cont de cookie-urile generate de emag, am folosit un tool numit Guzzle. Pentru asta, aveti nevoie [Composer](https://getcomposer.org/download/).

## Pasii de instalare

1. Descarcati sursa: 