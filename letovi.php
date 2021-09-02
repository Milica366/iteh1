<?php
    include 'header.php';
?>

<div class='container'>

    <div class="row mt-2">
        <div class="col-12">
            <input type="text" placeholder="Pretrazi" class="form-control" id='search'>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <th>ID</th>
                    <th>Destinacija</th>
                    <th>Avio kompanija</th>
                    <th>Cena</th>
                    <th>Duzina leta</th>
                </thead>
                <tbody id='letovi'>

                </tbody>
            </table>
        </div>
    </div>

</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
    let letovi = [];

    $(document).ready(function () {
        $.getJSON('server/letovi.php', function (res) {
            if (!res.status) {
                alert(res.greska);
                return;
            }
            letovi = res.data;
            iscrtaj(letovi);
        })
        $('#search').change(function (e) {
            const value = e.currentTarget.value;
            iscrtaj(letovi.filter(function (element) {
                return element.destinacija.includes(value) || element.kompanija.includes(value)
            }))
        })
    })

    function iscrtaj(val) {

        $('#letovi').html('');
        for (let l of val) {
            $('#letovi').append(`
                <tr> 
                    <td>${l.id}</td>    
                    <td>${l.destinacija}</td>    
                    <td>${l.kompanija}</td>    
                    <td>${l.cena}$</td>    
                    <td>${l.duzina}h</td>    
                </tr>
            `)
        }
    }

</script>

<?php
    include 'footer.php';
?>