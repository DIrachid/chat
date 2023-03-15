<?php
session_start();
require_once 'connexion.php';
$sql = $con->prepare('select messages.*,utilisateur.name as "nom" from messages join utilisateur on utilisateur.id = messages.id_user order by messages.id asc');
$sql->execute();
    if($sql->rowCount() == 0){
        echo "message vide";
    }else{
        while($row=$sql->fetch()){
            if($row['nom'] == $_SESSION['user']['name']){
                ?>
                    <div class="message message1">
                        <span>vous</span>
                        <p><?php echo $row['message'] ?></p>
                        <p class="date"><?php $row['date'] ?></p>
                    </div>
            <?php
            }else{
            ?>
                    <div class="message message2">
                        <span><?php echo $row['nom'] ?></span>
                        <p><?php echo $row['message'] ?></p>
                        <p class="date"><?php $row['date'] ?></p>
                    </div>
            <?php
            }
        }
    }
?>

