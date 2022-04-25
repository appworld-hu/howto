# Shop

A `Shop` egy egyedi fejlesztéső vállalatirányítási és termékmenedzsment rendszer.

Az alábbiakban a projekt fejlesztését, valamint telepítését részletezzük.

## 1. Fejlesztés

A fejlesztés docker alatt történik, ehhez a `laravel/sail` csomagot használjuk, fontos, hogy minden fejlesztő ezt a konfigurációt használja, mert ez alapján lesznek az éles szervergépke is konfigurálva.

## 2. Telepítés

-  `git clone git@gitlab.com:s.p.d/shop.git`
- telepítsünk [dockert](https://docs.docker.com/engine/install/ubuntu/) valamint [docker-composet](https://docs.docker.com/compose/install/)


## 3. Dockerizáció

### 3.1 az első composer install

A dockerizációban a `laravel/sail` csomagját használjuk. Itt a dockerizációhoz szükséges fájlok a `vendor` mappában helyezkednek el.
Ez egy faramuci helyzet, mert a `docker` indításához kell a `sail` csomag, de ahhoz, hogy azt fel tudjuk telepíteni, kelleni fog a docker.
Ezek miatt a `0. lépés`, amit a későbbiekben már `kihagyhatunk`, csak ha valami miatt `törlődne a vendor mappa` kell elővennünk, hogy az első `composer install`-t az alábbi módon futassuk:

```bash
docker run --rm -u $(id -u):$(id -g) \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    composer create-project --ignore-platform-reqs
```

### 3.2 sail alias

A docker parancsok futtatása a `./vendor/bin/sail` paranccsal lehetséges, hogy elég legyen csak a `sail` parancsot használni, fel kell vennünk a terminálunkba `alias` ként.

```bash
# ubuntu alatt (ez csak a terminál bezárásáig él)
alias sail='bash vendor/bin/sail'

# vagy vegyük fel a ~/bashrc -be (ez végleges)

# vagy használjuk, a fenti módon, pl.:
./vendor/bin/sail up -d
```

### 3.3 néhány gyakori parancs

```bash
# első futtatáskor érdemes buildelni
sail up --build

# konténerek indítása
sail up

# leállítása
sail down

# leállítás teljes törléssel
sail down -v

# supervisor indítása
sail artisan queue:work

# composer install, update
sail composer install
sail composer update

# migrációk futtatása
sail artisan migrate
sail artisan migrate:fresh --seed
sail artisan migrate:rollback --step=1

# gyakori npm parancsok
sail npm install
sail npm run prod
sail npm run dev

# cache és konfig ürítésére
sail php artisan cache:clear 
sail php artisan config:clear
sail composer dump-autoload

# supervisor futtatása
sail artisan queue:work
```

### 3.4 composer scriptek

A kódminőség javítása érdekében bekötésre került több alkalmazás, amik segítenek felderíteni a kritikus részeket, ugyanezek a toolok futnak le commitáláskor is, hogy ne lehessen a meglévőnél gyengébb a kód.

```bash
# easy-coding-standard futtatása amivel az ecs.php fájlban meghatározott standardok betartását ellenőrzizzük
# a `--fix` kapcsoló futtatásával javítani is képes a kódot
# php-cs-fixer futtatása, képes felderíteni a szemantikailag helytelen részeket
# a `--dry-run` kapcsoló kihagyása esetén automatikusan javítja is őket
sail composer cs

# local-php-security-checker futtatása, átvizsgálja a composerben használt csomagokat
# jelzi ha valamelyik elavult, vagy biztonsági rést jelenthet
sail composer sc

# phpstan statikus kódelemző futtatása esetleges hibák felderítésére
# psalm
sail composer sa

# tesztek futtatása
sail composer tests
```

### 3.5 docker alkalmazások

- az alkalmazás így érjük el http://localhost
- emailek kezelésére `MailHog` http://localhost:8025
- hibakeresésre `telescope` http://localhost/telescope

### Dokumentációk

A projekthez kapcsolódó dokumentációkat a [docs](/docs) mappában tartjuk. A fejlesztéshez szükséges információkat pedig a [CONTRIBUTE.md](CONTRIBUTE.md) elnevezésű leírásban találjuk.
