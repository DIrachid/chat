<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Chat</title>
</head>
<body>
<?php
        // connexion
        require_once 'connexion.php';
        if(isset($_POST['send'])){
            $message = $_POST['message'];
            $id_utilisateur = $_SESSION['user']['id'];
            $name = $_SESSION['user']['name'];
            $email = $_SESSION['user']['email'];
            $date = date('Y-m-d H:i:s');
            if(isset($message) && $message != ""){
                $sql = $con->prepare('insert into messages values(null,:email,:message,:date,:id)');
                $sql->bindParam(':id',$id_utilisateur);
                $sql->bindParam(':email',$email);
                $sql->bindParam(':message',$message);
                $sql->bindParam(':date',$date);
                $sql->execute();
                header('refresh: 3');
            }else{
                header('location:chat.php');
            }
            $message="";
        }
        ?>
    <div class="chat">
        <?php 
        if(empty($_SESSION['user'])){
            header("location:index.php");
        }
        ?>
        <div class="button_email">
            <span><?php echo $_SESSION['user']['name'] ?></span>
            <a href="deconnexion.php" class="deconnexion">Deconnexion</a>
        </div>
        <div class="message_box">
        
        </div>
        <form action="" method="POST" class="send_message">
            <textarea name="message" placeholder="Votre message" cols="5" rows="2"></textarea>
            <input type="submit" value="Envoyer" name="send">
        </form>
    </div>
    <script>
        var message_box = document.querySelector('.message_box');
        setInterval(function(){
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    message_box.innerHTML = this.responseText;
                }
            };
            xhttp.open("GET","messages.php",true);
            xhttp.send();
        },500)
    </script>
</body>
</html>