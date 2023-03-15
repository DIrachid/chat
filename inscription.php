<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">        
    <title>Inscription</title>
</head>
<body>
    <?php 
    if(isset($_POST['valider'])){
        require_once 'connexion.php';
        $email = $_POST['email'];
        $name = $_POST['name'];
        $password = $_POST['password'];
        $confirm_password = $_POST['cpassword'];
        
        if(isset($name) && isset($email) && isset($password) && isset($confirm_password) && $name != "" && $email != "" && $password != "" && $confirm_password != ""){
            $sqlstate = $con->prepare('select * from utilisateur where email=:email');
            $sqlstate->bindParam(':email',$email);
            $sqlstate->execute();
            $sqlnom = $con->prepare('select * from utilisateur where name=:name');
            $sqlnom->bindParam(':name',$name);
            $sqlnom->execute();
            if($sqlstate->rowCount()==0){
                if($sqlnom->rowCount()==0){
                    if($password === $confirm_password){
                        $sql = $con->prepare("insert into utilisateur values(null,:name,:email,:password) ");
                        $sql->bindParam(":email",$email);
                        $sql->bindParam(":name",$name);
                        $sql->bindParam(":password",$password);
                        $sql->execute();
                        $_SESSION['message']="<p class='messagesession'>Votre compte a ete creer avec success</p>";
                        header('location:index.php');
                }else{
                    $error = "Mot de passse different  !";
                }
                }else{
                    
                    $error = "Cet nom existe deja";
                }
            }else{
                $error = "Cet email existe deja";
            }
        }else{
            $error = "Veuillez remplir tous les champs !";
        }
    }
    ?>
    <form action="" class="inscription" method="post">
        <h1>Inscription</h1>
        <p class="message_error">
            <?php 
            if(isset($error)){
                echo $error;
            }
            ?>
        </p>
        <label >Name</label>
        <input type="text" name="name">
        <label>Adrees Mail</label>
        <input type="email" name="email">
        <label for="">Password</label>
        <input type="password" name="password" class="mdp1">
        <label for="">Confirm Password</label>
        <input type="password" name="cpassword" class="mdp2">
        <input type="submit" value="Inscription" name="valider">
        <p class="link">Vous n'avez pas de compte ? <a href="index.php">Se connecter</a></p>
    </form>
    <script src="script.js"></script>
</body>
</html>