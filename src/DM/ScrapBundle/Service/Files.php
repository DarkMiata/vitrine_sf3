<?php

namespace DM\ScrapBundle\Service;

class Files
{


// ========================================
  public function test() {

    return "test de text - service ScrapBundle - class Files";
  }
  // ------------------------
  /**
   * Fonction qui permet de charger une page HTML.
   * Si la page n'existe pas en local, elle est récupéré via internet et sauvegardé en local pour être réutilisé par la suite
   * @param type $url
   * @param type $directory
   * @return type
   */
  function loadAndSaveHTML ($url, $directory, $return) {
    $fileName = explode("/", $url);
    $fileName = end($fileName);

    $fileExtension = explode(".", $fileName)[1];

    if ($fileExtension != "html") {
      throw new Exception("Le type de fichier attendu doit être en HTML - fichier: ".$fileName);
    }

    $localFile = $directory . $fileName;

    //debug($localFile . "<br>");

    // Si le fichier existe en local, le charger.
    // Sinon le charger de l'url et le sauvegarder en local.
    if (file_exists($localFile) == FALSE) {
      $html = file_get_html($url);
      file_put_contents($localFile, $html);
    } else {
      if ($return == TRUE) {
        $html = file_get_html($localFile);
      }
    }

    // si $return est à TRUE, retourner l'html, sinon retourner NULL
    if ($return == FALSE) {
      $html = NULL;
    }

    return $html;
  }
// ========================================
// ========================================

// ========================================
}


