<?php
// Connexion à la base de données (assurez-vous que db_connect.php définit $conn)
include_once __DIR__ . '/db.php';


/**
 * Enregistrer un apport.
 */
function enregistrerApport($associe, $type, $valeur) {
    global $conn;
    $date = date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO apports (associe, type_apport, valeur, date_apport) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $associe, $type, $valeur, $date);
    $stmt->execute();
    $stmt->close();
}


/**
 * Enregistrer un frais de constitution.
 */
function enregistrerFrais($associe, $montant) {
    global $conn;
    $date = date('Y-m-d');
    $stmt = $conn->prepare("INSERT INTO frais_constitution (associe, montant, date_frais) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $associe, $montant, $date);
    $stmt->execute();
    $stmt->close();
}

/**
 * Calculer le capital total (la somme de tous les apports).
 */
function calculerCapitalTotal() {
    global $conn;
    $result = $conn->query("SELECT SUM(valeur) AS capital_total FROM apports");
    $row = $result->fetch_assoc();
    return $row['capital_total'] ? $row['capital_total'] : 0;
}

/**
 * Générer les écritures comptables correspondantes.
 * Pour chaque apport, on crée une écriture type :
 *   Débit: [Nom du compte d'apport selon le type] / Crédit: Capital social
 * Pour les frais, on crée une écriture :
 *   Débit: Charges de constitution / Crédit: [Nom de l'associé]
 */
function genererEcritures() {
    global $conn;
    $ecritures = [];

    // Récupérer les apports
    $result = $conn->query("SELECT * FROM apports");
    while ($row = $result->fetch_assoc()) {
        // Déterminer le compte d'apport selon le type (vous pouvez enrichir cette logique)
        switch ($row['type_apport']) {
            case 'nature':
                $compte = 'Apports en nature';
                break;
            case 'numeraire':
                $compte = 'Apports en numeraire';
                break;
            //case 'matériel':
              //  $compte = 'Apports en matériel';
                //break;
            //case 'mobilier':
             //   $compte = 'Apports en mobilier';
               // break;
           // case 'espèces':
            //default:
              //  $compte = 'Apports en espèces';
               // break;
        }
        $ecritures[] = "Écriture: Débit: $compte - Crédit: Capital social - Montant: " . $row['valeur'] . " USD";
    }
    // Récupérer les frais de constitution
    $result = $conn->query("SELECT * FROM frais_constitution");
    while ($row = $result->fetch_assoc()) {
        $ecritures[] = "Écriture: Débit: Charges de constitution - Crédit: " . $row['associe'] . " - Montant: " . $row['montant'] . " USD";
    }
    
    return $ecritures;
}
?>