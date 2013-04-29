
<h2>Liste des messages</h2>
 
      <?php /** Affichage des messages **/ ?>
      <?php if ($iNombreDeMessages > 0) : ?>
 
        <ul>
          <li><?php echo $iNombreDeMessages; ?> message<?php if ($iNombreDeMessages > 1) : ?>s<?php endif; ?></li>
          <li>Note moyenne : <?php echo $fNoteMoyenne; ?> / 10
        </ul>
 <table border = 2 width=100%>
                  <tr>
                      
                <th>Pseudo</th>
                <th>Date</th>
                <th>Message</th>
                  </tr>
        <?php foreach ($aListeMessages as $oMessage) : ?>
          
                  <tr>
            
                    <td><?php echo htmlspecialchars($oMessage->pseudo); ?></td>
                    <td><?php echo convertirDate($oMessage->creation); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($oMessage->message)); ?></td>
            </tr>
        <?php endforeach; ?>
 </table>
 
        <?php /** Affichage de la pagination si nécessaire **/ ?>
        <?php if ($iNombreDeMessages > MAX_MESSAGES_PAR_PAGE) : ?>
        <div >
          <?php echo paginer($iNombreDeMessages, MAX_MESSAGES_PAR_PAGE, $iNumeroDePageCourante, 4, 4, 1, 1); ?>
        </div>
        <?php endif; ?>
      <?php else : ?>
      <p>
        Aucun message enregistré
      </p>
      <?php endif; ?>