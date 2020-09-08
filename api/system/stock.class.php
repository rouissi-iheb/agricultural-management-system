<?php
require_once("database.class.php");
class Stock extends Database
{
  function __construct(){
    parent::__construct();
  }

  //fonction ajout client qui ajout un client ala base puis retourne la valeur de son id 
  function add($idp,$idf,$qte,$prixachat,$prixvente ,$prixtotale,$montantpayee){
    // ajouter les detailles de l'achat a la  base
    $res = $this->pdo->prepare("insert into order_achat(idp,idf,qte,date,prixachat,prixtotale,ddpayment,montantpayee) values(?,?,?,?,?,?,?,?)");
    $res->execute(array($idp,$idf,$qte,"20".date("y-m-d"),$prixachat,$prixtotale,"20".date("y-m-d"),$montantpayee));
    //determiner la quantite ajouter a la case qte dans la table produit
    $res = $this->pdo->prepare("select qte from produit where id = ? ");
    $res->execute(array($idp));
    $oldQte = $res->fetchAll(PDO::FETCH_ASSOC)["0"]["qte"];
    //mettre a jours la nouvelle quantite apres lajout au stock
    $res = $this->pdo->prepare("update produit set qte = ? ,prix_vente=? where id = ? ");
    $qteF =$oldQte+$qte;
    $res->execute(array($qteF,$prixvente ,$idp));
  }

  //fonction recherche client qui retourne un tableau des informations de client selon son nom
  function rechercher($nom){
    $res = $this->pdo->prepare("select * from client where nom like '%".$nom."%' or telephone like '%".$nom."%'");
    $res->execute(array());
    return $res->fetchAll(PDO::FETCH_ASSOC);
  }
  //fonction utilise l'id du client pour retourner tous ses informations 
  function showData($id){
    $res = $this->pdo->prepare("select * from client where id= ?");
    $res->execute(array($id));
    return $res->fetchAll(PDO::FETCH_ASSOC);
  }

  // fonction returne une liste de tous les clients 
  function liste(){
    $res = $this->pdo->prepare("select * from client");
    $res->execute(array());
    return $res->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>
