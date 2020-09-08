<?php
require_once("database.class.php");
class Fornisseur extends Database
{
  function __construct(){
    parent::__construct();
  }

  //fonction ajout fornisseur qui ajout un fornisseur a la base puis retourne la valeur de son id 
  function add($nom,$adresse,$telephone){
    $res = $this->pdo->prepare("insert into fornisseur(nom,adresse,telephone) values(?,?,?)");
    $res->execute(array($nom,$adresse,$telephone));
    $res = $this->pdo->prepare("select max(id) from fornisseur");
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
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"];
  }

  function getFornisseurSelectList(){
    $res = $this->pdo->prepare("select * from fornisseur");
    $res->execute(array());
    $res = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach($res as $produit){
      echo '<option value="'.$produit['id'].'">'.$produit['nom'].'</option>';
    }
  }

  // fonction returne une liste de tous les fornisseurs 
  function liste(){
    $res = $this->pdo->prepare("select * from fornisseur");
    $res->execute(array());
    $r = $res->fetchAll(PDO::FETCH_ASSOC);
    $arr = array();
    $i = 0;
    foreach($r as $row){
      $res = $this->pdo->prepare("select sum(prixtotale),sum(montantpayee) from order_achat where idf = ?");
      $res->execute(array($row["id"]));
      $resultOA = $res->fetchAll(PDO::FETCH_ASSOC)["0"];
      $reste = floatval($resultOA["sum(prixtotale)"]) - floatval($resultOA["sum(montantpayee)"]); 
      $row["action"] = '<a target="_blank" title="ajout payment" class="fa fa-credit-card btn btn-success" href="paymentFornisseur.php?id='.$row["id"] .'"></a>';
      $row["reste"] = $reste;
      $arr[$i] = $row;
      $i++;
    }
    return $arr;
  }
  
  function listePaymentFornisseur($idf){
    $res = $this->pdo->prepare("select * from order_achat where idf = ?");
    $res->execute(array($idf));
    $result = $res->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $row){
      $reste = floatval($row["prixtotale"]) - floatval($row["montantpayee"]);
      echo '
      <tr>
        <td>'.$row["id"].'</td>
        <td>'.$row["date"].'</td>
        <td>'.$this->getNomProduit($row["idp"]).'</td>
        <td>'.$row["qte"].'</td>
        <td>'.$row["prixachat"].'</td>
        <td>'.$row["prixtotale"].'</td>
        <td>'.$reste.'</td>
        <form action="api/POSTS/payment.php?paymentFornisseur&ajout" method="POST">
          <td>
            <input type="text" name="montant" required palceholder="montant en dinar" class="form-control" id="f'.$row["id"].'">
            <input hidden type="text" value="'.$row["id"].'" name="id">
          </td>
          <td>
            <input type="text" id="'.$row["id"].'" hidden value="'.$reste.'">
            <button class="fa fa-credit-card btn btn-success" onclick="return verif(\'f'.$row["id"].'\',\''.$row["id"].'\')" type="submit"></button>
          </td>
        </form>
        </tr>';
    }
  }
  private function getNomProduit($idp){
    $res = $this->pdo->prepare("select label from produit where id = ?");
    $res->execute(array($idp));
    return $res->fetchAll(PDO::FETCH_ASSOC)["0"]["label"];
}

function paymentFornisseur($idoa,$montant){
    $res = $this->pdo->prepare("select montantpayee from order_achat where id = ?");
    $res->execute(array($idoa));
    $old =  $res->fetchAll(PDO::FETCH_ASSOC)["0"]["montantpayee"];
    $new = floatval($old) + floatval($montant);
    $res = $this->pdo->prepare("update order_achat set montantpayee = ?, ddpayment = ? where id = ?");
    $res->execute(array($new,"20".date("y-m-d"),$idoa));

}

}
?>
