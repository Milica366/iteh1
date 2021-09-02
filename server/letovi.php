<?php
include 'broker.php';

$broker=Broker::getBroker();

$res=$broker->izvrsiCitanje("select l.id, l.duzina, l.cena, d.naziv as 'destinacija', k.naziv as 'kompanija', k.id as 'kompanija_id' from let l inner join destinacija d on (d.id=l.destinacija) inner join kompanija k on (k.id=l.kompanija) ");
echo json_encode($res);

?>