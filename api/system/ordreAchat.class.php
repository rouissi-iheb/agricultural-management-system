<?php
require_once("database.class.php");
class OrderAchat extends Database
{
  function __construct(){
    parent::__construct();
  }
  //fonction ajout fornisseur qui ajout un fornisseur a la base puis retourne la valeur de son id 
  function add($nom,$detailles,$adresse,$telephone){
    $req = "insert into fornisseur(nom,detailles,adresse,telephone) values(?,?,?,?)";
    $res = $this->pdo->prepare($req);
    $res->execute(array($nom,$detailles,$adresse,$telephone));
    $req = "select max(id) from fornisseur";
    $res = $this->pdo->prepare($req);
    $res->execute();
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["max(id)"];
  }
  //fonction recherche fornisseur qui retourne un tableau des informations de client selon son nom
  function rechercher($nom){
    $res = $this->pdo->prepare("select * from fornisseur where nom like '%".$nom."%' or telephone like '%".$nom."%'");
    $res->execute(array());
    return $res->fetchAll(PDO::FETCH_ASSOC);
  }
  //fonction utilise l'id du fornisseur pour retourner tous ses informations 
  function showData($id){
    $res = $this->pdo->prepare("select * from fornisseur where id= ?");
    $res->execute(array($id));
    return $res->fetchAll(PDO::FETCH_ASSOC);
  }
  // fonction returne une liste de tous les fornisseurs 
  function liste(){
    $res = $this->pdo->prepare("select * from client");
    $res->execute(array());
    return $res->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>
