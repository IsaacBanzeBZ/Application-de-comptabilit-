<?php
// reports_functions.php
include_once 'db_connect.php';

/**
 * Retourne toutes les écritures, classées par date, pour le Journal.
 */
function getJournal() {
    global $conn;
    $sql = "SELECT e.*, a.code AS account_code, a.name AS account_name
            FROM entries e
            JOIN accounts a ON e.account_id = a.id
            ORDER BY e.date ASC, e.id ASC";
    $result = $conn->query($sql);
    $entries = [];
    while ($row = $result->fetch_assoc()) {
        $entries[] = $row;
    }
    return $entries;
}

/**
 * Retourne un tableau pour le Grand Livre (agrégé par compte).
 */
function getGrandLivre() {
    global $conn;
    // On récupère d'abord tous les comptes
    $sqlAccounts = "SELECT * FROM accounts ORDER BY code ASC";
    $resAccounts = $conn->query($sqlAccounts);
    $grandLivre = [];
    while ($acc = $resAccounts->fetch_assoc()) {
        $accountId = $acc['id'];
        // On récupère toutes les écritures de ce compte
        $sqlEntries = "SELECT * FROM entries WHERE account_id = $accountId ORDER BY date ASC";
        $resEntries = $conn->query($sqlEntries);
        $entries = [];
        $totalDebit = 0;
        $totalCredit = 0;
        while ($row = $resEntries->fetch_assoc()) {
            $entries[] = $row;
            $totalDebit += $row['debit'];
            $totalCredit += $row['credit'];
        }
        $grandLivre[] = [
            'account' => $acc,
            'entries' => $entries,
            'total_debit' => $totalDebit,
            'total_credit' => $totalCredit,
            'solde' => $totalDebit - $totalCredit
        ];
    }
    return $grandLivre;
}

/**
 * Retourne un tableau pour la Balance (ou Bilan simplifié).
 * On regroupe par type de compte (Actif, Passif, Charge, Produit).
 */
function getBilan() {
    global $conn;
    // Récupération de la balance agrégée par compte
    $sql = "SELECT a.code, a.name, a.type,
                   SUM(e.debit) as total_debit, 
                   SUM(e.credit) as total_credit
            FROM accounts a
            LEFT JOIN entries e ON a.id = e.account_id
            GROUP BY a.id
            ORDER BY a.code ASC";
    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $row['solde'] = $row['total_debit'] - $row['total_credit'];
        $data[] = $row;
    }
    return $data;
}
