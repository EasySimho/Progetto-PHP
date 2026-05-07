# Relazione dettagliata del progetto "Lanificio Maurizio Sella"

## 1. Obiettivo del progetto
Il progetto realizza una galleria multimediale dedicata al **Lanificio Maurizio Sella**, con una sezione pubblica per la consultazione dei contenuti e un’area amministrativa riservata per la gestione (caricamento e rimozione) di immagini, video MP4 e link YouTube. L’esperienza utente è focalizzata su una navigazione semplice e su una fruizione immediata dei media.

## 2. Tecnologie utilizzate
- **Backend**: PHP (procedurale) con estensione **MySQLi**
- **Database**: MySQL/MariaDB
- **Frontend**: HTML5, CSS3, JavaScript (vanilla, inline)
- **Asset**: CSS centralizzato in `assets/css/style.css`

## 3. Struttura della repository
```
admin/              -> Area amministrativa (login, dashboard, upload, delete, logout)
assets/css/         -> Stili UI (tema pubblico + tema admin)
database/           -> Script SQL (schema base e dump popolato)
includes/           -> Connessione al database
uploads/            -> Contenuti multimediali caricati (images/videos)
index.php           -> Home pubblica con galleria multimediale
```

## 4. Funzionalità principali
### 4.1 Area pubblica (visitor)
**File principale**: `index.php`
- Recupero dei contenuti da tabella `media_contents`.
- **Filtro per categoria**: “Tutte”, “Tradizione”, “Innovazione”.
- **Rendering dinamico** in base al tipo di contenuto:
  - `image`: immagine con anteprima e apertura in modale.
  - `video`: video MP4 con overlay play e apertura in modale.
  - `youtube`: estrazione ID e anteprima tramite thumbnail di YouTube, apertura in modale con autoplay.
- **Modale multimediale** gestita in JavaScript per immagini, video e iframe YouTube.

### 4.2 Area amministrativa (admin)
**File principali**: `admin/login.php`, `admin/dashboard.php`, `admin/upload.php`, `admin/delete.php`, `admin/logout.php`
- **Autenticazione**: login con username/password verificata tramite `password_verify()`.
- **Sessione admin**: accesso protetto per dashboard, upload e delete.
- **Dashboard**: tabella contenuti con azioni di eliminazione.
- **Upload contenuti**:
  - Caricamento **file** (immagini o video) con salvataggio in `uploads/`.
  - Inserimento **link YouTube** salvato come tipo `youtube`.
- **Cancellazione**:
  - Rimozione file dal filesystem (se presente).
  - Eliminazione record DB correlato.

## 5. Modello dati e database
**Script disponibili**:
- `database/schema_base.sql` – schema minimo.
- `database/popolato.sql` – schema completo + dati di esempio.

### Tabelle principali
1. **admins**
   - `id`, `username`, `password_hash`, `created_at`
   - Utente demo presente nel dump; in ambienti reali sostituire le credenziali e rigenerare le password.

2. **media_contents**
   - `id`, `title`, `description`, `category`, `media_type`, `file_path`, `created_at`
   - `category`: `Tradizione` o `Innovazione`
   - `media_type`: `image`, `video`, `youtube` (nel dump popolato)

### Nota sulla coerenza schema
Il file `schema_base.sql` contiene `media_type` con soli valori `video` e `image`, mentre il dump `popolato.sql` include anche `youtube`. Se si usa lo schema base, è consigliato aggiornare l’enum per supportare i link YouTube.

## 6. Flusso principale dei dati
1. L’admin inserisce un contenuto (file o link YouTube).
2. Il contenuto viene salvato nel DB e, per i file, nel filesystem (`uploads/`).
3. La homepage legge i contenuti dal DB e li mostra in galleria.
4. L’utente finale apre i contenuti nel modale multimediale.

## 7. Configurazione e setup
1. **Database**
   - Creare il DB `lanificio_sella`.
   - Importare `database/schema_base.sql` o `database/popolato.sql`.
2. **Connessione**
   - Configurata in `includes/db_connect.php` (host `localhost`, db `lanificio_sella`); è consigliato usare un utente dedicato con privilegi minimi e gestire le credenziali fuori dal versionamento (es. variabili d’ambiente o file escluso con `.gitignore`).
3. **Server**
   - PHP 8.x con estensione MySQLi attiva.
   - Server web (Apache/Nginx) con accesso in scrittura alla cartella `uploads/`.

## 8. Considerazioni su sicurezza e qualità
**Aspetti presenti**
- Query parametrizzate con `mysqli_prepare`.
- Password hash verificata con `password_verify()`.
- Sessione amministrativa per limitare l’accesso.

**Miglioramenti possibili**
- Protezione CSRF sui form admin.
- Validazione più rigida dei file (dimensione, nome, MIME).
- Gestione errori più robusta e logging.
- Separazione della logica JS in file dedicato per manutenibilità.

## 9. Conclusione
Il progetto offre una base solida per una **galleria multimediale storica** con area amministrativa semplice ma completa. L’architettura è chiara e facilmente estendibile, con possibilità di miglioramenti sulla sicurezza e sulla modularità del frontend.
