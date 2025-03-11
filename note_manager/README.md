# Gestore Note

Un semplice sistema di gestione delle note realizzato con PHP e MySQL.

## Caratteristiche

- Creazione di nuove note con titolo e contenuto
- Visualizzazione di tutte le note in un layout a griglia
- Eliminazione delle note
- Interfaccia responsive con Bootstrap
- Gestione delle date di creazione

## Requisiti

- PHP 7.4 o superiore
- MySQL 5.7 o superiore
- Server web (Apache/Nginx)

## Configurazione

1. Importa il database:
   ```bash
   mysql -u root -p < database.sql
   ```

2. Configura il database:
   Modifica il file `config.php` con le tue credenziali del database:
   ```php
   $host = 'localhost';
   $dbname = 'note_manager';
   $username = 'il_tuo_username';
   $password = 'la_tua_password';
   ```

3. Avvia il server PHP:
   ```bash
   php -S localhost:8000
   ```

4. Apri il browser e visita `http://localhost:8000`

## Struttura del Progetto

- `index.php`: File principale con l'interfaccia utente e la logica
- `config.php`: Configurazione del database
- `database.sql`: Script di inizializzazione del database

## Funzionalità

- **Aggiungere una nota**: Compila il form in alto con titolo e contenuto
- **Visualizzare le note**: Le note vengono mostrate automaticamente sotto il form
- **Eliminare una nota**: Usa il pulsante "Elimina" su ogni nota
