<?php
// Blacknova Traders - A web-based massively multiplayer space combat and trading game
// Copyright (C) 2001-2012 Ron Harwood and the BNT development team
//
//  This program is free software: you can redistribute it and/or modify
//  it under the terms of the GNU Affero General Public License as
//  published by the Free Software Foundation, either version 3 of the
//  License, or (at your option) any later version.
//
//  This program is distributed in the hope that it will be useful,
//  but WITHOUT ANY WARRANTY; without even the implied warranty of
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//  GNU Affero General Public License for more details.
//
//  You should have received a copy of the GNU Affero General Public License
//  along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
// File: config.php

error_reporting(E_ALL);

                                                                // All sched_* vars are in minutes.
                                                                // These are true minutes, no matter to what interval you're running the scheduler script!
                                                                // The scheduler will auto-adjust, possibly running many of the same events in a single call.

$sched_ticks                = 1;                                // Set this to how often (in minutes) you are running the scheduler script.
$turns_per_tick             = 6;                                // Update how many turns per tick
$sched_turns                = 2;                                // New turns rate (also includes towing, xenobe)
$sched_ports                = 1;                                // How often port production occurs
$sched_planets              = 2;                                // How often planet production occurs
$sched_igb                  = 2;                                // How often IGB interests are added
$sched_ranking              = 30;                               // How often rankings will be generated
$sched_news                 = 15;                               // How often news are generated
$sched_degrade              = 6;                                // How often sector fighters degrade when unsupported by a planet
$sched_apocalypse           = 15;                               // How often apocalypse events will occur
$sched_thegovernor          = 1;                                // How often the governor will run, cleaning up out-of-bound values
$doomsday_value             = 90000000;                         // Number of colonists a planet needs before being affected by the apocalypse
$color_header               = '#500050';                        // GUI colors - soon to be moved into templates
$color_line1                = '#300030';                        // GUI colors - soon to be moved into templates
$color_line2                = '#400040';                        // GUI colors - soon to be moved into templates
$mine_hullsize              = 8;                                // Minimum size hull has to be to hit mines
$ewd_maxhullsize            = 15;                               // Max hull size before EWD degrades
$sector_max                 = 1000;                             // Number of sectors you'd like your universe to have
$link_max                   = 10;                               // Maximum number of links in a sector
$universe_size              = 200;                              // This increases the distance between sectors, which increases the cost of realspace movement
$game_name                  = 'Default Game Name';              // Please set this to a unique name for your game
$release_version            = '0.663';                           // Please do not change this. Doing so will cause problems for the server lists, and setupinfo, and more.
$fed_max_hull               = 8;                                // The maximum hull size you can have before being towed out of fed space
$max_ranks                  = 100;                              // The maximum number of ranks displayed on ranking.php
$rating_combat_factor       = 0.8;                              // Amount of rating gained from combat
$server_closed              = false;                            // True = block logins but not new account creation
$account_creation_closed    = false;                            // True = block new account creation
$newbie_nice                = 'YES';                            // If a ship is destroyed without a EWD, *and* is below a certain level for all items, then regen their ship
$newbie_hull                = '8';                              // If a destroyed player has a hull less than newbie hull, he will be regen'd to play more
$newbie_engines             = '8';                              // If a destroyed player has a engines less than newbie engines, he will be regen'd to play more
$newbie_power               = '8';                              // If a destroyed player has a power less than newbie power, he will be regen'd to play more
$newbie_computer            = '8';                              // If a destroyed player has a computer less than newbie computer, he will be regen'd to play more
$newbie_sensors             = '8';                              // If a destroyed player has a sensors less than newbie sensors, he will be regen'd to play more
$newbie_armor               = '8';                              // If a destroyed player has a armor less than newbie armor, he will be regen'd to play more
$newbie_shields             = '8';                              // If a destroyed player has a shields less than newbie shield, he will be regen'd to play more
$newbie_beams               = '8';                              // If a destroyed player has a beams less than newbie beams, he will be regen'd to play more
$newbie_torp_launchers      = '8';                              // If a destroyed player has a torp_launcher less than newbie torp_launcher, he will be regen'd to play more.
$newbie_cloak               = '8';                              // If a destroyed player has a cloak less than newbie cloak, he will be regen'd to play more.
$allow_fullscan             = true;                             // Allow players to use full long range scan during this game?
$allow_navcomp              = true;                             // Allow players to use the Navigation computer during this game?
$allow_ibank                = true;                             // Allow players to use the Intergalactic Bank (IGB) during this game?
$allow_genesis_destroy      = false;                            // Allow players to use genesis torps to destroy planets?
$ibank_interest             = 0.0003;                           // Interest rate for account funds - Note that this is calculated every system update!
$ibank_paymentfee           = 0.05;                             // Paymentfee
$ibank_loaninterest         = 0.0010;                           // Loan interest (good idea to put double what you get on a planet)
$ibank_loanfactor           = 0.10;                             // One-time loan fee
$ibank_loanlimit            = 0.25;                             // Maximum loan allowed, percent of net worth
$default_prod_ore           = 20.0;                             // Default planet ore production percentage
$default_prod_organics      = 20.0;                             // Default planet organics production percentage
$default_prod_goods         = 20.0;                             // Default planet goods production percentage
$default_prod_energy        = 20.0;                             // Default planet energy production percentage
$default_prod_fighters      = 10.0;                             // Default planet fighters production percentage
$default_prod_torp          = 10.0;                             // Default planet torpedo production percentage
$ore_price                  = 11;                               // Default price for ore
$ore_delta                  = 5;                                // The delta, or difference for ore to range + or - from the default to allow trading profitably
$ore_rate                   = 75000;                            // The amount of ore that is regenerated by a port every tick (times the port_regenrate)
$ore_prate                  = 0.25;                             // The rate of production for ore on a planet (times production, times player/planet setting for ore_prate)
$ore_limit                  = 100000000;                        // The maximum amount of ore a port will accept or produce up to
$organics_price             = 5;                                // Default price of organics
$organics_delta             = 2;                                // The delta, or difference for organics to range + or - from the default to allow trading profitably
$organics_rate              = 5000;                             // The amount of organics that is regenerated by a port every tick (times the port_regenrate)
$organics_prate             = 0.5;                              // The rate of production for organics on a planet (times production, times player/planet setting for org_prate)
$organics_limit             = 100000000;                        // The maximum amount of organics a port will accept or produce up to
$goods_price                = 15;                               // Default price of goods
$goods_delta                = 7;                                // The delta, or difference for goods to range + or - from the default to allow trading profitably
$goods_rate                 = 75000;                            // The amount of goods that is regenerated by a port every tick (times the port_regenrate)
$goods_prate                = 0.25;                             // The rate of production for goods on a planet (times production, times player/planet setting for goods_prate)
$goods_limit                = 100000000;                        // The maximum amount of goods a port will accept or produce up to
$energy_price               = 3;                                // Default price of energy
$energy_delta               = 1;                                // The delta, or difference for energy to range + or - from the default to allow trading profitably
$energy_rate                = 75000;                            // The amount of energy that is regenerated by a port every tick (times the port_regenrate)
$energy_prate               = 0.5;                              // The rate of production for energy on a planet (times production, times player/planet setting for energy_prate)
$energy_limit               = 1000000000;                       // The maximum amount of energy a port will accept or produce up to
$inventory_factor           = 1;                                // The number of units that a single hull can hold
$upgrade_cost               = 1000;                             // Upgrade price is (upgrade factor OR 2)^(level difference) times the upgrade cost
$upgrade_factor             = 2;                                // Upgrade factor is the numeric base (usually 2) that is raised to the power of level difference for determining cost
$level_factor               = 1.5;                              // How effective a level is. amount = level_factor ^ item_level (possibly times another value, depending on the item)
$dev_genesis_price          = 1000000;                          // The price for a genesis device purchased at a special port
$dev_beacon_price           = 100;                              // The price for a beacon purchased at a special port
$dev_emerwarp_price         = 1000000;                          // The price for an emergency warp device purchased at a special port
$dev_warpedit_price         = 100000;                           // The price for a warp editor purchased at a special port
$dev_minedeflector_price    = 10;                               // The price for a mine deflector purchased at a special port
$dev_escapepod_price        = 100000;                           // The price for an escape pod purchased at a special port
$dev_fuelscoop_price        = 100000;                           // The price for a fuel scoop (gives energy while real spacing) purchased at a special port
$dev_lssd_price             = 10000000;                         // The price for a last seen ship device purchased at a special port
$fighter_price              = 50;                               // The price for a fighter purchased at a special port
$fighter_prate              = 0.01;                             // The rate of production for fighters on a planet (times production, times player/planet setting for fit_prate)
$torpedo_price              = 25;                               // The price for a torpedo purchased at a special port
$torpedo_prate              = 0.025;                            // The rate of production for torpedoes on a planet (times production, times player/planet setting for torp_prate)
$torp_dmg_rate              = 10;                               // The amount of damage a single torpedo will cause
$credits_prate              = 3.0;                              // The rate of production for credits on a planet (times production, times player/planet setting for 100% minus all prates)
$armor_price                = 5;                                // The price for units of armor purchased at a special port
$basedefense                = 1;                                // Additional factor added to tech levels by having a base on your planet. All your base are belong to us.
$colonist_price             = 5;                                // The standard price for a colonist at a special port
$colonist_production_rate   = 0.005;                            // The rate of production for colonists on a planet (prior to consideration of organics)
$colonist_reproduction_rate = 0.0005;                           // The rate of reproduction for colonists on a planet after consideration of starvation due to organics
$colonist_limit             = 100000000;                        // The maximum number of colonists on a planet
$organics_consumption       = 0.05;                             // How many units of organics does a single colonist eat (require to avoid starvation)
$starvation_death_rate      = 0.01;                             // If there is insufficient organics, colonists die of starvation at this rate/percentage
$interest_rate              = 1.0005;                           // The interest rate offered by the IGB
$base_ore                   = 10000;                            // The amount of ore required to be placed on a planet to create a base.
$base_goods                 = 10000;                            // The amount of goods required to be placed on a planet to create a base.
$base_organics              = 10000;                            // The amount of organics required to be placed on a planet to create a base.
$base_credits               = 10000000;                         // The amount of credits required to be placed on a planet to create a base.
$start_fighters             = 10;                               // The amount of fighters on the ship the player starts with
$start_armor                = 10;                               // The armor a player starts with
$start_credits              = 1000;                             // The credits a player starts the game with
$start_energy               = 100;                              // The amount of energy on the ship the player starts with
$start_turns                = 1200;                             // The number of turns all players are given at the start of the game
$start_lssd                 = 'N';                              // Do ships start with an lssd ?
$start_editors              = 0;                                // Starting warp editors
$start_minedeflectors       = 0;                                // Start mine deflectors
$start_emerwarp             = 0;                                // Start emergency warp units
$start_beacon               = 0;                                // Start space_beacons
$start_genesis              = 0;                                // Starting genesis torps
$escape                     = 'N';                              // Start game equipped with escape pod?
$scoop                      = 'N';                              // Start game equipped with fuel scoop?
$max_turns                  = 2500;                             // The maximum number of turns a player can receive
$max_emerwarp               = 10;                               // The maximum number of emergency warp devices a player can have
$fullscan_cost              = 1;                                // The cost in turns for doing a full scan
$scan_error_factor          = 20;                               // The percentage added to the comparison of cloak to sensors to determne the possibility of error
$max_planets_sector         = 5;                                // The maximum number of planets allowed in a sector
$max_traderoutes_player     = 40;                               // The maximum number of saved traderoutes a player can have
$min_bases_to_own           = 3;                                // The minimum number of planets with bases in a sector that a player needs to have to take ownership of the zone
$default_lang               = 'english';                        // The default language the game displays in until a player chooses a language
$IGB_min_turns              = 1200;                             // Turns a player has to play before ship transfers are allowed 0=disable
$IGB_svalue                 = 0.15;                             // Max amount of sender's value allowed for ship transfers 0=disable
$IGB_trate                  = 1440;                             // Time (in minutes) before two similar transfers are allowed for ship transfers.0=disable
$IGB_lrate                  = 1440;                             // Time (in minutes) players have to repay a loan
$IGB_tconsolidate           = 10;                               // Cost in turns for consolidate : 1/$IGB_consolidate
$corp_planet_transfers      = 0;                                // If transferring credits to/from corp planets is allowed. 1=enable
$min_value_capture          = 0;                                // Percantage of planet's value a ship must be worth to be able to capture it. 0=disable
$defence_degrade_rate       = 0.05;                             // The percentage rate at which defenses (fits, mines) degrade during scheduler runs
$energy_per_fighter         = 0.10;                             // The amount of energy needed (from planets in sector) to maintain a fighter during scheduler runs
$bounty_maxvalue            = 0.15;                             // Max amount a player can place as bounty - good idea to make it the same as $IGB_svalue. 0=disable
$bounty_ratio               = 0.75;                             // Ratio of players networth before attacking results in a bounty. 0=disable
$bounty_minturns            = 500;                              // Minimum number of turns a target must have had before attacking them may not get you a bounty. 0=disable
$display_password           = false;                            // If true, will display password on signup screen.
$space_plague_kills         = 0.20;                             // Percentage of colonists killed by space plague
$max_credits_without_base   = 10000000;                         // Max amount of credits allowed on a planet without a base
$sofa_on                    = false;                            // Is the sub-orbital fighter (sofa) attack allowed in this game?
$ksm_allowed                = true;                             // Is the known space map allowed in this game?
$xenobe_max                 = 10;                               // Sets the number of xenobe in the universe
$xen_start_credits          = 1000000;                          // What Xenobe start with
$xen_unemployment           = 100000;                           // Amount of credits each xenobe receive on each xenobe tick
$xen_aggression             = 100;                              // Percent of xenobe that are aggressive or hostile
$xen_planets                = 5;                                // Percent of created xenobe that will own planets. Recommended to keep at small percentage
$xenstartsize               = 15;                               // Max starting size of Xenobes at universe creation
$port_regenrate             = 10;                               // The amount of units regenerated by ports during a scheduler tick
$footer_style               = 'old';                            // Switch between old style footer and new style. Old is text, and only the time until next update. New is a table including server time.
$footer_show_debug          = true;                             // Should the footer show the memory and time to generate page?
$sched_planet_valid_credits = true;                             // Limit captured planets Max Credits to max_credits_without_base
$max_upgrades_devices       = 55;                               // Must stay at 55 due to PHP/MySQL cap limit.
$max_emerwarp               = 10;                               // The maximum number of emergency warp devices a player can have at one time
$max_genesis                = 10;                               // The maximum number of genesis devices a player can have at one time
$max_beacons                = 10;                               // The maximum number of beacons a player can have at one time
$max_warpedit               = 10;                               // The maximum number of warpeditors a player can have at one time
$bounty_all_special         = true;                             // Stop access on all Special Ports when you have a federation bounty on you.
$bnt_ls                     = false;                            // Should the game register with the list server? (currently not functional)
$local_number_dec_point     = '.';                              // Localization (regional) settings - soon to be moved into languages
$local_number_thousands_sep = ',';                              // Localization (regional) settings - soon to be moved into languages
$language                   = 'english';                        // Localization (regional) settings - soon to be moved into languages
$link_forums                = 'http://forums.blacknova.net';    // Address for the forum link
$email_server               = 'mail.example.com';               // What mail server (an FQDN DNS name) should emails be sent from?
$adminpass                  = 'secret';                         // The administrator password
$admin_mail                 = 'admin@example.com';              // The administrator email address
$adminname                  = 'Admin Name';                     // The title for the administrator (used when emailing)

$crypt_salt                 = '$2a$07$bntsecretsaltforpasswords$';

require "global_includes.php";                                  // A central location for including/requiring other files - Note that we use require because the game cannot function without it.
?>
