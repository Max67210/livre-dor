<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <title>livre d'or</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="feuilleStyle.css" />
  </head>
<body>


<?php

/**
 * Programme principal
 * Construit la page à partir de tous les fichiers
 */
require(dirname(__FILE__).'/guestbook-config.inc.php');
require(dirname(__FILE__).'/guestbook-model.inc.php');
require(dirname(__FILE__).'/guestbook-controller.inc.php');
//require(dirname(__FILE__).'/guestbook-view.inc.php');
// guestbook-view.inc.php est remplacé par guestbook-afficher-message et guestbook-message
?> 
    <h1>livre d'or</h1>
<div id="menu">

    <?php
        
    echo '<div id="menu">';
    echo "<a target='_self' href='?action=message'>Saisir Message</a><br>";
    echo "<a target='_self' href='?action=afficher'>Afficher Message</a>";
    echo '</div>';
    
    echo '<div id="contenu">';
    if(isset($_GET['action']))
    {
        switch($_GET['action'])
        {
            case 'message':
            {
                include('guestbook-message.inc.php');
                break;
            }
            case 'afficher':
            {
                include('guestbook-afficher-message.inc.php');
                break;
            }    
        }
        echo '</div>';
    }
    else
    {
        include('guestbook-description.inc.php');
    }
    ?>
</div>
</body>
</html>