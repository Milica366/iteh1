<?php
if(!isset($_GET['id'])){
    header('Location: index.php');
  
}
include 'server/broker.php';

$broker=Broker::getBroker();
    $rezultat=$broker->izvrsiCitanje('select * from kompanija where id='.$_GET['id']);
    if($rezultat['status'] && count($rezultat['data'])==1){
        $kompanija=$rezultat['data'][0];
    }else{
        header('Location: index.php');
    }
    include 'header.php';
?>

<div class="container ">
    <h1>Izmeni kompaniju</h1>
    <div class="row mb-5">
        <div class="col-12">
            <form id='forma'>
                <label>ID</label>
                <input type="text" disabled class='form-control' id='id_kompanije' value="<?php echo $_GET['id'];?>">
                <label>Naziv</label>
                <input class='form-control' type="text" id='naziv' required value="<?php echo $kompanija->naziv?>">
                <label>Sifra</label>
                <input class='form-control' type="text" id='sifra' value="<?php echo $kompanija->sifra?>" required>
                <button class='form-control btn btn-primary mt-2'>Izmeni</button>
            </form>
        </div>
    </div>
    <h1>Letovi</h1>
    <div class="row">

        <div class="col-8">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Destinacija</th>
                        <th>Cena</th>
                        <th>Trajanje leta</th>
                        <th>Obrisi</th>
                    </tr>
                </thead>
                <tbody id="letovi_tabela">

                </tbody>
            </table>
        </div>
        <div class="col-4">
            <h3>Dodaj let</h3>
            <form id="let_forma">

                <label>Cena($)</label>
                <input required class="form-control" type="number" id="cena">
                <label>Trajanje(h)</label>
                <input required class="form-control" type="number" id="trajanje">
                <label>Destinacija</label>
                <select required class="form-control" type="text" id="destinacija">

                </select>
                <button class="form-control btn btn-primary mt-2">Kreiraj</button>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        const id = $('#id_kompanije').val();
        ucitajLetove(id);
        ucitajDestinacije();
        $('#let_forma').submit(function (e) {
            e.preventDefault();
            const cena = $('#cena').val();
            const trajanje = $('#trajanje').val();
            const destinacija = $('#destinacija').val();
            $.post('server/kompanija.php', { akcija: 'kreiraj let', id, cena, trajanje, destinacija }, function (res) {
                res = JSON.parse(res);
                if (!res.status) {
                    alert(res.greska);
                    return;
                }
                ucitajLetove(id);
            })
        })
        $('#forma').submit(function (e) {
            e.preventDefault();
            const naziv = $('#naziv').val();
            const sifra = $('#sifra').val();
            $.post('server/kompanija.php', { akcija: 'izmeni', id, naziv, sifra }, function (res) {

                res = JSON.parse(res);
                console.log(res)
                if (!res.status) {
                    alert(res.greska)
                } else {
                    alert('uspesno izmenjena kompanija')
                }

            })
        })
    })
    function ucitajLetove(id) {
        $.getJSON('server/kompanija.php', { akcija: 'letovi', id }, function (res) {
            console.log(res);
            if (!res.status) {
                alert(res.greska);
                return;
            }
            $('#letovi_tabela').html('');
         
            for (let l of res.data) {
                $('#letovi_tabela').append(`
                <tr> 
                    <td>${l.id}</td>    
                    <td>${l.destinacija}</td>    
                   
                    <td>${l.cena}$</td>    
                    <td>${l.duzina}h</td>    
                    <td> 
                        <button onClick="obrisiLet(${id},${l.id})" class='form-control btn btn-danger'>Obrisi </button>    
                    </td>
                </tr>
                `)
            }
        })
    }
    function ucitajDestinacije() {
        $.getJSON('server/destinacija.php', { akcija: 'all' }, function (res) {
            if (!res.status) {
                alert(res.greska)
                return
            }
            $('#destinacija').html('');
            for (let d of res.data) {
                $('#destinacija').append(`
                <option value=${d.id}>${d.naziv}</option>
                `)
            }
        })
    }
    function obrisiLet(kompanija, let) {
        $.post('server/kompanija.php', { akcija: 'obrisi let', kompanija, let }, function (res) {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.greska);
                return;
            }
            alert('uspeno obrisan let');
            ucitajLetove(kompanija);
        })
    }
</script>
<?php
    include 'footer.php';
?>