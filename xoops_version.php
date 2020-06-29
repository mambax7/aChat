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
 * @author          XOOPS Development Team <https://xoops.org>
 * @copyright       {@link https://xoops.org/ XOOPS Project}
 * @license         GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)
 */
$moduleDirName      = basename(__DIR__);
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
$modversion         = [
    'version'             => 3.01,
    'module_status'       => 'Beta 1',
    'release_date'        => '2020/06/27',
    'name'                => _MI_ACHAT_NAME,
    'description'         => _MI_ACHAT_DESC,
    'release'             => '2020-06-27',
    'author'              => 'Thomas Riccardi, alias Niluge_KiWi, Mamba',
    'author_mail'         => 'kiwiiii@gmail.com',
    'author_website_url'  => 'https://xoops.org',
    'author_website_name' => 'XOOPS Project',
    'credits'             => 'XOOPS Development Team',
    //    'license' => 'GNU GPL 2 or later (https://www.gnu.org/licenses/gpl-2.0.html)',
    'license'             => 'GPL 2.0 or later',
    'license_url'         => 'www.gnu.org/licenses/gpl-2.0.html',
    'release_info'        => 'release_info',
    'release_file'        => XOOPS_URL . "/modules/{$moduleDirName}/docs/release_info file",
    'manual'              => 'Installation.txt',
    'manual_file'         => XOOPS_URL . "/modules/{$moduleDirName}/docs/link to manual file",
    'min_php'             => '7.1',
    'min_xoops'           => '2.5.10',
    'min_admin'           => '1.2',
    'min_db'              => ['mysql' => '5.5'],
    'image'               => 'assets/images/logoModule.png',
    'dirname'             => $moduleDirName,
    'modicons16'          => 'assets/images/icons/16',
    'modicons32'          => 'assets/images/icons/32',
    //About
    'demo_site_url'       => 'https://xoops.org',
    'demo_site_name'      => 'XOOPS Demo Site',
    'support_url'         => 'https://xoops.org/modules/newbb',
    'support_name'        => 'Support Forum',
    'module_website_url'  => 'www.xoops.org',
    'module_website_name' => 'XOOPS Project',
    // Admin system menu
    'system_menu'         => 1,
    // Admin things
    'hasAdmin'            => 1,
    'adminindex'          => 'admin/index.php',
    'adminmenu'           => 'admin/menu.php',
    // Menu
    'hasMain'             => 1,
    // Scripts to run upon installation or update
    'onInstall'           => 'include/oninstall.php',
    'onUpdate'            => 'include/onupdate.php',
    'onUninstall'         => 'include/onuninstall.php',
    // ------------------- Mysql -----------------------------
    'sqlfile'             => ['mysql' => 'sql/mysql.sql'],
    // ------------------- Tables ----------------------------
    'tables'              => [
        $moduleDirName . '_' . 'messages',
    ],
];
// ------------------- Search -----------------------------//
$modversion['hasSearch']      = 1;
$modversion['search']['file'] = 'include/search.inc.php';
$modversion['search']['func'] = 'achat_search';
//  ------------------- Comments -----------------------------//
$modversion['hasComments']          = 1;
$modversion['comments']['itemName'] = 'com_id';
$modversion['comments']['pageName'] = 'comments.php';
// Comment callback functions
$modversion['comments']['callbackFile']        = 'include/comment_functions.php';
$modversion['comments']['callback']['approve'] = 'achatCommentsApprove';
$modversion['comments']['callback']['update']  = 'achatCommentsUpdate';
//  ------------------- Templates -----------------------------//
$modversion['templates'][] = ['file' => 'achat_header.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'achat_index.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'achat_messages.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'achat_messages_list0.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'achat_footer.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'admin/achat_admin_about.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'admin/achat_admin_help.tpl', 'description' => ''];
$modversion['templates'][] = ['file' => 'admin/achat_admin_messages.tpl', 'description' => ''];
//$modversion['onUpdate']    = 'update/achat01_to_achat02.php';
$modversion['sub'][1]      = [
    'name' => _MI_ACHAT_SMNAME1,
    'url'  => 'viewlogs.php',
];
$modversion['sub'][]       = [
    'name' => _MI_ACHAT_SMNAME2,
    'url'  => 'viewarchives.php',
];
// Module css
$modversion['css'] = 'assets/css/achat.css';
// Templates
$modversion['templates'][1] = [
    'file'        => 'achat_display.tpl',
    'description' => _MI_ACHAT_TDESC0,
];
$modversion['templates'][]  = [
    'file'        => 'achat_postmessage.tpl',
    'description' => _MI_ACHAT_TDESC1,
];
$modversion['templates'][]  = [
    'file'        => 'achat_viewlogs.tpl',
    'description' => _MI_ACHAT_TDESC2,
];
// ------------------- Help files ------------------- //
$modversion['help']        = 'page=help';
$modversion['helpsection'] = [
    ['name' => MI_ACHAT_OVERVIEW, 'link' => 'page=help'],
    ['name' => MI_ACHAT_DISCLAIMER, 'link' => 'page=disclaimer'],
    ['name' => MI_ACHAT_LICENSE, 'link' => 'page=license'],
    ['name' => MI_ACHAT_SUPPORT, 'link' => 'page=support'],
];
// ------------------- Blocks -----------------------------//
$modversion['blocks'][1] = [
    'file'        => 'achat_display.php',
    'name'        => _MI_ACHAT_BNAME1,
    'description' => _MI_ACHAT_BDESC1,
    'show_func'   => 'b_achat_display_show',
    'edit_func'   => 'b_achat_display_edit',
    'options'     => '1|10|180|1.5|23',
    'template'    => 'achat_block_display.tpl',
];
$modversion['blocks'][]  = [
    'file'        => 'achat_display.php',
    'name'        => _MI_ACHAT_BNAME2,
    'description' => _MI_ACHAT_BDESC2,
    'show_func'   => 'b_achat_display_show',
    'edit_func'   => 'b_achat_display_edit',
    'options'     => '0|10',
    'template'    => 'achat_block_static.tpl',
];
$modversion['blocks'][]  = [
    'file'        => 'messages.php',
    'name'        => MI_ACHAT_MESSAGES_BLOCK,
    'description' => '',
    'show_func'   => 'showAchatMessages',
    'edit_func'   => 'editMessages',
    'options'     => '|5|25|0',
    'template'    => 'achat_messages_block.tpl',
];
// ------------------- Config Options -----------------------------//
$modversion['config'][1] = [
    'name'        => 'nbre_msg_aff',
    'title'       => '_MI_ACHAT_NBRE_MSG_AFF',
    'description' => '_MI_ACHAT_NBRE_MSG_AFFDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 25,
    'category'    => 'achat_settings',
];
$modversion['config'][]  = [
    'name'        => 'tmp_refresh',
    'title'       => '_MI_ACHAT_TMP_REFRESH',
    'description' => '_MI_ACHAT_TMP_REFRESHDSC',
    'formtype'    => 'textbox',
    'valuetype'   => 'float',
    'default'     => 1.5,
    'category'    => 'achat_settings',
];
$modversion['config'][]  = [
    'name'        => 'use_smilies',
    'title'       => '_MI_ACHAT_USER_SMILIES',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'achat_settings',
];
$modversion['config'][]  = [
    'name'        => 'use_bbcodes',
    'title'       => '_MI_ACHAT_USE_BBCODES',
    'description' => '',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'achat_settings',
];
$modversion['config'][]  = [
    'name'        => 'allowed_colors',
    'title'       => '_MI_ACHAT_ALLOWED_COLORS',
    'description' => '_MI_ACHAT_ALLOWED_COLORSDESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'array',
    'default'     => [
        '0' => '000000',
        '1' => 'dc0000',
        '2' => '4cb5e8',
        '3' => '6600cc',
        '4' => '336600',
        '5' => '000099',
        '6' => 'ff6600',
        '7' => '660000',
    ],
    'category'    => 'achat_settings',
];
$modversion['config'][]  = [
    'name'        => 'nick4guests',
    'title'       => '_MI_ACHAT_NICK4GUESTS',
    'description' => '_MI_ACHAT_NICK4GUESTSDESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
    'category'    => 'achat_settings',
];
$modversion['config'][]  = [
    'name'        => 'purge_folder',
    'title'       => '_MI_ACHAT_PURGE_FOLDER',
    'description' => '_MI_ACHAT_PURGE_FOLDERDESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'modules/achat/logs',
    'category'    => 'achat_settings',
];
xoops_load('xoopseditorhandler');
$editorHandler          = \XoopsEditorHandler::getInstance();
$modversion['config'][] = [
    'name'        => 'achatEditorAdmin',
    'title'       => 'MI_ACHAT_EDITOR_ADMIN',
    'description' => 'MI_ACHAT_EDITOR_DESC_ADMIN',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => array_flip($editorHandler->getList()),
    'default'     => 'tinymce',
];
$modversion['config'][] = [
    'name'        => 'achatEditorUser',
    'title'       => 'MI_ACHAT_EDITOR_USER',
    'description' => 'MI_ACHAT_EDITOR_DESC_USER',
    'formtype'    => 'select',
    'valuetype'   => 'text',
    'options'     => array_flip($editorHandler->getList()),
    'default'     => 'dhtmltextarea',
];
// -------------- Get groups --------------
/** @var \XoopsMemberHandler $memberHandler */
$memberHandler = xoops_getHandler('member');
$xoopsGroups   = $memberHandler->getGroupList();
foreach ($xoopsGroups as $key => $group) {
    $groups[$group] = $key;
}
$modversion['config'][] = [
    'name'        => 'groups',
    'title'       => 'MI_ACHAT_GROUPS',
    'description' => 'MI_ACHAT_GROUPS_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'options'     => $groups,
    'default'     => $groups,
];
// -------------- Get Admin groups --------------
$criteria = new \CriteriaCompo();
$criteria->add(new \Criteria('group_type', 'Admin'));
/** @var \XoopsMemberHandler $memberHandler */
$memberHandler    = xoops_getHandler('member');
$adminXoopsGroups = $memberHandler->getGroupList($criteria);
foreach ($adminXoopsGroups as $key => $adminGroup) {
    $admin_groups[$adminGroup] = $key;
}
$modversion['config'][] = [
    'name'        => 'admin_groups',
    'title'       => 'MI_ACHAT_ADMINGROUPS',
    'description' => 'MI_ACHAT_ADMINGROUPS_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'options'     => $admin_groups,
    'default'     => $admin_groups,
];
$modversion['config'][] = [
    'name'        => 'keywords',
    'title'       => 'MI_ACHAT_KEYWORDS',
    'description' => 'MI_ACHAT_KEYWORDS_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'text',
    'default'     => 'achat,messages',
];
// --------------Uploads : maxsize of image --------------
$modversion['config'][] = [
    'name'        => 'maxsize',
    'title'       => 'MI_ACHAT_MAXSIZE',
    'description' => 'MI_ACHAT_MAXSIZE_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 5000000,
];
// --------------Uploads : mimetypes of image --------------
$modversion['config'][] = [
    'name'        => 'mimetypes',
    'title'       => 'MI_ACHAT_MIMETYPES',
    'description' => 'MI_ACHAT_MIMETYPES_DESC',
    'formtype'    => 'select_multi',
    'valuetype'   => 'array',
    'default'     => ['image/gif', 'image/jpeg', 'image/jpg', 'image/png'],
    'options'     => [
        'bmp'   => 'image/bmp',
        'gif'   => 'image/gif',
        'pjpeg' => 'image/pjpeg',
        'jpeg'  => 'image/jpeg',
        'jpg'   => 'image/jpg',
        'jpe'   => 'image/jpe',
        'png'   => 'image/png',
    ],
];
$modversion['config'][] = [
    'name'        => 'adminpager',
    'title'       => 'MI_ACHAT_ADMINPAGER',
    'description' => 'MI_ACHAT_ADMINPAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];
$modversion['config'][] = [
    'name'        => 'userpager',
    'title'       => 'MI_ACHAT_USERPAGER',
    'description' => 'MI_ACHAT_USERPAGER_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 10,
];
$modversion['config'][] = [
    'name'        => 'advertise',
    'title'       => 'MI_ACHAT_ADVERTISE',
    'description' => 'MI_ACHAT_ADVERTISE_DESC',
    'formtype'    => 'textarea',
    'valuetype'   => 'text',
    'default'     => '',
];
$modversion['config'][] = [
    'name'        => 'bookmarks',
    'title'       => 'MI_ACHAT_BOOKMARKS',
    'description' => 'MI_ACHAT_BOOKMARKS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
$modversion['config'][] = [
    'name'        => 'fbcomments',
    'title'       => 'MI_ACHAT_FBCOMMENTS',
    'description' => 'MI_ACHAT_FBCOMMENTS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
// Truncate Max. length
$modversion['config'][] = [
    'name'        => 'truncatelength',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'TRUNCATE_LENGTH',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'TRUNCATE_LENGTH_DESC',
    'formtype'    => 'textbox',
    'valuetype'   => 'int',
    'default'     => 100,
];
/**
 * Make Sample button visible?
 */
$modversion['config'][] = [
    'name'        => 'displaySampleButton',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_SAMPLE_BUTTON_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 1,
];
/**
 * Show Developer Tools?
 */
$modversion['config'][] = [
    'name'        => 'displayDeveloperTools',
    'title'       => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS',
    'description' => 'CO_' . $moduleDirNameUpper . '_' . 'SHOW_DEV_TOOLS_DESC',
    'formtype'    => 'yesno',
    'valuetype'   => 'int',
    'default'     => 0,
];
// -------------- Notifications achat --------------
$modversion['hasNotification']             = 1;
$modversion['notification']['lookup_file'] = 'include/notification.inc.php';
$modversion['notification']['lookup_func'] = 'achat_notify_iteminfo';
$modversion['notification']['category'][]  = [
    'name'           => 'global',
    'title'          => MI_ACHAT_GLOBAL_NOTIFY,
    'description'    => MI_ACHAT_GLOBAL_NOTIFY_DESC,
    'subscribe_from' => ['index.php', 'viewcat.php', 'singlefile.php'],
];
$modversion['notification']['category'][]  = [
    'name'           => 'category',
    'title'          => MI_ACHAT_CATEGORY_NOTIFY,
    'description'    => MI_ACHAT_CATEGORY_NOTIFY_DESC,
    'subscribe_from' => ['viewcat.php', 'singlefile.php'],
    'item_name'      => 'cid',
    'allow_bookmark' => 1,
];
$modversion['notification']['category'][]  = [
    'name'           => 'file',
    'title'          => MI_ACHAT_FILE_NOTIFY,
    'description'    => MI_ACHAT_FILE_NOTIFY_DESC,
    'subscribe_from' => 'singlefile.php',
    'item_name'      => 'lid',
    'allow_bookmark' => 1,
];
$modversion['notification']['event'][]     = [
    'name'          => 'new_category',
    'category'      => 'global',
    'title'         => MI_ACHAT_GLOBAL_NEWCATEGORY_NOTIFY,
    'caption'       => MI_ACHAT_GLOBAL_NEWCATEGORY_NOTIFY_CAPTION,
    'description'   => MI_ACHAT_GLOBAL_NEWCATEGORY_NOTIFY_DESC,
    'mail_template' => 'global_newcategory_notify',
    'mail_subject'  => MI_ACHAT_GLOBAL_NEWCATEGORY_NOTIFY_SUBJECT,
];
$modversion['notification']['event'][]     = [
    'name'          => 'file_modify',
    'category'      => 'global',
    'admin_only'    => 1,
    'title'         => MI_ACHAT_GLOBAL_FILEMODIFY_NOTIFY,
    'caption'       => MI_ACHAT_GLOBAL_FILEMODIFY_NOTIFY_CAPTION,
    'description'   => MI_ACHAT_GLOBAL_FILEMODIFY_NOTIFY_DESC,
    'mail_template' => 'global_filemodify_notify',
    'mail_subject'  => MI_ACHAT_GLOBAL_FILEMODIFY_NOTIFY_SUBJECT,
];
$modversion['notification']['event'][]     = [
    'name'          => 'file_broken',
    'category'      => 'global',
    'admin_only'    => 1,
    'title'         => MI_ACHAT_GLOBAL_FILEBROKEN_NOTIFY,
    'caption'       => MI_ACHAT_GLOBAL_FILEBROKEN_NOTIFY_CAPTION,
    'description'   => MI_ACHAT_GLOBAL_FILEBROKEN_NOTIFY_DESC,
    'mail_template' => 'global_filebroken_notify',
    'mail_subject'  => MI_ACHAT_GLOBAL_FILEBROKEN_NOTIFY_SUBJECT,
];
$modversion['notification']['event'][]     = [
    'name'          => 'file_submit',
    'category'      => 'global',
    'admin_only'    => 1,
    'title'         => MI_ACHAT_GLOBAL_FILESUBMIT_NOTIFY,
    'caption'       => MI_ACHAT_GLOBAL_FILESUBMIT_NOTIFY_CAPTION,
    'description'   => MI_ACHAT_GLOBAL_FILESUBMIT_NOTIFY_DESC,
    'mail_template' => 'global_filesubmit_notify',
    'mail_subject'  => MI_ACHAT_GLOBAL_FILESUBMIT_NOTIFY_SUBJECT,
];
$modversion['notification']['event'][]     = [
    'name'          => 'new_file',
    'category'      => 'global',
    'title'         => MI_ACHAT_GLOBAL_NEWFILE_NOTIFY,
    'caption'       => MI_ACHAT_GLOBAL_NEWFILE_NOTIFY_CAPTION,
    'description'   => MI_ACHAT_GLOBAL_NEWFILE_NOTIFY_DESC,
    'mail_template' => 'global_newfile_notify',
    'mail_subject'  => MI_ACHAT_GLOBAL_NEWFILE_NOTIFY_SUBJECT,
];
$modversion['notification']['event'][]     = [
    'name'          => 'file_submit',
    'category'      => 'category',
    'admin_only'    => 1,
    'title'         => MI_ACHAT_CATEGORY_FILESUBMIT_NOTIFY,
    'caption'       => MI_ACHAT_CATEGORY_FILESUBMIT_NOTIFY_CAPTION,
    'description'   => MI_ACHAT_CATEGORY_FILESUBMIT_NOTIFY_DESC,
    'mail_template' => 'category_filesubmit_notify',
    'mail_subject'  => MI_ACHAT_CATEGORY_FILESUBMIT_NOTIFY_SUBJECT,
];
$modversion['notification']['event'][]     = [
    'name'          => 'new_file',
    'category'      => 'category',
    'title'         => MI_ACHAT_CATEGORY_NEWFILE_NOTIFY,
    'caption'       => MI_ACHAT_CATEGORY_NEWFILE_NOTIFY_CAPTION,
    'description'   => MI_ACHAT_CATEGORY_NEWFILE_NOTIFY_DESC,
    'mail_template' => 'category_newfile_notify',
    'mail_subject'  => MI_ACHAT_CATEGORY_NEWFILE_NOTIFY_SUBJECT,
];
$modversion['notification']['event'][]     = [
    'name'          => 'approve',
    'category'      => 'file',
    'admin_only'    => 1,
    'title'         => MI_ACHAT_FILE_APPROVE_NOTIFY,
    'caption'       => MI_ACHAT_FILE_APPROVE_NOTIFY_CAPTION,
    'description'   => MI_ACHAT_FILE_APPROVE_NOTIFY_DESC,
    'mail_template' => 'file_approve_notify',
    'mail_subject'  => MI_ACHAT_FILE_APPROVE_NOTIFY_SUBJECT,
];
