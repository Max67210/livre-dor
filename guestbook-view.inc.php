<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
  <head>
    <title>livre d'or</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
  </head>
  <body>
    <h1>livre d'or</h1>
 
      <h2>Poster un message</h2>
 
      <?php /** Affichage des erreurs générées **/ ?>
      <?php if (sizeof($aListeErreurs) > 0) : ?>
        <ul>
          <?php foreach ($aListeErreurs as $sErreur) : ?>
          <li><?php echo htmlspecialchars($sErreur); ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
 
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES); ?>" method="post">
        <div>
          <label for="pseudo">Pseudo :</label> 
          <input type="text" name="pseudo" id="pseudo" value="<?php if(!empty($_POST['pseudo'])) : echo htmlspecialchars($_POST['pseudo'], ENT_QUOTES); endif; ?>" />
        </div>
        <div>
          <label for="message">Message :</label> 
          <textarea name="message" id="message" rows="10" cols="45"><?php if (!empty($_POST['message'])) : echo htmlspecialchars($_POST['message']); endif; ?></textarea>
        </div>
        <div>
          <label for="note">Note :</label> 
          <select name="note" id="note">
            <?php for ($i=1; $i<11; $i++) : ?>
            <option value="<?php echo $i; ?>"<?php if (!empty($_POST['note']) && ($_POST['note'] == $i)) : echo ' selected="selected"'; endif; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
          </select>
        </div>
        <div>
          <input type="submit" name="envoyer" value="Soumettre" />
        </div>
      </form>
 
      <h2>Liste des messages</h2>
 
      <?php /** Affichage des messages **/ ?>
      <?php if ($iNombreDeMessages > 0) : ?>
 
        <ul>
          <li><?php echo $iNombreDeMessages; ?> message<?php if ($iNombreDeMessages > 1) : ?>s<?php endif; ?></li>
          <li>Note moyenne : <?php echo $fNoteMoyenne; ?> / 10
        </ul>
 
        <?php foreach ($aListeMessages as $oMessage) : ?>
          <div>
            <p>
              Par <?php echo htmlspecialchars($oMessage->pseudo); ?>, le <?php echo convertirDate($oMessage->creation); ?>
            </p>
            <blockquote>
              <p>
                <?php echo nl2br(htmlspecialchars($oMessage->message)); ?>
              </p>
            </blockquote>
          </div>
          <hr/>
        <?php endforeach; ?>
 
        <?php /** Affichage de la pagination si nécessaire **/ ?>
        <?php if ($iNombreDeMessages > MAX_MESSAGES_PAR_PAGE) : ?>
        <div class="pagination">
          <?php echo paginer($iNombreDeMessages, MAX_MESSAGES_PAR_PAGE, $iNumeroDePageCourante, 4, 4, 1, 1); ?>
        </div>
        <?php endif; ?>
      <?php else : ?>
      <p>
        Aucun message enregistré
      </p>
      <?php endif; ?>
  </body>
</html>