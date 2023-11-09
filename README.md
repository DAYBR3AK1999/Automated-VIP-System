# Automated-VIP-System
This is an Automated VIP System for games supporting SourceBans with SourceMod.

## Title
**[ANY] VIP Management Plugin (v1.0, 2023-11-09)**

## Description
This plugin adds users to the VIP group with certain flags in game servers supported by SourceBans to manage VIP status, codes, expiration dates and privileges.
It interacts with a SourceBans database to keep track of who has VIP status, manages VIP tests, and automatically refreshes the administrator's cache if necessary.
It also features an automated system for adding and removing VIPs according to expiration date, currently set at 1 week, but can be customized once the code has been used by a user or could even be created by a database administrator.

## Feature List
- Automated VIP code generation with validation and activation system.
- VIP test function for temporary VIP access or more, depending on what the database administrator does.
- Automatic refresh of administrator cache when VIP status is updated.
- Database administrators can manage VIP codes, statuses, expiration dates and more or even add users via SteamID and generate an expiration date with a random code.
- Automated checking and updating of non-existent, used or expired VIP codes.

## CVAR/Command List
- `sm_vip_code` - Allows a user to activate their VIP code and if a user uses the code received it grants a user VIP status for a limited time.
- `sm_viptest` - Gives the user a randomly generated code.
- `sm_myvipcode` - Lets a user see their VIP code.
- `sm_vipstatus` - Allows a user to check the status of their VIP trial.

## Changelog
**09-11-2023 (v1.0)**
- Initial release with VIP code management.
- Added checks.
- Fixed some bugs when receiving and activating the vip code.

## Installation Instructions
1. Configure a SourceBans group with some flags you want to give to VIP users.
2. Create the table sb_vip_system with columns by running the [SQL File](https://github.com/DAYBR3AK1999/Automated-VIP-System/blob/main/vip_system.sql).
3. Download the plugin (.smx) or compile the .sp file while you configured the plugin by editing the `.sp or .sql file` to your own liking.
4. Place the .smx file in your server's `addons/sourcemod/plugins` directory.
5. Restart the server.

## Dependencies
- SourceMod
- SourceBans

## Plans
- Implementation of in-game functions using the administration menu.
- Multilingual support.
- Integrate it into a VIP menu system for users.

## About this plugin
This SourceMod plugin provides a series of commands and automated tasks to manage VIP players on a server. 
It interacts with the SourceBans database to update and verify VIP status, codes and ensure that VIP privileges are granted accurately and efficiently.

## Useful for :
Servers who want to give VIP users privileges.

