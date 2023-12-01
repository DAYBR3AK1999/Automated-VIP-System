# Automated-VIP-System
This is an Automated VIP System for games supporting SourceBans with SourceMod.

## Tested on:
- Counter-Strike: Source
- Counter-Strike: Global Offensive

## Description
Version 2.0 introduces a web-based management interface for the VIP system, enhancing the plugin's capabilities with user-friendly administration, role-based access control, and a streamlined VIP management process. This update works seamlessly with the existing SourceMod plugin to manage VIP statuses, codes, and privileges.

## Feature List
- Web-based management system with a responsive user interface using Bootstrap 5.
- Interactive frontend built with Vue 3 for dynamic data handling and user experience.
- Role-based access control with distinct roles like admin and owner for granular management.
- Enhanced VIP code generation and validation through the web interface.
- Extended functionalities for VIP test, code management, and status updates.
- Automated checking and updating of non-existent, used, or expired VIP codes with web-based notifications.
- Seamless integration with SourceBans for streamlined VIP management in-game.
- Improved security and data handling in the backend using PHP.

## CVAR/Command List
- `sm_vip_code` - Activate VIP code and grant limited VIP status.
- `sm_viptest` - Generate a random VIP code for testing.
- `sm_myvipcode` - View your VIP code.
- `sm_vipstatus` - Check the status of your VIP trial.

## Changelog
**09-11-2023 (v1.0)**
- Initial release with VIP code management.
- Added checks.
- Fixed some bugs when receiving and activating the VIP code.

**30-11-2023 (v2.0)**
- Introduced a web-based management system for VIP users.
- Implemented a responsive user interface using Bootstrap 5.
- Developed an interactive frontend with Vue 3.
- Added role-based access control for administrators and owners.
- Enhanced security features and data handling in the PHP backend.
- Integrated web interface with SourceBans for streamlined in-game management.
- Added new web-based functionalities for VIP management.

## Installation Instructions
1. Configure a SourceBans group with flags for VIP users.
2. Create the table sb_vip_system with columns by running the [SQL File](https://github.com/DAYBR3AK1999/Automated-VIP-System/blob/main/vip_system.sql).
3. Download and configure the plugin and web interface files.
4. Place the .smx file in your server's `addons/sourcemod/plugins` directory.
5. Deploy the web interface on your web server.
6. Restart the server and configure the web interface.

## Dependencies
- SourceMod
- SourceBans
- PHP, MySQL/MariaDB, Apache/Nginx (for the web interface)
- Bootstrap 5, Vue 3 (for the web interface)

## Contributors
- [xkonsole - AlliedMods Profile](https://forums.alliedmods.net/member.php?u=284451) | [GitHub](https://github.com/strangelove7701)
- [Asheroto - AlliedMods Profile](https://forums.alliedmods.net/member.php?u=296790) | [GitHub](https://github.com/asheroto)

## Plans
- Implementation of in-game functions using the administration menu.
- Multilingual support.
- Integrate it into a VIP menu system for users.
- Further enhancements to the web interface for easier management.

## About this plugin
This SourceMod plugin, along with its web interface, provides comprehensive tools to manage VIP players on a server. It interacts with the SourceBans database to ensure accurate and efficient VIP privileges management.

## Useful for :
Servers looking to provide VIP privileges in a controlled and manageable manner. Ideal for Zombie Servers or similar game types.

## Preview
![Automated VIP System](https://sedirector.adrenaline-gaming.net/images/automatedvipsystem.png)

## Full release
[On my GitHub profile](https://github.com/DAYBR3AK1999/Automated-VIP-System)

## Web Management System Preview
- [Pictures will be added]
- [Login with owner rights: DAYBR3AK1999 & Password: Test123]
- [Login with admin rights: Thieu & Password: Test123]
