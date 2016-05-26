[![Build Status](https://travis-ci.org/refaktormagazin/blog.svg?branch=master)](https://travis-ci.org/refaktormagazin/blog)

A Refaktor Magazin tiszta kód sorozathoz készült egyszerű blogmotor. Sajnos a projekt egy része nincs 
egységtesztelve, mert a kódrészek egy másik projektből kerültek átemelésre.

Üzembe helyezés:

- Töltsd le a forráskódot
- Készítsd el a config/local.php fájlt a minta alapján
- Futtasd le a bin/migrate.php fájlt
- Indítsd el a fejlesztői PHP szervert a htdocs mappában: php -S 127.0.0.1:8000
- Nyisd meg a http://localhost:8000 oldalt a böngésződben.