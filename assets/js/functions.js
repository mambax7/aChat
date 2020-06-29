// + --------------------------------------------------------------------------------------
// +  JavaScript functions for achat
// +  v0.23  17.08.2007  17:39:13
// +  By Niluge_KiWi
// +  kiwiiii@gmail.com
// +  With XHRConnection v1.3
// + --------------------------------------------------------------------------------------


// + --------------------------------------------------------------------------------------
// + fifo pile class
// + on the xajax module
// + --------------------------------------------------------------------------------------
function achat_pile(size) {

    // + -------------------------------------------------------------------------------
    // + Stack variables
    // + -------------------------------------------------------------------------------
    var start = 0;
    var end = 0;
    var commands = [];
    var processing = false;

    // + -------------------------------------------------------------------------------
    // + Add an item to the stack
    // + -------------------------------------------------------------------------------
    this.push = function (obj) {
        var next = end + 1;
        if (next > size)
            next = 0;
        if (next != start) {
            commands[end] = obj;
            end = next;
            return true;
        } else { // stack overflow
            return false;
        }
    }

    // + -------------------------------------------------------------------------------
    // + Collect the 1st element of the stack
    // + -------------------------------------------------------------------------------
    this.pop = function () {
        var next = start;
        if (next == end)
            return null;
        next++;
        if (next > size)
            next = 0;
        var obj = commands[start];
        commands[start] = null;
        start = next;
        return obj;
    }
    // + -------------------------------------------------------------------------------
    // + Unstacks the stack to make requests
    // + -------------------------------------------------------------------------------
    this.process = function () {
        if (processing) {
            // vide for now: a loop is already launched
        } else {
            processing = true;
            var elt = this.pop();
            if (elt == null) {
                // the window is empty
                processing = false;
                return;
            } else {
                var XHR = elt[0];
                var fonction_fin = elt[1];

                XHR.appendData('achat_lastmid', getLastId());
                // We update the date of the last refresh
                achat_lrt = new Date();

                // And we send everything!
                XHR.sendAndLoad(achat_url + '/index.php', 'POST', fonction_fin);
                return;
            }
        }
    }
    // + -------------------------------------------------------------------------------
    // + Change state: running or not
    // + -------------------------------------------------------------------------------
    this.setProcessingFalse = function () {
        processing = false;
        return true;
    }
    // + -------------------------------------------------------------------------------
    // + Returns the number of elements in the stack (probably useless)
    // + -------------------------------------------------------------------------------
    this.count = function () {
        if (end > start)
            return end - start;
        else
            return size - start + end + 1;
    }

}


// + --------------------------------------------------------------------------------------
// + Initialization of scripts and variables
// + --------------------------------------------------------------------------------------
window.onload = initAchat;
// Time initialization: vente_last_refresh_time
var achat_lrt = new Date();
// Initialization of the variable vente_last_mid
var lastId = 0;
// Initialization of the ajax request stack: the size limits the flood, but if too small with a weak internet connection, this can cause problems
var laPile_achat = new achat_pile(2);
// Initialisation ping
var achat_ping = 0;


function initAchat() {
    var objForm = xoopsGetElementById('achatform');

    // Management of the sending form if it does not exist (if the visitor does not have the right to post
    try {
    // Delete the
    // below to activate the autofocus
    // objForm.achat_input.focus ();
    } catch (error) {
    }

    scrollDown();

    getLastId(true);
    var objMessages = xoopsGetElementById('achat_messages');
    // We truncate too long url
    truncateUrl(objMessages);
    /* Truncation of words too long deactivated for the moment because problem with the html code of smilies for example
    // If block: words are too long
    if(block) {
        for (var i=0;i<objMessages.childNodes.length;i++) {
            if (objMessages.childNodes[i].nodeName == 'DIV') {
                achat_Gestion_Longs_mots(objMessages.childNodes[i].childNodes[3]);
            }
        }
    }*/
    // On lance auto refresh
    achat_loop_refresh();
}

function achat_loop_pile_process(responseText) {
    // function which displays the result of the ajax request, then relaunches the execution of the stack

    // Displays the ping at refresh (includes the loading time of xoops ...)
    ping = new Date().getTime() - achat_lrt.getTime();
    if (responseText != null) {
        xoopsGetElementById('achat_messages').innerHTML += responseText;
        scrollDown();
    }
    // We update the last mid
    getLastId(true);

    // We restart the process
    laPile_achat.setProcessingFalse();
    laPile_achat.process();
}

function achat_loop_refresh(conn) {
    if (conn != null)
        achat_loop_pile_process(conn.responseText);
    else
        achat_loop_pile_process();
    setTimeout('refreshChat()', achat_tmp_refresh * 1000);
}

function sendMessage() {

    var objForm = xoopsGetElementById('achatform');

    var XHR = new XHRConnection();

    // If the browser does not support AJAX, we post the post normally
    if (!XHR) {
        objForm.submit();
    } else {

        // Managing form variables
        // Retrieved from xajax version 0.2.4, distributed under GNU
        var formElements = objForm.elements;
        for (var i = 0; i < formElements.length; i++) {
            if (!formElements[i].name)
                continue;
            if (formElements[i].type && (formElements[i].type == 'radio' || formElements[i].type == 'checkbox') && formElements[i].checked == false)
                continue;
            var name = formElements[i].name;
            if (name) {
                if (formElements[i].type == 'select-multiple') {
                    var selectedarray = new Array();
                    for (var j = 0; j < formElements[i].length; j++) {
                        if (formElements[i].options[j].selected == true)
                            selectedarray.push(eformElements[i].options[j].value);
                    }
                    XHR.appendData(name, selectedarray);
                } else XHR.appendData(name, formElements[i].value);
            }
        }

        // End of form management

        // We empty the field purchase_input
        objForm.achat_input.value = '';

        //XHR.setRefreshArea('achat_messages');
        XHR.appendData('achat_ajax_submit', 1);

        // We add to the sending stack
        if (!laPile_achat.push([XHR, chargefini_send])) {
            // the battery is full: flood or bad connection
            //alert("full pile");
        }
        // and we launch the execution of the stack (if it is not already done)
        laPile_achat.process();
    }
}

function refreshChat() {
    var XHR = new XHRConnection();
    // If the browser does not support AJAX, we do not refresh ... (it's not great but good)
    if (!XHR) {
    } else if (achat_lrt.getTime() < (new Date().getTime() - achat_tmp_refresh * 1000)) {
        //XHR.setRefreshArea('achat_messages');
        XHR.appendData('achat_ajax_refresh', 1);

        // We add to the sending stack
        if (!laPile_achat.push([XHR, achat_loop_refresh])) {
            // the battery is full: flood or bad connection
            //alert("full pile");
            achat_loop_refresh();
        }
        // and we launch the execution of the stack (if it is not already done)
        laPile_achat.process();

    } else {
        setTimeout('refreshChat()', achat_lrt.getTime() + achat_tmp_refresh * 1000 - (new Date().getTime()));
    }
}

function isMsgDiv(obj) {
    var est_une_div = (obj.nodeName == "DIV");
    var bon = false;
    var type_fct = typeof obj.getAttribute;
    if (type_fct == "object") {
        // Below IE7
        bon = obj.getAttribute('id').substr(0, 7) == "achat_p";
    } else if (type_fct == "function") {
        // Below Opera/Firefox
        bon = obj.getAttribute('class') == "achat_dp";
    }
    return est_une_div && bon;
}

function getLastId(update) {
    if (lastId == 0 || update) {
        var objMessages = xoopsGetElementById('achat_messages');

        if (!isNotEmpty(objMessages)) {
            return lastId;
        }

        var lastid = -1;
        var i = objMessages.childNodes.length;
        while (i > 0 && lastid < 0) {
            i--;
            if (isMsgDiv(objMessages.childNodes[i])) {
                lastid = i;
            }
        }
        if (lastid != -1)
            lastId = objMessages.childNodes[lastid].getAttribute('id').substr(7);
    }
    return lastId;
}

function isNotEmpty(obj) {
    var i = 0;
    var stop = false;
    while (i < obj.childNodes.length && !stop) {
        if (isMsgDiv(obj.childNodes[i])) {
            stop = true;
        }
        i++;
    }
    return stop;
}

function checkInput() {
    // Function that checks that the message sent is not empty.
    // If empty: nothing
    // If not empty: we send
    var objForm = xoopsGetElementById('achatform');
    var msg = objForm.achat_input.value;

    // IRC-Like order management
    if (msg.substr(0, 1) == '/') {
        switch (msg) {
            case "/clear":
                xoopsGetElementById('achat_messages').innerHTML = '';
                objForm.achat_input.value = '';
                return;
            case "/ping":
                xoopsGetElementById('achat_messages').innerHTML += '<div class="achat_div_ping">++ ping: ' + ping + 'ms ++</div>';
                scrollDown();
                objForm.achat_input.value = '';
                return;
            default :
                ;
        }

    }
    if (msg != '' && msg != ' ') {
        sendMessage();
    }
}

function chargefini_send(conn) {

    // We put the focus back on the input
    xoopsGetElementById('achatform').achat_input.focus();

    // We restart the process
    achat_loop_pile_process(conn.responseText);
}

function changeDisplay(id) {
    var elestyle = xoopsGetElementById(id).style;
    if (elestyle.display == "" || elestyle.display == "block") {
        elestyle.display = "none";
    } else {
        elestyle.display = "block";
    }
}

function scrollDown() {
    var obj = xoopsGetElementById('achat_messages');
    obj.scrollTop = obj.scrollHeight - obj.offsetHeight + 20;
}

function truncateUrl(ObjMsg) {

    var resultat = ObjMsg.innerHTML.replace(/<a href="(.*?)" target="_blank">(.*?)<\/a>/g,
        function (str, url, url_title, offset, s) {
            if (url_title.length > 19) {
                url_title = url_title.substr(0, 17) + '...';
            }
            return '<a href="' + url + '" target="_blank">' + url_title + '</a>';
        });

    ObjMsg.innerHTML = resultat;

}

function achat_Gestion_Longs_mots(ObjMsg) {

    var resultat = ObjMsg.innerHTML.replace(/(\S{20,256})/g,
        function (str, mot, offset, s) {
            return '<span title="' + mot + '">' + mot.substr(0, 17) + '...' + '</span>';
            //return  mot.substr(0, 17) + '...' ;
        });

    ObjMsg.innerHTML = resultat;

}

function submitEnter(e) {

    var keycode;
    if (window.event) keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    else return true;

    if (keycode == 13) {
        checkInput();
        return false;
    } else
        return true;
}
