var mdp1 = document.querySelector('.mdp1');
var mdp2 = document.querySelector('.mdp2');
var msg = document.querySelector('.message_error');
mdp2.onkeyup = function(){
    if(mdp1.value == mdp2.value){
        msg.innerText="";
    }else{
        msg.innerText="Mot de passe ne sont pas confirmes";
    }
}