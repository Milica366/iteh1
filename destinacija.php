<?php
    include 'header.php';
?>


<div class='container'>
    <div class='row mt-2'>
        <div class='col-5'>
            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Naziv</th>
                        <th>Obrisi</th>
                    </tr>
                </thead>
                <tbody id='destinacije'>

                </tbody>
            </table>
        </div>
        <div class='col-4'>
            <h2>Kreiraj destinaciju</h2>
            <form id='forma'>
                <label>Naziv</label>
                <input class='form-control' type="text" id='naziv' required>
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
            $.post('server/destinacija.php', { akcija: 'kreiraj', naziv: $('#naziv').val() }, function (res) {
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
        $.getJSON('server/destinacija.php', { akcija: 'all' }, function (res) {

            if (!res.status) {
                alert(res.greska);
                return;
            }
            $('#destinacije').html('');
            for (let destinacija of res.data) {
                $('#destinacije').append(`
                        <tr>
                            <th>${destinacija.id}</th>
                            <td>${destinacija.naziv}</td>
                            <td>
                                <button onClick="obrisi(${destinacija.id})" class='form-control  btn btn-danger mt-2'>Obrisi</button>
                            </td>
                        </tr>
                    `)
            }

        });


    }
    function obrisi(id) {

        $.post('server/destinacija.php', { akcija: 'obrisi', id }, function (res) {

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