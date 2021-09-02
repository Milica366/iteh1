<?php
    include 'header.php';
?>

<div class='container'>
    <div class='row mt-2'>
        <div class='col-8'>
            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sifra</th>
                        <th>Naziv</th>
                        <th>Detalji</th>
                        <th>Obrisi</th>
                    </tr>
                </thead>
                <tbody id='kompanije'>

                </tbody>
            </table>
        </div>
        <div class='col-4'>
            <h2>Kreiraj kompaniju</h2>
            <form id='forma'>
                <label>Naziv</label>
                <input class='form-control' type="text" id='naziv' required>
                <label>Sifra</label>
                <input class='form-control' type="text" id='sifra' required>
                <button class='form-control btn btn-primary mt-2'>Kreiraj</button>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        ucitaj();
        $('#forma').submit(function (e) {
            e.preventDefault();
            $.post('server/kompanija.php', { akcija: 'kreiraj', naziv: $('#naziv').val(), sifra: $('#sifra').val() }, function (res) {
                res = JSON.parse(res);

                if (!res.status) {
                    alert(res.greska);
                    return;
                }
                ucitaj();
            })
        })
    })
    function ucitaj() {
        $.getJSON('server/kompanija.php', { akcija: 'all' }, function (res) {

            if (!res.status) {
                alert(res.greska);
                return;
            }
            $('#kompanije').html('');
            for (let kompanija of res.data) {
                $('#kompanije').append(`
                        <tr>
                            <th>${kompanija.id}</th>
                            <td>${kompanija.sifra}</td>
                            <td>${kompanija.naziv}</td>
                            <td>
                              <a href='kompanija.php?id=${kompanija.id}'>
                                <button class='form-control  btn btn-success mt-2'>Detalji</button>
                                </a>
                            </td>
                            <td>
                                <button onClick="obrisi(${kompanija.id})" class='form-control  btn btn-danger mt-2'>Obrisi</button>
                            </td>
                        </tr>
                    `)
            }

        });


    }
    function obrisi(id) {

        $.post('server/kompanija.php', { akcija: 'obrisi', id }, function (res) {

            res = JSON.parse(res);

            if (!res.status) {
                alert(res.greska);
            }
            ucitaj();
        })
    }
</script>


<?php
    include 'footer.php';
?>