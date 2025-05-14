# 🎖️ Automated VIP System – SourceMod + Web Panel (v3.0)

A dynamic and automated VIP management system for games using **SourceMod** and **SourceBans**.

> ⚡ Fully integrated with a Vue 3 + Bootstrap web admin panel  
> 🛡️ Supports expiring VIP codes, trials, group assignment, multilingual UI, and more.

---

## ✅ Supported Games

- Counter-Strike: Source
- Counter-Strike: Global Offensive
- Team Fortress 2
- Day of Defeat: Source
- Left 4 Dead 2

---

## 🔥 Features (v3.0)

### ✅ SourceMod Plugin Commands
- `!vipmenu` — Dynamic in-game menu with VIP status and more
- `!viptest` — Claim a one-time VIP trial
- `!vip_code <code>` — Redeem full VIP access with a code
- `!myvipcode` — See your personal trial code
- `!vipstatus` — Check if trial is active, expired, or unused
- `!vipadmin` — Admin menu: view VIPs, force expire check, web panel, etc.

### ✅ Web Admin Panel
- Full **Vue 3 frontend** with **Bootstrap 5**
- Role-based logins: **Owner / Admin**
- View, add, edit VIP codes & SteamIDs
- Toggle usage, update expiration dates & groups
- MOTD link for in-game Donate and Admin Panel
- Fully responsive layout (mobile & desktop)

### ✅ Backend / Core Features
- MySQL integration with `SourceBans` database
- Auto-link VIP group to players on connect
- Expiration system with automatic cleanup (timer or round)
- Logs errors & system actions
- Configurable via `cfg/sourcemod/vip.cfg`

### ✅ Multilingual Support
- `vip.phrases.txt` handles all translations
- 🇬🇧 English + 🇫🇷 French included
- Easily extendable for other languages

---

## 💾 Installation Instructions

### 🔧 Plugin Setup
1. Import `sql/vip_system.sql` into your **SourceBans** database.
2. Place files:
   - `cstrike/addons/sourcemod/plugins/vip_system.smx`
   - `cstrike/addons/sourcemod/translations/vip.phrases.txt`
   - `cstrike/cfg/sourcemod/vip.cfg`
3. Restart the server.
4. Configure settings in `vip.cfg`.

### 🌐 Web Panel Setup
1. Upload the `web/` folder to your web server.
2. Open `/web/config.php` and set your database connection.
3. Visit your panel in the browser and login with a demo account.

---

## 🧪 Default Login Accounts (demo)

| Role  | Username | Password |
|-------|----------|----------|
| Owner | `owner`  | `123456` |
| Admin | `admin`  | `123456` |

---

## 🧠 Example ConVars (`cfg/sourcemod/vip.cfg`)

```cfg
sm_vip_adminpanel_url "https://yourdomain.com/panel"
sm_vip_donate_url "https://yourdomain.com/donate"
sm_vip_enable_trial "1"
sm_vip_show_menu_on_connect "0"

## 📜 Changelog

### 🔷 v3.0 – 14 May 2025
- Refactored plugin core for security and optimization  
- Full dynamic menu system (`!vipmenu`, `!vipstatus`, `!vipadmin`)  
- VIP benefits display from SQL group info  
- Auto expiration system with `CheckExpiredVIPs()`  
- Multilingual support: 🇬🇧 EN + 🇫🇷 FR  
- MOTD panel integration for Donate/Admin  
- SQL fields extended: `vip_group`, `added_by`, `used`, `viptest_used`  
- Structured file layout: `cstrike/`, `web/`, `sql/`  

---

### 🔹 v2.0 – 30 Nov 2023
- First web-based admin panel (Vue 3 + Bootstrap 5)  
- Role-based user logins and permission system  
- Code creation, trial toggle, expiration updates via UI  

---

### 🔸 v1.0 – 09 Nov 2023
- Initial release of plugin  
- Base VIP code handling with SourceBans integration  

---

## ⚙️ Dependencies

- ✅ SourceMod v1.10+  
- ✅ SourceBans++ (or compatible fork)  
- ✅ PHP 7.4+ with MySQLi  
- ✅ Apache or Nginx web server  
- ✅ Bootstrap 5 (included)  
- ✅ Vue 3 (included)  

---

## 🙌 Contributors

- **DAYBR3AK1999** – Project lead, core developer  
- Inspired by: `xkonsole`, `Asheroto`, M4rtin and other community contributions  

---

## 📦 GitHub & Downloads

- 🌐 **Repository:** [https://github.com/DAYBR3AK1999/Automated-VIP-System](https://github.com/DAYBR3AK1999/Automated-VIP-System)  
- 📥 **Download ZIP:** [Latest Release v3.0](https://github.com/DAYBR3AK1999/Automated-VIP-System/releases/latest)  

---

## 🎯 Ideal Use Cases

- Zombie Escape, Surf, Jailbreak, Minigames servers  
- Servers offering time-limited or trial-based VIP perks  
- Donator reward systems with web-panel admin access  
- Communities needing both in-game & browser-based control  

---

## 📸 Screenshots & Preview

💡 *Coming soon!*  
Feel free to submit your own preview images or request help generating promotional banners!
