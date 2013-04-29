<?php
 
/**
 * Ce fichier contient toutes les fonctions
 * utiles à l'application
 **/
 
/**
 * Fonction de connexion sur la BDD
 *
 * Cette fonction utilise l'extension PDO
 * de PHP5
 *
 * @param string driver de connexion sur la BDD
 * @param string login d'accès à la bdd
 * @param string mot de passe d'accès à la base de données
 * @param string encodage des données issues de la BDD
 *
 * @return PDO objet de connexion sur la BDD
 **/
function PDOConnect($sDbDsn, $sDbLogin, $sDbPassword) 
{
  try
  {
    $oPDO = new PDO($sDbDsn, $sDbLogin, $sDbPassword);
  }
  catch (PDOException $e)
  {
    die('Une erreur interne est survenue');
  }
 
  $oPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
  return $oPDO;
}
 
/**
 * Convertit la date au format américain en format français
 *
 * @param string la date au format US
 * @return string la date au format FR
 **/
function convertirDate($sDateUs)
{
  return strftime('%d/%m/%Y à %H:%M', strtotime($sDateUs));
}
 
/**
 * Fonction de pagination des résultats
 *
 * Retourne le code HTML des liens de pagination
 *
 * @param integer nombre de résultats total
 * @param integer nombre de résultats par page
 * @param integer numéro de la page courante
 * @param integer nombre de pages avant la page courante
 * @param integer nombre de pages après la page courante
 * @param integer afficher le lien vers la première page (1=oui / 0=non)
 * @param integer afficher le lien vers la dernière page (1=oui / 0=non)
 * @return string code HTML des liens de pagination
 **/
function paginer($nb_results, $nb_results_p_page, $numero_page_courante, $nb_avant, $nb_apres, $premiere, $derniere)
{
  // Initialisation de la variable a retourner
  $resultat = '';
 
  // nombre total de pages
  $nb_pages = ceil($nb_results / $nb_results_p_page);
  // nombre de pages avant
  $avant = $numero_page_courante > ($nb_avant + 1) ? $nb_avant : $numero_page_courante - 1;
  // nombre de pages apres
  $apres = $numero_page_courante <= $nb_pages - $nb_apres ? $nb_apres : $nb_pages - $numero_page_courante;
 
  // premiere page
  if ($premiere && $numero_page_courante - $avant > 1)
  {
    $resultat .= '<a href="'. htmlspecialchars($_SERVER['PHP_SELF']) .'?numeroPage=1" title="Première page">&laquo;&laquo;</a>&nbsp;';
  }
 
  // page precedente
  if ($numero_page_courante > 1)
  {
    $resultat .= '<a href="'. htmlspecialchars($_SERVER['PHP_SELF']) .'?numeroPage='. ($numero_page_courante - 1) .'" title="Page précédente '. ($numero_page_courante - 1) . '">&laquo;</a>&nbsp;';
  }
 
  // affichage des numeros de page
  for ($i = $numero_page_courante - $avant; $i <= $numero_page_courante + $apres; $i++)
  {
    // page courante
    if ($i == $numero_page_courante)
    {
      $resultat .= '&nbsp;[<strong>' . $i . '</strong>]&nbsp;';
    }
    else
    {
      $resultat .= '&nbsp;[<a href="'. htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES) .'?numeroPage='. $i .'" title="Consulter la page '. $i . '">' . $i . '</a>]&nbsp;';
    }
  }
 
  // page suivante
  if($numero_page_courante < $nb_pages)
  {
    $resultat .= '<a href="'. htmlspecialchars($_SERVER['PHP_SELF']) .'?numeroPage='. ($numero_page_courante + 1) .'" title="Consulter la page '. ($numero_page_courante + 1) . ' !">&raquo;</a>&nbsp;';
  }
 
  // derniere page     
  if ($derniere && ($numero_page_courante + $apres) < $nb_pages)
  {
    $resultat .= '<a href="'. htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES) .'?numeroPage='. $nb_pages .'" title="Dernière page">&raquo;&raquo;</a>&nbsp;';
  }
 
  // On retourne le resultat
  return $resultat;
}
?>