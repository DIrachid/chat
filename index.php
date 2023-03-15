<?php 
  session_start();
?>
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

    <form action="" class="inscription" method="post">
        <h1>CONNEXION</h1>
        <?php
        if(isset($_POST['btn'])){
            require_once 'connexion.php';
            $email = $_POST['email'];
            $password = $_POST['password'];
            if(isset($email) && isset($password) && $email != "" && $password != ""){
                $sql = $con->prepare('select * from utilisateur where email=:email and password=:password');
                $sql->bindParam(':email',$email);
                $sql->bindParam('password',$password);
                $sql->execute();
                if($sql->rowCount()!=0){
                    $_SESSION['user'] = $sql->fetch();
                    header('location:chat.php');
                    unset($_SESSION['message']);
                }else{
                    $error = "mot de passe ou bien email incorrect";
                }
            }else{
                $error = "remplire les champs s'il vous plait ";
            }
        }
        if(isset($_SESSION['message'])){
            echo $_SESSION['message'];
        }
        ?>
        <p class="message_error">
            <?php 
            if(isset($error)){
                echo $error;
            }
            ?>
        </p>
        <label>Adresse Mail</label>
        <input type="email" name="email">
        <label for="">Mot de passe</label>
        <input type="password" name="password">
        <input type="submit" value="Connexion" name="btn">
        <P class="link">Vous avez un compte ? <a href="inscription.php">Creer un compte</a></P>
    </form>
</body>
</html>