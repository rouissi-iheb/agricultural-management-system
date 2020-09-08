<?php
require_once("database.class.php");
class Produit extends Database
{
  function __construct(){
    parent::__construct();
  }

  //fonction ajout produit qui ajout un client ala base puis retourne la valeur de son id 
  function add($idf,$label,$prix){
    $req = "insert into produit(idf,label,prix_vente) values(?,?,?)";
    $res = $this->pdo->prepare($req);
    $res->execute(array($idf,$label,$prix));
    $req = "select max(id) from produit";
    $res = $this->pdo->prepare($req);
    $res->execute();
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["max(id)"];
  }


  function getProductsSelectList(){
    $res = $this->pdo->prepare("select * from produit");
    $res->execute(array());
    $res = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach($res as $produit){
      echo '<option value="'.$produit['id'].'">'.$produit['label'].' - '.$this->getNameFornisseur($produit["idf"]).'</option>';
    }
  }

  function getProductsSelectListID(){
    $res = $this->pdo->prepare("select * from produit");
    $res->execute(array());
    $res = $res->fetchAll(PDO::FETCH_ASSOC);
    $arr = array();
    $i=0;
    foreach($res as $produit){
      $arr[$i]["id"]= $produit['id'];
      $arr[$i]["prix_vente"]= $produit['prix_vente'];
      $arr[$i]["qtemax"]= $produit['qte'];
      $i++;
    }
    return $arr;
  }
 

  //fonction utilise l'id du client pour retourner tous ses informations 
  function showData($id){
    $res = $this->pdo->prepare("select * from produit where id= ?");
    $res->execute(array($id));
    return $res->fetchAll(PDO::FETCH_ASSOC);
  }

  // fonction returne une liste de tous les clients 
  function liste(){
    $res = $this->pdo->prepare("select * from produit");
    $res->execute(array());
    $arr = $res->fetchAll(PDO::FETCH_ASSOC);
    $result = array();
    $i = 0 ;
    foreach($arr as $row){
      $result[$i] = $row;
      $result[$i]["fornisseur"] =$this->getNameFornisseur($row['idf']);
      $i++;
    }
    return $result;
  }

  private function getNameFornisseur($idf){
    $res = $this->pdo->prepare("select nom from fornisseur where id= ?");
    $res->execute(array($idf));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["nom"];
  }

  function IDproduitToFornisseur($idp){
    $res = $this->pdo->prepare("select idf from produit where id= ?");
    $res->execute(array($idp));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["idf"];
  }
}
?>
