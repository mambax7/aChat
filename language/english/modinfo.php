<?php

declare(strict_types=1);
/*
 You may not change or alter any portion of this comment or credits
 of supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit authors.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
/**
 * Module: Achat
 *
 * @category        Module
 * @author          Niluge_Kiwi (kiwiiii@gmail.com)
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */
// The name of this module
define('_MI_ACHAT_NAME', 'aChat');
// A brief description of this module
define('_MI_ACHAT_DESC', 'A module for Chatting, a TagBoard with AJAX!');
// Menu
define('_MI_ACHAT_HOME', 'Home');
define('_MI_ACHAT_PURGE', 'Purge');
define('_MI_ACHAT_PERM', 'Permissions');
define('_MI_ACHAT_UTILITIES', 'Utilities');
define('MI_ACHAT_ADMENU2', 'Messages');
define('MI_ACHAT_ADMENU3', 'Feedback');
define('MI_ACHAT_ADMENU4', 'Migrate');
define('MI_ACHAT_ADMENU5', 'About');
define('_MI_ACHAT_SMNAME1', 'View logs');
define('_MI_ACHAT_SMNAME2', 'View archives');
define('_MI_ACHAT_GOTO_INDEX', 'Go to module');
define('_MI_ACHAT_HELP', 'Help');
// Templates
define('_MI_ACHAT_TDESC0', 'Main template for main display.');
define('_MI_ACHAT_TDESC1', 'Template for messages display');
define('_MI_ACHAT_TDESC2', 'Template for logs (purge function)');
// Blocks
define('_MI_ACHAT_BNAME1', 'aChat');
define('_MI_ACHAT_BDESC1', 'Block which displays the aChat');
define('_MI_ACHAT_BNAME2', 'Static aChat');
define('_MI_ACHAT_BDESC2', 'Preview block with lasts messages, without autorefresh and send form');
// Config
define('_MI_ACHAT_NBRE_MSG_AFF', 'Number of messages to display');
define('_MI_ACHAT_NBRE_MSG_AFFDSC', 'Number of messages to display on the pages of the module aChat (index.php)');
define('_MI_ACHAT_TMP_REFRESH', 'Refresh time');
define('_MI_ACHAT_TMP_REFRESHDSC', '(seconds)<br> You can put float numbur, for example 1.5, but a number given to three decimal place max!(otherwise javascript bug.)');
define('_MI_ACHAT_USER_SMILIES', 'Use the smilies?');
define('_MI_ACHAT_USE_BBCODES', 'Use the BBCodes?');
define('_MI_ACHAT_ALLOWED_COLORS', 'Available colors for the messages');
define('_MI_ACHAT_ALLOWED_COLORSDESC', 'Color on RGB hexa color, separated by |, and without #.<br>Example : "000000|FFFFFF" will allow Black and White colors<br>Empty for the 8 default colors.');
define('_MI_ACHAT_PURGE_FOLDER', 'Folder for logs (with purge function)');
define('_MI_ACHAT_PURGE_FOLDERDESC', 'Empty to use the default folder (modules/achat/logs)');
define('_MI_ACHAT_NICK4GUESTS', 'Anonymous can choose their nickname');
define('_MI_ACHAT_NICK4GUESTSDESC', 'Anonymous nicknames are displayed in grey (can be modified on modules/achat/assets/css/achat.css)');
//Blocks
define('MI_ACHAT_MESSAGES_BLOCK', 'Messages block');
//Config
define('MI_ACHAT_EDITOR_ADMIN', 'Editor: Admin');
define('MI_ACHAT_EDITOR_ADMIN_DESC', 'Select the Editor to use by the Admin');
define('MI_ACHAT_EDITOR_USER', 'Editor: User');
define('MI_ACHAT_EDITOR_USER_DESC', 'Select the Editor to use by the User');
define('MI_ACHAT_KEYWORDS', 'Keywords');
define('MI_ACHAT_KEYWORDS_DESC', 'Insert here the keywords (separate by comma)');
define('MI_ACHAT_ADMINPAGER', 'Admin: records / page');
define('MI_ACHAT_ADMINPAGER_DESC', 'Admin: # of records shown per page');
define('MI_ACHAT_USERPAGER', 'User: records / page');
define('MI_ACHAT_USERPAGER_DESC', 'User: # of records shown per page');
define('MI_ACHAT_MAXSIZE', 'Max size');
define('MI_ACHAT_MAXSIZE_DESC', 'Set a number of max size uploads file in byte');
define('MI_ACHAT_MIMETYPES', 'Mime Types');
define('MI_ACHAT_MIMETYPES_DESC', 'Set the mime types selected');
define('MI_ACHAT_IDPAYPAL', 'Paypal ID');
define('MI_ACHAT_IDPAYPAL_DESC', 'Insert here your PayPal ID for donactions.');
define('MI_ACHAT_ADVERTISE', 'Advertisement Code');
define('MI_ACHAT_ADVERTISE_DESC', 'Insert here the advertisement code');
define('MI_ACHAT_BOOKMARKS', 'Social Bookmarks');
define('MI_ACHAT_BOOKMARKS_DESC', 'Show Social Bookmarks in the form');
define('MI_ACHAT_FBCOMMENTS', 'Facebook comments');
define('MI_ACHAT_FBCOMMENTS_DESC', 'Allow Facebook comments in the form');
// Notifications
define('MI_ACHAT_GLOBAL_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_FILE_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_FILE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_NEWCATEGORY_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_NEWCATEGORY_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_NEWCATEGORY_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_NEWCATEGORY_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILEMODIFY_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILEMODIFY_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILEMODIFY_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILEMODIFY_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILEBROKEN_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILEBROKEN_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILEBROKEN_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILEBROKEN_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILESUBMIT_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILESUBMIT_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILESUBMIT_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_FILESUBMIT_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_NEWFILE_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_NEWFILE_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_NEWFILE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_GLOBAL_NEWFILE_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_FILESUBMIT_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_FILESUBMIT_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_FILESUBMIT_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_FILESUBMIT_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_NEWFILE_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_NEWFILE_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_NEWFILE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_CATEGORY_NEWFILE_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
define('MI_ACHAT_FILE_APPROVE_NOTIFY', 'Allow Facebook comments in the form');
define('MI_ACHAT_FILE_APPROVE_NOTIFY_CAPTION', 'Allow Facebook comments in the form');
define('MI_ACHAT_FILE_APPROVE_NOTIFY_DESC', 'Allow Facebook comments in the form');
define('MI_ACHAT_FILE_APPROVE_NOTIFY_SUBJECT', 'Allow Facebook comments in the form');
// Help
define('MI_ACHAT_DIRNAME', basename(dirname(dirname(__DIR__))));
define('MI_ACHAT_HELP_HEADER', __DIR__ . '/help/helpheader.tpl');
define('MI_ACHAT_BACK_2_ADMIN', 'Back to Administration of ');
define('MI_ACHAT_OVERVIEW', 'Overview');
// The name of this module
//define('MI_ACHAT_NAME', 'YYYYY Module Name');
//define('MI_ACHAT_HELP_DIR', __DIR__);
//help multi-page
define('MI_ACHAT_DISCLAIMER', 'Disclaimer');
define('MI_ACHAT_LICENSE', 'License');
define('MI_ACHAT_SUPPORT', 'Support');
//define('MI_ACHAT_REQUIREMENTS', 'Requirements');
//define('MI_ACHAT_CREDITS', 'Credits');
//define('MI_ACHAT_HOWTO', 'How To');
//define('MI_ACHAT_UPDATE', 'Update');
//define('MI_ACHAT_INSTALL', 'Install');
//define('MI_ACHAT_HISTORY', 'History');
// Permissions Groups
define('MI_ACHAT_GROUPS', 'Groups access');
define('MI_ACHAT_GROUPS_DESC', 'Select general access permission for groups.');
define('MI_ACHAT_ADMINGROUPS', 'Admin Group Permissions');
define('MI_ACHAT_ADMINGROUPS_DESC', 'Which groups have access to tools and permissions page');

//define('MI_ACHAT_SHOW_SAMPLE_BUTTON', 'Import Sample Button?');
//define('MI_ACHAT_SHOW_SAMPLE_BUTTON_DESC', 'If yes, the "Add Sample Data" button will be visible to the Admin. It is Yes as a default for first installation.');
