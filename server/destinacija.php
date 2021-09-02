<?php
    include 'broker.php';
  
    $broker=Broker::getBroker();

  
    if(isset($_GET['akcija'])){
        if($_GET['akcija']=='all'){
            echo json_encode($broker->izvrsiCitanje('select * from destinacija'));
        }
    }
    if(isset($_POST['akcija'])){
        if($_POST['akcija']=='kreiraj'){
            echo json_encode($broker->izvrsiIzmenu("insert into destinacija (naziv) values ('".$_POST['naziv']."')"));
        }
        if($_POST['akcija']=='obrisi'){
            echo json_encode($broker->izvrsiIzmenu("delete from destinacija where id=".$_POST['id']));
        }
    }


?>