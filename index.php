<?php
session_start();
    
    require_once 'bdd_connexion/database.php';


    if(isset($_POST['inscription_btn'])){
        extract($_POST);
        $prenom = trim(htmlentities($_POST['prenom']));
        $nom = trim(htmlentities($_POST['nom']));
        $postnom = trim(htmlentities($_POST['postnom']));
        $number_phone = trim(htmlentities($_POST['number_phone']));
        $motdepasse = trim(htmlentities($_POST['motdepasse']));
        $date_naissance = trim(htmlentities($_POST['date_naissance']));
        $province = trim(htmlentities($_POST['province']));
        $adresse = trim(htmlentities($_POST['adresse']));

        if(isset($prenom,$nom,$postnom,$number_phone,$motdepasse,$date_naissance,$province,$adresse) AND !empty($prenom) AND !empty($nom) AND !empty($postnom) AND !empty($number_phone) AND !empty($motdepasse) AND !empty($date_naissance) AND !empty($province) AND !empty($adresse) ){


            if(isset($_FILES['image_profil']) AND !empty($_FILES['image_profil'])){
                $image_name = $_FILES['image_profil']['name'];
                $temp_path = $_FILES['image_profil']['tmp_name'];
                
                $path_website = "website_img/".$image_name;
                
                $recup_extension = strrchr($image_name,'.');
                $extension_autorise = array(".JPG",".PNG",".JPEG",".jpg",".png",".jpeg");
                var_dump($image_name);

                if(in_array($recup_extension,$extension_autorise)){

                    if(move_uploaded_file($temp_path,$path_website)){

                        $req = $bdd->prepare("INSERT INTO users_table (prenom,nom,postnom,number_phone,motdepasse,date_naissance,province,adresse)  VALUES(?,?,?,?,?,?,?,?)");
                        $req->execute(array($prenom,$nom,$postnom,$number_phone,sha1($motdepasse),$date_naissance,$province,$adresse));
    
                        if($req){
    
                            echo "Bien enregister";
                            header('location:connexion.php');
                        }
                    }
                    else{
                        $error = "Erreur lors du chargement de l'image";
                    }

                }
                else{
                    $error ="Choisissez un bon format d'image";
                }
            }
            else{
                $error = "pff";
            }

            //header('location:image_profil_choice.php');
            

        }
        else
        {
            $error ="Veuillez saisir tous les champs";
        }
        
        
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription</title>
</head>
<body>
<h1>INSCRIVEZ-VOUS ET CREEZ VOTRE PROFIL DMP</h1>
    <?php if(isset($error)){echo $error;}  ?>
    <form action="index.php" method="post"  enctype = multipart/form-data >
    
    <input type="text" name="prenom" placeholder = "Prénom"   value="<?php if(isset($prenom)) echo $prenom; ?>" ><br><br>
    <input type="text" name="nom" placeholder = "Nom" value="<?php if(isset($nom)) echo $nom; ?>"><br><br>
    <input type="text" name="postnom" placeholder = "Postnom" value="<?php if(isset($postnom)) echo $postnom; ?>" ><br><br>
    <input type="text" name="number_phone" placeholder = "Numéro de téléphone" value="<?php if(isset($number_phone)) echo $number_phone; ?>" ><br><br>
    <input type="file" name="image_profil" id=""><br><br>
    <input type="password" name="motdepasse" placeholder = "Mot de passe" ><br><br>
    <input type="date" name="date_naissance" id=""  value="<?php if(isset($date_naissance)) echo $date_naissance; ?>" ><br><br>
    <input type="text" name="province" placeholder = "province"  value="<?php if(isset($province)) echo $province; ?>" ><br><br>
    <input type="text" name="adresse" placeholder = "adresse"  value="<?php if(isset($adresse)) echo $adresse; ?>" ><br><br>

    <input type="submit" value="Je m'inscris" name = "inscription_btn" >
    
    
    </form>
</body>
</html>