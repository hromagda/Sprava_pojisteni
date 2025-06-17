# Správa pojištění

Tento projekt je webová aplikace pro evidenci pojištění vytvořená v **Laravelu**.  
Aplikace umožňuje správu pojištěnců, pojistných smluv a uživatelů s různými rolemi a oprávněními.

## 📌 Hlavní funkce

- ✅ **Registrace a správa pojištěnců**
- ✅ **Správa pojistných smluv** (typ, částka, předmět, platnost, poznámka)
- ✅ **Uživatelské role**
  - **Admin** – kompletní přístup, správa uživatelů, pojištěnců i pojištění
  - **Agent** – správa pojištěnců a jejich pojištění
  - **Viewer** – pouze prohlížení údajů
- ✅ **Autentizace uživatelů**
- ✅ **Role a oprávnění řešeny přes Spatie/laravel-permission**
- ✅ **Přehledné rozhraní díky Bootstrapu**
- ✅ **Moderní asset pipeline přes Vite**

## 🖼️ Ukázky

Ve složce `readme/` najdete screenshoty obrazovek aplikace z lokálního prostředí.

## 🚀 Technologie

- PHP 8.x
- Laravel 10
- MySQL
- Bootstrap 5
- Vite
- Spatie Laravel Permission

## 🛠️ Instalace

1️⃣ Naklonujte repozitář:

git clone https://github.com/hromagda/Sprava_pojisteni.git  
cd Sprava_pojisteni

2️⃣ Nainstalujte závislosti:

composer install  
npm install  
npm run build  

3️⃣ Vytvořte .env:  

cp .env.example .env
php artisan key:generate  

4️⃣ Nastavte databázi v .env a spusťte migrace + seedery:

php artisan migrate --seed  
(Seedery vytvoří výchozí uživatele s různými rolemi, pokud jsou součástí projektu.)  

5️⃣ Spusťte lokální server:  

php artisan serve  
📝 Uživatelské účty (pro testování)  
(Doplňte konkrétní přihlašovací údaje ze seederu, pokud máte předpřipravené účty.)  

## 🔑 Role a oprávnění  
Admin: může spravovat uživatele, pojištěnce i pojištění.  

Agent: může spravovat pojištěnce a jejich pojištění, nemá přístup ke správě uživatelů.  

Viewer: má pouze čtecí přístup.  

## 📂 Struktura projektu  
app/  
resources/views/  
routes/web.php  
database/migrations/  
database/seeders/  
public/  
readme/  
💡 Poznámky  
Aplikace zatím není nasazena na produkci (vyžaduje připojení k databázi).  

Složka readme/ obsahuje screenshoty aplikace z lokálního prostředí.  

## 📌 Plán do budoucna  
✅ Nasazení na produkci (např. Render, Railway, DigitalOcean)  

✅ Přidání REST API pro externí integrace  

✅ Rozšíření testů (PHPUnit)  
