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
// Menu
define('_AM_ACHAT_MODULEADMIN', 'Module Admin:');
define('_AM_ACHAT_CREDIT', 'aChat 0.2 is an original creation of Niluge_KiWi<br>(c) Jully-Augustus 2006');
// Home
define('_AM_ACHAT_WELCOME', 'Welcome to the aChat module admin.');
define('_AM_ACHAT_NBRE_MSG', 'Number of messages in the database');
define('_AM_ACHAT_MESSAGES', 'messages');
define('_AM_ACHAT_EMPTY_FIELD', 'Please fill the field(s).');
//Index
define('AM_ACHAT_STATISTICS', 'Achat statistics');
define('AM_ACHAT_THEREARE_MESSAGES', "There are <span class='bold'>%s</span> Messages in the database");
//Buttons
define('AM_ACHAT_ADD_MESSAGES', 'Add new Messages');
define('AM_ACHAT_MESSAGES_LIST', 'List of Messages');
//General
define('AM_ACHAT_FORMOK', 'Registered successfull');
define('AM_ACHAT_FORMDELOK', 'Deleted successfull');
define('AM_ACHAT_FORMSUREDEL', "Are you sure to Delete: <span class='bold red'>%s</span></b>");
define('AM_ACHAT_FORMSURERENEW', "Are you sure to Renew: <span class='bold red'>%s</span></b>");
define('AM_ACHAT_FORMUPLOAD', 'Upload');
define('AM_ACHAT_FORMIMAGE_PATH', 'File presents in %s');
define('AM_ACHAT_FORM_ACTION', 'Action');
define('AM_ACHAT_SELECT', 'Select action for selected item(s)');
define('AM_ACHAT_SELECTED_DELETE', 'Delete selected item(s)');
define('AM_ACHAT_SELECTED_ACTIVATE', 'Activate selected item(s)');
define('AM_ACHAT_SELECTED_DEACTIVATE', 'De-activate selected item(s)');
define('AM_ACHAT_SELECTED_ERROR', 'You selected nothing to delete');
define('AM_ACHAT_CLONED_OK', 'Record cloned successfully');
define('AM_ACHAT_CLONED_FAILED', 'Cloning of the record has failed');
// Permissions
define('_AM_ACHAT_PERM_CANPOST', 'Can post messages');
// Purge
define('_AM_ACHAT_PURGEPERNBRE', 'Purge per number of messages');
define('_AM_ACHAT_PURGE_HOWMANY', 'Purge how many messages?');
define('_AM_ACHAT_PURGE_CREATELOG', 'Create a logfile with the purged messages?');
define('_AM_ACHAT_PURGE_VALIDATE', 'Are you sure to want to purge&nbsp;');
define('_AM_ACHAT_PURGE_SUPPR_NOLOG', 'without logfile');
define('_AM_ACHAT_PURGE_ERROR_WRITEFILE', 'An error appeared during the creation of the logfile. Please verify that the folder on the module parameters is correct and that there are the good rights on it.');
define('_AM_ACHAT_PURGE_LOG_WRITTEN', 'Logfile created.');
define('_AM_ACHAT_PURGE_CANCELED', 'Purge Canceled.');
define('_AM_ACHAT_PURGE_OK', 'Purge OK.');
define('_AM_ACHAT_PURGE_NBREMSGDEL', 'Number of deleted messages: ');
define('_AM_ACHAT_PURGE_ERROR', 'An error appeared during the purge.');
define('_AM_ACHAT_PURGEPERDATE', 'Purge per date');
define('_AM_ACHAT_PURGE_KEEP_HMDAYS', 'Keep messages from the last x days');
define('_AM_ACHAT_PURGE_VALIDATE_PERDAY', 'the messages posted before');
define('_AM_ACHAT_PURGE_VALIDATE_PERDAY2', ' last days');
define('_AM_ACHAT_PURGE_NOMSG', 'No message to delete.');
// Delete Messages
define('_AM_ACHAT_DELETEMSG', 'Delete a message');
define('_AM_ACHAT_DELETEMSG_MID', 'mid of the message to delete<br>(last number displayed when you put the mouse on the poster pseudo,<br> only displayed for admins)');
define('_AM_ACHAT_DELETEMSG_OK', 'Message number %u deleted.');
define('_AM_ACHAT_DELETEMSG_ERROR', 'An error has occured when deleting message number %u.');
// Utilities ( Clone ) ( from myHome module )
define('_AM_ACHAT_CLONE', 'Module cloning');
define(
    '_AM_ACHAT_CLONENAME',
    "Clone name<br><i>
                                         <ul>
                                             <li>Not more than 16 characters</li>
                                             <li>No special characters</li>
                                             <li>No already existing module name</li>
                                             <li>Capitals and spaces accepted</li>
                                         </ul></i>
                                         Sample: 'My Module 01'. "
);
define('_AM_ACHAT_SUBMIT', 'Clone!');
define('_AM_ACHAT_CLEAR', 'Delete');
define('_AM_ACHAT_CANCEL', 'Cancel');
define('_AM_ACHAT_CLONED', 'Module successfully cloned');
define('_AM_ACHAT_MODULEXISTS', 'This module already exists');
define('_AM_ACHAT_NOTCLONED', 'Clone settings are uncorrect');
define(
    '_AM_ACHAT_CLONE_TROUBLE',
    'Settings of your web host do not allow the cloning operation.
					 Please retry on a server which allow permissions change on the server.
                                         (For instance, on a local server)'
);
// Messages
define('AM_ACHAT_MESSAGES_ADD', 'Add a messages');
define('AM_ACHAT_MESSAGES_EDIT', 'Edit messages');
define('AM_ACHAT_MESSAGES_DELETE', 'Delete messages');
define('AM_ACHAT_MESSAGES_MID', 'ID');
define('AM_ACHAT_MESSAGES_UID', 'UserID');
define('AM_ACHAT_MESSAGES_UNAME', 'Name');
define('AM_ACHAT_MESSAGES_MSG', 'Msg');
define('AM_ACHAT_MESSAGES_COLOR', 'Color');
define('AM_ACHAT_MESSAGES_DATE', 'Date');
define('AM_ACHAT_MESSAGES_IP', 'IP');
//Blocks.php
//Permissions
define('AM_ACHAT_PERMISSIONS_GLOBAL', 'Global permissions');
define('AM_ACHAT_PERMISSIONS_GLOBAL_DESC', 'Only users in the group that you select may global this');
define('AM_ACHAT_PERMISSIONS_GLOBAL_4', 'Rate from user');
define('AM_ACHAT_PERMISSIONS_GLOBAL_8', 'Submit from user side');
define('AM_ACHAT_PERMISSIONS_GLOBAL_16', 'Auto approve');
define('AM_ACHAT_PERMISSIONS_APPROVE', 'Permissions to approve');
define('AM_ACHAT_PERMISSIONS_APPROVE_DESC', 'Only users in the group that you select may approve this');
define('AM_ACHAT_PERMISSIONS_VIEW', 'Permissions to view');
define('AM_ACHAT_PERMISSIONS_VIEW_DESC', 'Only users in the group that you select may view this');
define('AM_ACHAT_PERMISSIONS_SUBMIT', 'Permissions to submit');
define('AM_ACHAT_PERMISSIONS_SUBMIT_DESC', 'Only users in the group that you select may submit this');
define('AM_ACHAT_PERMISSIONS_GPERMUPDATED', 'Permissions have been changed successfully');
define('AM_ACHAT_PERMISSIONS_NOPERMSSET', 'Permission cannot be set: No messages created yet! Please create a messages first.');
//Errors
define('AM_ACHAT_UPGRADEFAILED0', "Update failed - couldn't rename field '%s'");
define('AM_ACHAT_UPGRADEFAILED1', "Update failed - couldn't add new fields");
define('AM_ACHAT_UPGRADEFAILED2', "Update failed - couldn't rename table '%s'");
define('AM_ACHAT_ERROR_COLUMN', 'Could not create column in database : %s');
define('AM_ACHAT_ERROR_BAD_XOOPS', 'This module requires XOOPS %s+ (%s installed)');
define('AM_ACHAT_ERROR_BAD_PHP', 'This module requires PHP version %s+ (%s installed)');
define('AM_ACHAT_ERROR_TAG_REMOVAL', 'Could not remove tags from Tag Module');
//directories
define('AM_ACHAT_AVAILABLE', "<span style='color : #008000;'>Available. </span>");
define('AM_ACHAT_NOTAVAILABLE', "<span style='color : #ff0000;'>is not available. </span>");
define('AM_ACHAT_NOTWRITABLE', "<span style='color : #ff0000;'>" . ' should have permission ( %1$d ), but it has ( %2$d )' . '</span>');
define('AM_ACHAT_CREATETHEDIR', 'Create it');
define('AM_ACHAT_SETMPERM', 'Set the permission');
define('AM_ACHAT_DIRCREATED', 'The directory has been created');
define('AM_ACHAT_DIRNOTCREATED', 'The directory can not be created');
define('AM_ACHAT_PERMSET', 'The permission has been set');
define('AM_ACHAT_PERMNOTSET', 'The permission can not be set');
define('AM_ACHAT_VIDEO_EXPIREWARNING', 'The publishing date is after expiration date!!!');
//Sample Data
define('AM_ACHAT_ADD_SAMPLEDATA', 'Import Sample Data (will delete ALL current data)');
define('AM_ACHAT_SAMPLEDATA_SUCCESS', 'Sample Date uploaded successfully');
define('AM_ACHAT_MAINTAINEDBY', 'is maintained by the');
