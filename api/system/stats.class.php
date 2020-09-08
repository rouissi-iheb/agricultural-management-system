<?php
require_once("database.class.php");
class Stats extends Database
{
  function __construct(){
    parent::__construct();
  }
  function TotalClients(){
    $res = $this->pdo->prepare("select count(*) from client");
    $res->execute(array());
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["count(*)"];
  }

  function TotalFornisseurs(){
    $res = $this->pdo->prepare("select count(*) from fornisseur");
    $res->execute(array());
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["count(*)"];
  }

  function OrdreDeJour(){
    $date = "20".date("y-m-d");
    $res = $this->pdo->prepare("select count(*) from journal where date = ?");
    $res->execute(array($date));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["count(*)"];
  }

  function TotaleStock(){
    $res = $this->pdo->prepare("select sum(qte) from produit");
    $res->execute(array());
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["sum(qte)"];
  }


}
?>
