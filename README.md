# 🎖️ Automated VIP System – SourceMod + Web Panel (v3.0)

A dynamic and automated VIP management system for games using SourceMod + SourceBans.

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

### ✅ SourceMod Plugin
- `!vipmenu` — Dynamic in-game menu with VIP status and more
- `!viptest` — Claim a one-time VIP trial
- `!vip_code <code>` — Redeem full VIP access with a code
- `!myvipcode` — See your personal trial code
- `!vipstatus` — Check if trial is active, expired, or unused
- `!vipadmin` — Admin menu: view VIPs, force expire check, etc.

### ✅ Web Admin Panel
- Full Vue 3 frontend with Bootstrap 5
- Role-based logins: Owner / Admin
- View/add/edit VIP codes & SteamIDs
- Toggle usage, update expiration dates & groups
- Admin panel + donation URL for in-game MOTD
- Fully responsive UI

### ✅ Backend Features
- SQL integration with `SourceBans` database
- VIP group linking (auto adds group on connect)
- Expiration system with auto cleanup (via timer or round start)
- Logs errors and status updates
- Configuration via ConVars (`cfg/sourcemod/vip.cfg`)

### ✅ Multilingual Support
- `vip.phrases.txt` for chat and menus
- 🇬🇧 English + 🇫🇷 French included
- Easily extendable for other languages

---

## 💾 Installation Instructions

### Plugin Setup
1. Import `sql/vip_system.sql` into your **SourceBans** database
2. Place:
   - `vip_system.smx` in `addons/sourcemod/plugins/`
   - `vip.phrases.txt` in `addons/sourcemod/translations/`
   - `vip.cfg` in `cfg/sourcemod/`
3. Restart the server and configure ConVars

### Web Panel Setup
1. Upload the `web/` folder to your **web server**
2. Configure your DB settings in `/web/config.php`
3. Login with one of the default demo accounts (below)

---

## 🧪 Default Login Accounts (demo)

| Role   | Username | Password |
|--------|----------|----------|
| Owner  | `owner`  | `123456` |
| Admin  | `admin`  | `123456` |

---

## 🧠 Example ConVars (`cfg/sourcemod/vip.cfg`)

```cfg
sm_vip_adminpanel_url "https://yourdomain.com/panel"
sm_vip_donate_url "https://yourdomain.com/donate"
sm_vip_enable_trial "1"
sm_vip_show_menu_on_connect "0"

📜 Changelog
v3.0 – 14 May 2025
Refactored plugin core for security and optimization

Full dynamic menu system (!vipmenu, !vipstatus, etc.)

Added VIP benefits display menu (auto from SQL)

Auto expiration system with CheckExpiredVIPs()

Multilingual support (EN & FR)

Configurable trial toggle (via ConVar or admin menu)

MOTD panel integration (Donate + Admin Panel)

SQL: trial status, used codes, VIP group, added_by tracking

Fully structured file layout: sql/, web/, cstrike/

v2.0 – 30 Nov 2023
Introduced the first version of the web admin system (Vue + Bootstrap)

Added role-based access and code validation/editing

v1.0 – 09 Nov 2023
Initial release: VIP code management & in-game activation

Base plugin with SourceBans support

⚙️ Dependencies
SourceMod (v1.10 or higher)

SourceBans (1.x or ++)

PHP 7.4+ with MySQLi

Apache / Nginx web server

🙌 Contributors
DAYBR3AK1999 – Project lead & dev

Inspired by: xkonsole, Asheroto

📦 GitHub & Downloads
🌐 Repo: https://github.com/DAYBR3AK1999/Automated-VIP-System

📥 Download ZIP: Latest Release v3.0

🎯 Ideal Use Cases
Zombie, Surf, Jailbreak, Combat, or Fun servers with active VIP communities

Need full control over VIP access, trials, duration, and perks

Want web control panel + in-game integration

📸 Screenshots & Preview
Coming soon – or suggest your own and I’ll generate preview banners for you!
