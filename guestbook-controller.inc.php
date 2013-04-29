<?php
 
/**
 * Contrôleur de l'application
 *
 * Ce fichier traite le formulaire
 * Enregistre les informations en base de données
 * Affiche une liste paginée de résultats
 **/
 
/** ----
 * Déclaration des variables globales
 **/
// Objets de connexion et de manipulatin de la BDD

$oPDO = null;
$oPDOStatement = null;

// Tableau stockant les informations du livre d'or
$aInfosGuestbook = array();
 
// Tableau stockant les messages récupérés de la BDD
$aListeMessages = array();
 
// Tableau stockant les erreurs générées
$aListeErreurs = array();
 
// Nombre de messages enregistrés dans la BDD
$iNombreDeMessages = 0;
 
// Numéro de la page courante
$iNumeroDePageCourante = 1;
 
// Offset à partir duquel on récupère les messages dans la BDD
$iOffsetSelection = 0;
 
// Note moyenne du site
$fNoteMoyenne = 0;
 
/** ----
 * Contrôle de la pagination
 */
if(!empty($_GET['numeroPage']) 
  && is_numeric($_GET['numeroPage'])  
  && ($_GET['numeroPage']>1))
{
  $iNumeroDePageCourante = intval($_GET['numeroPage']);  
  $iOffsetSelection = ($iNumeroDePageCourante - 1) * MAX_MESSAGES_PAR_PAGE;
}
 
/** ----
 * Initialisation de la connexion avec la base de données
 **/
$oPDO = PDOConnect(DB_DSN, DB_LOGIN, DB_PASSWORD);

/** ---- 
 * Contrôle du formulaire
 */
if (!empty($_POST))
{
  // Nettoyage des chaines envoyées
  $_POST['pseudo']  = isset($_POST['pseudo'])  ? trim($_POST['pseudo'])  : '';
  $_POST['message'] = isset($_POST['message']) ? trim($_POST['message']) : '';
  $_POST['note']    = isset($_POST['note'])    ? intval($_POST['note'])  : 5;
  
  // Le pseudo est-il rempli ?
  if (empty($_POST['pseudo']))
  {
    $aListeErreurs[] = 'Veuillez indiquer votre pseudo';
  }
  else
  {
    // Le pseudo est-il compris entre 2 et 20 caractères ?
    if (strlen($_POST['pseudo']) < 2)
    {
      $aListeErreurs[] = 'Votre pseudo est trop court';
    }
    
    if (strlen($_POST['pseudo']) > 20)
    {
      $aListeErreurs[] = 'Votre peudo est trop long';
    }
  }
 
  // Le message est-il rempli ?
  if (empty($_POST['message']))
  {
    $aListeErreurs[] = 'Veuillez indiquer votre message';
  }
  
  // La note est-elle correcte ?
  if (($_POST['note'] < 1) || ($_POST['note']>10))
  {
    $aListeErreurs[] = 'Veuillez choisir une note';
  }
 
  // Si aucune erreur n'a été générée
  // On enregistre le message dans la BDD
  if (0 === sizeof($aListeErreurs))
  {
    try
    {
      // Création d'une requête préparée
      $oPDOStatement = $oPDO->prepare(
          'INSERT INTO '. DB_GUESTBOOK_TABLE .' (pseudo, message, note, creation) VALUES(:pseudo, :message, :note, NOW())'
      );
      
      // Ajout de chaque paramètre à la requête
      // Les paramètres sont automatiquement protégés par l'objet PDO
      $oPDOStatement->bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
      $oPDOStatement->bindParam(':message', $_POST['message'], PDO::PARAM_STR);
      $oPDOStatement->bindParam(':note', $_POST['note'], PDO::PARAM_INT);
 
      // Execution de la requête préparée
      $oPDOStatement->execute();
      
      // Redirection vers la même page pour vider le cache des données envoyées
      header('Location: '. URL_GUESTBOOK);
      exit;
    }
    catch (PDOException $oPdoException)
    {
      $aListeErreurs[] = 'Une erreur est survenue et a empêché l\'enregistrement de votre message';
    }
  }
}
 
/** ---- 
 * Comptage du nombre de messages en base de données et calcule de la note moyenne
 **/
$oPDOStatement = $oPDO->query('SELECT COUNT(1) AS nombreMessages, SUM(note) AS noteTotale FROM '. DB_GUESTBOOK_TABLE);
$oPDOStatement->setFetchMode(PDO::FETCH_ASSOC);
$aInfosGuestbook = $oPDOStatement->fetch();

$iNombreDeMessages = intval($aInfosGuestbook['nombreMessages']);
 
// Calcul de la note moyenne
if ($iNombreDeMessages > 0)
{
  $fNoteMoyenne = round(intval($aInfosGuestbook['noteTotale']) / $iNombreDeMessages, 2);
}
 
$oPDOStatement = null;
 
/** ---- 
 * Récupération des messages en fonction de la pagination
 **/
if (sizeof($iNombreDeMessages)>0)
{
  $oPDOStatement = $oPDO->prepare(
    'SELECT pseudo, message, creation FROM '. DB_GUESTBOOK_TABLE .' ORDER BY creation DESC LIMIT :offset, '. MAX_MESSAGES_PAR_PAGE
  );
  
  $oPDOStatement->bindParam(':offset', $iOffsetSelection, PDO::PARAM_INT);
  $oPDOStatement->execute();
 
  // Récupération des résultats sélectionnés dans le tableau $aListeMessages
  $aListeMessages = $oPDOStatement->fetchAll(PDO::FETCH_OBJ);
}
 
// Fermeture de la connexion SQL
$oPDOStatement = null;
$oPDO = null;

?>