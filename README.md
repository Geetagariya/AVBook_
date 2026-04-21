# AVBook — Digital Audio Video Book Platform
### Government Polytechnic Nainital

A digital platform for students to access Books, Notes, Video Lectures, Audio Lectures, and College information.

---

## 🚀 Deploying on HostITSmart cPanel via GitHub

### Step 1 — Update Database Credentials

Open `db.php` and update these 4 values with your **cPanel MySQL credentials**:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'gariy_avbook');       // cPanel username_dbuser
define('DB_PASS', 'YOUR_DB_PASSWORD');   // your MySQL user password
define('DB_NAME', 'gariy_avbook_db');    // cPanel username_dbname
```

> ⚠️ On HostITSmart shared hosting, MySQL database names and usernames are always **prefixed with your cPanel username** (e.g. `gariy_avbook_db`, not just `avbook_db`).

---

### Step 2 — Create MySQL Database on cPanel

1. Login to **cPanel** → go to **MySQL Databases**
2. Create Database: `avbook_db` → it will show as `gariy_avbook_db`
3. Create User: `avbook` → it will show as `gariy_avbook` — set a strong password
4. **Add User to Database** → grant **All Privileges**
5. Update `db.php` with these exact names and password

---

### Step 3 — Import Database Schema

1. cPanel → **phpMyAdmin** → click your new database (`gariy_avbook_db`)
2. Click **Import** tab → **Choose File** → select `avbook_db.sql` from this project
3. Click **Go** — all 7 tables will be created

---

### Step 4 — Push Code to GitHub

```bash
# In: c:\Users\gariy\OneDrive\Desktop\AVBookU\
git init
git add AVBook/
git commit -m "Initial deployment-ready release"
git remote add origin https://github.com/YOUR_USERNAME/AVBook.git
git push -u origin main
```

---

### Step 5 — Connect GitHub to cPanel

**Option A — Git Version Control (Recommended):**
1. cPanel → **Git™ Version Control** → **Create**
2. Clone URL: `https://github.com/YOUR_USERNAME/AVBook.git`
3. Repository Path: `/public_html/AVBook` (or your domain root)
4. Click **Create** → then click **Update from Remote**

**Option B — FTP Upload:**
1. cPanel → **FTP Accounts** → create an FTP account
2. Use **FileZilla**: connect to your hosting FTP
3. Upload the entire `AVBook/` folder to `/public_html/AVBook/`

---

### Step 6 — Set Folder Permissions (cPanel File Manager)

Navigate to `/public_html/AVBook/` and set these folders to **755**:

| Folder | Purpose |
|--------|---------|
| `PDF/` | Book PDF uploads |
| `pdf/` | Notes/papers PDF uploads |
| `audios/` | Audio lecture uploads |
| `images/books/` | Book cover images |
| `images/college/` | Campus photos for slideshow |

---

### Step 7 — Create Admin Account

1. Visit: `https://yourdomain.com/AVBook/create_admin.php`
2. Create your admin username & password
3. **IMMEDIATELY** go to cPanel File Manager and **delete** `create_admin.php`

---

### Step 8 — Upload College Photos

Upload your campus photos to `/public_html/AVBook/images/college/`:
- `cp1.jpg`, `cp2.jpg`, `cp3.jpg`, `cp4.jpg`
- `cp6.jpg`, `cp7.jpg`, `cp9.jpg`, `cp10.jpg`, `cp11.jpg`, `cp12.jpg`

---

### Step 9 — Test the Site

| Page | URL |
|------|-----|
| Home | `yourdomain.com/AVBook/index.php` |
| Books | `yourdomain.com/AVBook/book.php` |
| Admin Login | `yourdomain.com/AVBook/admin_login.php` |
| Admin Dashboard | `yourdomain.com/AVBook/admin_dashboard.php` |

---

## 📁 Project Structure

```
AVBook/
├── db.php                  ← Central DB config (update before deploy)
├── avbook_db.sql           ← Database schema (import to cPanel)
├── .htaccess               ← Security & upload limits
├── .gitignore              ← Git exclusions
├── index.php               ← Home page
├── book.php                ← Books listing
├── notes.php               ← Notes listing
├── videos.php              ← Video lectures
├── audios.php              ← Audio lectures
├── brochure.php            ← College brochure
├── contact.php             ← Contact form
├── feedback.php            ← Feedback form
├── announcement.php        ← Announcements page
├── aboutUs.php             ← About page
├── admin_login.php         ← Admin login
├── admin_dashboard.php     ← Admin dashboard
├── add_book.php            ← Upload book (admin)
├── add_notes.php           ← Upload notes (admin)
├── upload_audio.php        ← Upload audio (admin)
├── upload_video.php        ← Add video link (admin)
├── add_announcement.php    ← Add announcement (admin)
├── PDF/                    ← Book PDF uploads
├── pdf/                    ← Notes PDF uploads
├── audios/                 ← Audio file uploads
├── images/books/           ← Book cover images
└── images/college/         ← Campus photos
```

---

## 🔧 Tech Stack

- **Backend:** PHP 7.4+ with MySQLi
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, Vanilla JS
- **CSS Framework:** Bootstrap 5.3
- **Icons:** Font Awesome 6.5
- **Fonts:** Google Fonts (Poppins, Playfair Display)

---

## ⚠️ Important Security Notes

- `create_admin.php` — **Delete after creating admin account**
- All admin pages are protected by session authentication
- All user inputs are escaped with `mysqli_real_escape_string()`
- `.htaccess` blocks directory listing and sensitive files
