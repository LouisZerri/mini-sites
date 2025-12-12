# 🏠 Mini-Sites Conseillers Immobiliers

Système multi-tenant permettant de générer automatiquement un mini-site pour chaque conseiller immobilier avec un sous-domaine unique.

## 📋 Fonctionnalités

### Administration
- ✅ CRUD complet des agents (création, modification, suppression)
- ✅ CRUD des annonces avec galerie photos
- ✅ Gestion et validation des avis clients
- ✅ Upload de photos multiples avec prévisualisation (Alpine.js)
- ✅ Personnalisation des couleurs par agent

### Mini-sites
- ✅ Génération automatique de mini-sites avec sous-domaines
- ✅ Design moderne et responsive
- ✅ Galerie photos avec lightbox élégante
- ✅ Affichage des annonces et avis
- ✅ Formulaire de contact avec envoi d'emails
- ✅ Animations au scroll
- ✅ Personnalisation des couleurs par agent

## 🛠️ Technologies utilisées

- **Backend** : Laravel 11
- **Frontend** : Tailwind CSS, Alpine.js
- **Base de données** : MySQL
- **Server** : Apache avec VirtualHost wildcard
- **SSL** : Let's Encrypt (certificat wildcard)
- **Email** : SMTP Gmail

## 📦 Structure du projet
```
mini-sites-agents/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AgentController.php       # CRUD agents
│   │   │   ├── AnnonceController.php     # CRUD annonces
│   │   │   ├── AvisController.php        # CRUD avis
│   │   │   └── MiniSiteController.php    # Mini-sites publics
│   │   └── Middleware/
│   │       └── IdentifyTenant.php        # Détection sous-domaines
│   ├── Mail/
│   │   └── ContactMail.php               # Email de contact
│   └── Models/
│       ├── Agent.php                      # Modèle Agent
│       ├── Annonce.php                    # Modèle Annonce
│       └── Avis.php                       # Modèle Avis
├── database/
│   ├── migrations/
│   │   ├── *_create_agents_table.php
│   │   ├── *_create_annonces_table.php
│   │   └── *_create_avis_table.php
│   └── seeders/
│       ├── AgentSeeder.php
│       ├── AnnonceSeeder.php
│       └── AvisSeeder.php
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── agents/                    # Vues CRUD agents
│       │   ├── annonces/                  # Vues CRUD annonces
│       │   └── avis/                      # Vues CRUD avis
│       ├── emails/
│       │   └── contact.blade.php          # Template email
│       ├── layouts/
│       │   └── admin.blade.php            # Layout admin
│       └── minisite/
│           └── home.blade.php             # Template mini-site
└── routes/
    └── web.php                            # Routes
```

## 🚀 Installation locale

### Prérequis
- PHP 8.2+
- Composer
- MySQL
- Apache (ou Laravel Valet)

### Installation

1. **Cloner le projet**
```bash
cd ~/Documents/WEB
git clone [url-du-repo] mini-sites-agents
cd mini-sites-agents
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurer le .env**
```env
APP_NAME="Mini-Sites Conseillers"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_DATABASE=mini_sites
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=gestimmo.presta@gmail.com
MAIL_PASSWORD="votre_mot_de_passe_app"
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=gestimmo.presta@gmail.com
MAIL_FROM_NAME="GEST'IMMO"
```

5. **Créer la base de données**
```bash
mysql -u root -p
CREATE DATABASE mini_sites CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

6. **Lancer les migrations et seeders**
```bash
php artisan migrate
php artisan db:seed
```

7. **Créer le lien symbolique pour le storage**
```bash
php artisan storage:link
```

8. **Lancer le serveur**
```bash
php artisan serve
```

Accès : http://localhost:8000

## 🌐 Déploiement en production

### Prérequis
- VPS avec Apache, PHP 8.2+, MySQL
- Domaine avec wildcard DNS configuré
- Certificat SSL wildcard

### 1. DNS (Ionos)

Ajouter les enregistrements A :
```
@ → 62.4.30.248
* → 62.4.30.248
www → 62.4.30.248
```

### 2. Transfert du code
```bash
# Sur le VPS
cd /var/www/html
sudo mkdir mini-sites
sudo chown -R gestimmo:gestimmo mini-sites

# Depuis le PC local
cd ~/Documents/WEB/mini-sites-agents
rsync -avz --exclude 'node_modules' --exclude '.git' --exclude 'storage' --exclude 'vendor' . gestimmo@62.4.30.248:/var/www/html/mini-sites/
```

### 3. Configuration sur le VPS
```bash
# Se connecter en SSH
ssh gestimmo@62.4.30.248

cd /var/www/html/mini-sites

# Installer les dépendances
composer install --optimize-autoloader --no-dev

# Créer .env
cp .env.example .env
nano .env
```

Configurer le .env production :
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://gestimmo-conseillers.fr

DB_DATABASE=mini_sites
DB_USERNAME=gestimmo_user
DB_PASSWORD=ByroN.GESTIMMO2005
```
```bash
# Générer la clé
php artisan key:generate

# Migrations
php artisan migrate --force
php artisan db:seed --force

# Permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Créer lien symbolique
php artisan storage:link

# Optimisations
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 4. Configuration Apache
```bash
sudo nano /etc/apache2/sites-available/mini-sites.conf
```
```apache
<VirtualHost *:80>
    ServerName gestimmo-conseillers.fr
    ServerAlias *.gestimmo-conseillers.fr
    DocumentRoot /var/www/html/mini-sites/public
    
    <Directory /var/www/html/mini-sites/public>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/mini-sites-error.log
    CustomLog ${APACHE_LOG_DIR}/mini-sites-access.log combined
</VirtualHost>
```
```bash
# Activer le site
sudo a2ensite mini-sites.conf
sudo systemctl reload apache2
```

### 5. Certificat SSL wildcard
```bash
sudo certbot certonly --manual --preferred-challenges=dns \
  -d gestimmo-conseillers.fr -d *.gestimmo-conseillers.fr
```

Suivre les instructions pour ajouter les enregistrements TXT dans Ionos.
```bash
sudo nano /etc/apache2/sites-available/mini-sites-le-ssl.conf
```
```apache
<VirtualHost *:443>
    ServerName gestimmo-conseillers.fr
    ServerAlias *.gestimmo-conseillers.fr
    DocumentRoot /var/www/html/mini-sites/public
    
    SSLEngine on
    SSLCertificateFile /etc/letsencrypt/live/gestimmo-conseillers.fr/fullchain.pem
    SSLCertificateKeyFile /etc/letsencrypt/live/gestimmo-conseillers.fr/privkey.pem
    
    <Directory /var/www/html/mini-sites/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
```bash
sudo a2ensite mini-sites-le-ssl.conf
sudo systemctl reload apache2
```

### 6. Modifier les routes pour la production
```bash
nano routes/web.php
```

Remplacer les routes de dev par :
```php
// Routes admin
Route::domain('gestimmo-conseillers.fr')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.agents.index'));
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('agents', AgentController::class);
        Route::prefix('agents/{agent}')->group(function () {
            Route::resource('annonces', AnnonceController::class);
            Route::get('avis', [AvisController::class, 'index'])->name('avis.index');
            Route::get('avis/create', [AvisController::class, 'create'])->name('avis.create');
            Route::post('avis', [AvisController::class, 'store'])->name('avis.store');
            Route::get('avis/{avis}', [AvisController::class, 'edit'])->name('avis.edit');
            Route::put('avis/{avis}', [AvisController::class, 'update'])->name('avis.update');
            Route::delete('avis/{avis}', [AvisController::class, 'destroy'])->name('avis.destroy');
            Route::post('avis/{avis}/toggle', [AvisController::class, 'toggleValidation'])->name('avis.toggle');
        });
    });
});

// Mini-sites
Route::domain('{slug}.gestimmo-conseillers.fr')->middleware('tenant')->group(function () {
    Route::get('/', [MiniSiteController::class, 'index'])->name('minisite.home');
    Route::post('/contact', [MiniSiteController::class, 'contact'])->name('minisite.contact');
});
```

### 7. Modifier le modèle Agent
```bash
nano app/Models/Agent.php
```

Modifier l'attribut `url` :
```php
public function getUrlAttribute(): string
{
    return 'https://' . $this->slug . '.gestimmo-conseillers.fr';
}
```
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

## 📱 URLs en production

- **Admin** : https://gestimmo-conseillers.fr/admin/agents
- **Mini-site Jean** : https://jean-dupont.gestimmo-conseillers.fr
- **Mini-site Marie** : https://marie-martin.gestimmo-conseillers.fr

## 🔐 Sécurité

- ✅ HTTPS obligatoire (certificat wildcard)
- ✅ Validation des formulaires
- ✅ Protection CSRF
- ✅ Mot de passe app Gmail pour SMTP
- ✅ `.env` non versionné

## 📧 Configuration email

Chaque conseiller reçoit les messages de contact dans sa propre boite email (configurée dans sa fiche).

Le serveur SMTP (`gestimmo.presta@gmail.com`) sert uniquement d'expéditeur.

## 🎨 Personnalisation

Chaque agent peut avoir :
- Couleur primaire
- Couleur secondaire
- Photo de profil
- Bio personnalisée
- Réseaux sociaux (LinkedIn, Facebook)

## 📊 Base de données

### Tables
- **agents** : Informations des conseillers
- **annonces** : Annonces immobilières (avec photos JSON)
- **avis** : Avis clients (avec validation)

### Relations
- Agent → Annonces (1:N)
- Agent → Avis (1:N)

## 🐛 Debugging
```bash
# Voir les logs
tail -f storage/logs/laravel.log

# Vider le cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Reconstruire le cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📝 Maintenance

### Mise à jour du code
```bash
# Sur le VPS
cd /var/www/html/mini-sites
git pull origin main
composer install --no-dev
php artisan migrate --force
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Backup base de données
```bash
mysqldump -u gestimmo_user -p mini_sites > backup-$(date +%Y%m%d).sql
```

## 👨‍💻 Auteur

Développé pour GEST'IMMO

## 📄 Licence

Propriétaire - Tous droits réservés