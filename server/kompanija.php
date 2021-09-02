<?php
    include 'broker.php';
    $broker=Broker::getBroker();
    if(isset($_GET['akcija'])){
        if($_GET['akcija']=='all'){
            echo json_encode($broker->izvrsiCitanje('select * from kompanija'));
        }
        if($_GET['akcija']=='letovi'){
            echo json_encode($broker->izvrsiCitanje("select l.id, l.duzina, l.cena, d.naziv as 'destinacija', k.naziv as 'kompanija' from let l inner join destinacija d on (d.id=l.destinacija) inner join kompanija k on (k.id=l.kompanija) where l.kompanija=".$_GET['id']));
        }
    }
    if(isset($_POST['akcija'])){
        if($_POST['akcija']=='kreiraj'){
            echo json_encode($broker->izvrsiIzmenu("insert into kompanija (naziv,sifra) values ('".$_POST['naziv']."','".$_POST['sifra']."')"));
        }
        if($_POST['akcija']=='izmeni'){
            echo json_encode($broker->izvrsiIzmenu("update kompanija set naziv='".$_POST['naziv']."', sifra='".$_POST['sifra']."' where id=".$_POST['id']));
        }
        if($_POST['akcija']=='obrisi'){
            echo json_encode($broker->izvrsiIzmenu("delete from kompanija where id=".$_POST['id']));
        }
        if($_POST['akcija']=='obrisi let'){
            echo json_encode($broker->izvrsiIzmenu("delete from let where id=".$_POST['let']." and kompanija=".$_POST['kompanija']));
        }
        if($_POST['akcija']=='kreiraj let'){
            echo json_encode($broker->izvrsiIzmenu("insert into let(kompanija,destinacija,cena,duzina) values (".$_POST['id'].",".$_POST['destinacija'].",".$_POST['cena'].",".$_POST['trajanje'].")"));
        }
    }
    


?>