<?php
echo '
<ul class="nav menu">
    <li class="active"><a href="index.php"><em class="fa fa-dashboard">&nbsp;</em> Tableau de bord</a></li>
        <li class="parent "><a data-toggle="collapse" href="#sub-item-1">
            <em class="fa fa-calendar">&nbsp;</em> Journal <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><i class="fa fa-plus"></i></span>
            </a>
            <ul class="children collapse" id="sub-item-1">
                <li><a class="fa fa-calendar-plus-o" href="ajoutJournal.php">
                    &nbsp;	Ajouter au journal
                </a></li>
                <li><a class="fa fa-calendar"href="listeJournal.php">
                    &nbsp; Liste de journal
                </a></li>
            </ul>
            <li class="parent "><a data-toggle="collapse" href="#sub-item-3">
            <em class="fa fa-users">&nbsp;</em> Clients <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><i class="fa fa-plus"></i></span>
            </a>
            <ul class="children collapse" id="sub-item-3">
            </a></li>
            <li><a class="fa fa-users"href="ajoutClientAncien.php">
            Ajout Client Ancien
            </a></li>
            <li><a class="fa fa-user-plus" href="ajoutClient.php">
            &nbsp; Ajouter Client
            </a></li>
            <li><a class="fa fa-users"href="listeClients.php">
            &nbsp; Liste de Clients
            </a></li>
            </ul>
            <li class="parent "><a data-toggle="collapse" href="#sub-item-4">
            <em class="fa fa-users">&nbsp;</em> Fournisseurs <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><i class="fa fa-plus"></i></span>
            </a>
            <ul class="children collapse" id="sub-item-4">
            <li><a class="fa fa-user-plus" href="ajoutFornisseur.php">
            &nbsp; Ajouter Fournisseur
            </a></li>
            <li><a class="fa fa-users"href="listeFornisseurs.php">
            &nbsp; Liste de Fournisseurs
            </a></li>
            </ul>
    <li><a href="devis.php"><em class="fa fa-file-text-o">&nbsp;</em> devis</a></li>
    <li class="parent "><a data-toggle="collapse" href="#sub-item-2">
        <em class="fa fa-serverr">&nbsp;</em> Stock <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><i class="fa fa-plus"></i></span>
        </a>
        <ul class="children collapse" id="sub-item-2">
            <li><a class="fa fa-cart-plus" href="ajoutStock.php">
                &nbsp;	Ajouter au Stock
            </a></li>
            <li><a class="fa fa-cart-arrow-down" href="listeProduits.php">
                &nbsp;	Liste de Stock
            </a></li>
        </ul>
        </li>
<li><a href="api/POSTS/admin.php?logout"><em class="fa fa-sign-out">&nbsp;</em> Deconnexion</a></li>
</ul>
';
 ?>
