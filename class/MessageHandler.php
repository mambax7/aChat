<?php

declare(strict_types=1);

namespace XoopsModules\Achat;

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

/**
 * Class MessageHandler
 */
class MessageHandler extends \XoopsPersistableObjectHandler
{
    /**
     * @var Helper
     */
    public $helper;

    /**
     * Constructor
     * @param null|\XoopsDatabase             $db
     * @param null|\XoopsModules\Achat\Helper $helper
     */
    public function __construct(\XoopsDatabase $db = null, $helper = null)
    {
        /** @var \XoopsModules\Achat\Helper $this ->helper */
        $this->helper = $helper;
        parent::__construct($db, 'achat_messages', Message::class, 'mid', 'uname');
    }

    /**
     * @param bool $isNew
     *
     * @return \XoopsObject
     */
    public function create($isNew = true)
    {
        $obj         = parent::create($isNew);
        $obj->helper = $this->helper;
        return $obj;
    }

    /**
     * Insert message in database
     *
     *
     * @param mixed|\XoopsObject $messageObj
     * @return    bool   if message is inserted : TRUE
     */
    public function insert(\XoopsObject $messageObj, $force = true)//$messageObj)
    {
        // Message vierge pour récupérer les valeurs par défaut si les checkVars retournent false
        $emptymsgobj = $this->create();
        // Gestion des checkVar avant insertion
        foreach ($messageObj->vars as $k => $v) {
            ${$k}        = $v['value'];
            $checkMethod = 'checkVar_' . $k;
            if (method_exists($messageObj, $checkMethod)) {
                ${$k} = $messageObj->$checkMethod(${$k}) ? ${$k} : $emptymsgobj->getVar($k);
            }
        }
        $sql = 'INSERT INTO ' . $this->db->prefix('achat_messages') . " (uid, uname, msg, color, date, ip) VALUES ('$uid', '$uname', '$msg', '$color', '$date', '$ip')";
        return $this->db->queryF($sql);
    }

    /**
     * Get some {@link Message}s
     *
     * @param object $criteria  {@link CriteriaElement}
     * @param bool   $id_as_key Use the IDs as array-keys?
     *
     * @return    array   Array of {@link Message}s
     */
    public function &getObjects(\CriteriaElement $criteria = null, $id_as_key = false, $as_object = true) //$criteria = null, $id_as_key = false)
    {
        $ret   = [];
        $limit = $start = 0;
        $sql   = 'SELECT * FROM ' . $this->db->prefix('achat_messages');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $order = $criteria->getOrder();
            $order = !empty($order) ? ' ORDER BY mid ' . $order : '';
            $sql   .= ' ' . $criteria->renderWhere() . $order;
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        $result = $this->db->query($sql, $limit, $start);
        if (!$result) {
            return $ret;
        }
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $messageObj = $this->create();
            $messageObj->assignVars($myrow);
            if (!$id_as_key) {
                $ret[] = &$messageObj;
            } else {
                $ret[$myrow['mid']] = &$messageObj;
            }
            unset($messageObj);
        }
        return $ret;
    }

    /**
     * Clear messages for display
     *
     * @param array   Array of {@link Message}s
     * @param mixed $ret
     * @param mixed $array
     *
     * @return    array   Array of {@link Message}s
     */
    public function getMessagesForDisplay($ret, $array = true)
    {
        global $xoopsUser;
        $myts = \MyTextSanitizer::getInstance();
        // Configuration de l'affichage des messages
        $html    = 0;
        $smiley  = Utility::getModuleOptions('use_smilies');
        $bbcodes = Utility::getModuleOptions('use_bbcodes');
        $ret2    = [];
        // Boucle de traitement des variables pour l'affichage.
        foreach ($ret as $messageObj) {
            $uname = $messageObj->getVar('uname');
            if (empty($uname)) {
                $messageObj->setVar('uname', \XoopsUser::getUnameFromId($messageObj->getVar('uid')));
            }
            $messageObj->setVar('msg', $myts->displayTarea($messageObj->getVar('msg'), $html, $smiley, $bbcodes));
            $messageObj->setVar('date', formatTimestamp($messageObj->getVar('date')));
            $ret2[] = $messageObj;
        }
        if ($array) {
            return $this->MsgstoArray($ret2);
        }
        return $ret2;
    }

    /**
     * Returns an array representation of the object
     *
     * From xoops 2.2
     * @param mixed $messageObjArray
     * @return array
     */
    public function MsgstoArray($messageObjArray)
    {
        $ret = [];
        foreach ($messageObjArray as $messageObj) {
            $msg  = [];
            $vars = $messageObj->getVars();
            foreach (array_keys($vars) as $i) {
                $msg[$i] = $messageObj->getVar($i);
            }
            $ret[] = $msg;
            unset($msg);
        }
        return $ret;
    }

    /**
     * From xoopstableobject class
     *
     * @param object $criteria
     *
     * @return    int
     */
    public function getCount($criteria = null)
    {
        $sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('achat_messages');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $sql .= ' ' . $criteria->renderWhere();
        }
        $result = $this->db->query($sql);
        if (!$result) {
            return 0;
        }
        [$count] = $this->db->fetchRow($result);
        return $count;
    }

    /**
     * DB update procedure
     * @return bool
     */
    public function processPostRequest()
    {
        $message = isset($_POST['achat_input']) ? Utility::decodeUrlUtf8Raw($_POST['achat_input']) : '';
        // Si le message est vide, on arrete.
        if ('' == $message) {
            return false;
        }
        $myts = \MyTextSanitizer::getInstance();
        // Gestion du message
        $message = $myts->addSlashes($message);
        $message = $myts->htmlSpecialChars($myts->stripSlashesGPC($message));
        $message = $myts->censorString($message);
        // Gestion anti répétition
        $lastmsgobj = $this->getLastPost();
        $lastmsg    = $lastmsgobj->getVar('msg');
        if (($lastmsg == $message) && ($lastmsgobj->getVar('date') > (time() - 300))) {
            return false;
        }
        // Gestion de l'uid
        $uid = is_object($GLOBALS['xoopsUser']) ? $GLOBALS['xoopsUser']->getVar('uid') : 0;
        // Gestion du pseudo
        $uname = '';
        if (0 == $uid && isset($_POST['achat_uname'])) {
            $uname = $myts->htmlSpecialChars($myts->stripSlashesGPC(mb_substr(Utility::decodeUrlUtf8Raw($_POST['achat_uname']), 0, 15)));
        }
        // Gestion de la couleur
        $color = $_POST['color'] ?? '000000';
        // Gestion de l'ip du posteur
        $ip = Utility::getIp();
        // Objet message
        $messageObj = $this->create();
        $messageObj->setVar('uid', $uid);
        $messageObj->setVar('uname', $uname);
        $messageObj->setVar('msg', $message);
        $messageObj->setVar('color', $color);
        $messageObj->setVar('date', time());
        $messageObj->setVar('ip', $ip);
        $messageObj->cleanVars();
        return $this->insert($messageObj);
    }

    /**
     * get message-array
     * @param mixed $op
     * @param mixed $n
     * @return array $messages(array('mid'=>,'uname'=>,'message'=>,'color'=>))
     */
    public function &getMessages($op, $n)
    {
        global $xoopsUser;
        $myts = \MyTextSanitizer::getInstance();
        // Configuration de l'affichage des messages
        $html    = 0;
        $smiley  = Utility::getModuleOptions('use_smilies');
        $bbcodes = Utility::getModuleOptions('use_bbcodes');
        if ('from' == $op) {
            $result = $this->db->query('SELECT * FROM ' . $this->db->prefix('achat_messages') . ' WHERE mid > ' . $n . ' ORDER BY mid DESC');
        } else {
            $result = $this->db->query('SELECT * FROM ' . $this->db->prefix('achat_messages') . ' ORDER BY mid DESC', $n);
        }
        $sortie = [];
        // Boucle de traitement des variables pour l'affichage.
        while (false !== ($myrow = $this->db->fetchArray($result))) {
            $myrow['uname'] = empty($myrow['uname']) ? \XoopsUser::getUnameFromId($myrow['uid']) : $myrow['uname'];
            $myrow['msg']   = $myts->displayTarea($myrow['msg'], $html, $smiley, $bbcodes);
            $myrow['date']  = formatTimestamp($myrow['date']);
            $sortie[]       = $myrow;
        }
        $ret = array_reverse($sortie);
        return $ret;
    }

    /**
     * Récupère le dernier message posté par le visiteur
     *
     * @param int        $uid , string $ip
     * @param null|mixed $ip
     *
     * @return    aChatMessage object
     */
    public function getLastPost($uid = -1, $ip = null)
    {
        global $xoopsUser;
        if (-1 == $uid) {
            $uid = is_object($xoopsUser) ? $xoopsUser->getVar('uid') : 0;
            $ip  = Utility::getIp();
        }
        $messageObj  = $this->create();
        $moresql = (0 == $uid) ? " AND ip = '" . $ip . "' AND date > " . (time() - 86400) : '';
        $sql     = 'SELECT * FROM ' . $this->db->prefix('achat_messages') . ' WHERE uid = ' . $uid . $moresql . ' ORDER BY mid DESC LIMIT 1';
        $result  = $this->db->query($sql);
        $myrow   = $this->db->fetchArray($result);
        if (!$myrow) {
            return $messageObj;
        }
        $messageObj->assignVars($myrow);
        return $messageObj;
    }

    // Fonctions administration :
    // Pas utilisées...
    /**
     * Del some {@link Message}s
     *
     * @param object $criteria  {@link CriteriaElement}
     * @param bool   $id_as_key Use the IDs as array-keys?
     *
     * @return    bool
     */
    public function DelObjects($criteria = null, $id_as_key = false)
    {
        $limit = $start = 0;
        $sql   = 'DELETE FROM ' . $this->db->prefix('achat_messages');
        if (isset($criteria) && $criteria instanceof \CriteriaElement) {
            $order = $criteria->getOrder();
            $order = empty($order) ? 'DESC' : $order;
            $sql   .= ' ' . $criteria->renderWhere() . ' ORDER BY mid ' . $order;
            $limit = $criteria->getLimit();
            $start = $criteria->getStart();
        }
        return $this->db->query($sql, $limit, $start);
    }
}
