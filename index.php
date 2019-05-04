

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        .box {
            width: 900px;
            margin: 0 auto;
        }
        .box-child {
            display: inline-table;
            margin-left: 1rem;
        }

        .box-form {
            padding: 0.5rem;
            margin: 0.5rem;
        }

        .box-form input, select {
            display: block;
            width: 100%;
            height: 30px;
        }
    </style>
    <script src="assets/js/jquery.min.js"></script>
</head>
<body>
<h1>Cek Ongkir PHP MySql</h1>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">nama</th>
      <th scope="col">asal</th>
      <th scope="col">tujuan</th>
      <th scope="col">berat (gram)</th>
      <th></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
  <?php 
    require "db.php";
    $no=1;
    $sql= $conn->query("select * from tbl_barang");
    while($row=$sql->fetch_array()){ ?>
    <tr>
      <td><?php echo $no++; ?></td>
      <td class="brg"><?php echo $row['barang']; ?></td>
      <td class="city_origin"><?php echo $row['asal']; ?></td>
      <td class="city_destination"><?php echo $row['tujuan']; ?></td>
      <td class="weight"><?php echo $row['berat']; ?></td>
      <td class="courier">jne</td>
      <td>
      <button type="button" class="use-address" >lihat</button>
      </td>
    </tr>

    <?php }
  ?>
    
  </tbody>
</table>

<script>
$(".use-address").click(function() {
    $("#mydiv").load(location.href + " #mydiv");
    var $row = $(this).closest("tr");    // Find the row
    var barang = $row.find(".brg").text(); // Find the text
    var city_origin = $row.find(".city_origin").text(); // Find the text
    var city_destination = $row.find(".city_destination").text(); // Find the text
    var weight = $row.find(".weight").text(); // Find the text

    $.getJSON("kurir_jne.php?city_origin=" + city_origin + "&city_destination=" + city_destination + "&weight=" + weight  , function (cost) {
                if(cost) {
                    if(cost['rajaongkir']['results'][0]['costs'].length > 0) {
                        $.each(cost['rajaongkir']['results'][0]['costs'], function(key, value) {
                            $("#kurir_jne").append(
                                "<option value='" + value.service + "'>jne " + value.service + " ( " + value.cost[0]['etd']+ ") " + value.cost[0]['value'] + "</option>"
                            );
                                
                        });
                    }
                }
            });

        
    $.getJSON("kurir_tiki.php?city_origin=" + city_origin + "&city_destination=" + city_destination + "&weight=" + weight , function (cost) {
                if(cost) {
                    if(cost['rajaongkir']['results'][0]['costs'].length > 0) {
                        $.each(cost['rajaongkir']['results'][0]['costs'], function(key, value) {
                            $("#kurir_tiki").append(
                                "<option value='" + value.service + "'>tiki " + value.service + " ( " + value.cost[0]['etd']+ ") " + value.cost[0]['value'] + "</option>"
                            );
                        });
                    }
                }
            });


    $.getJSON("kurir_pos.php?city_origin=" + city_origin + "&city_destination=" + city_destination + "&weight=" + weight, function (cost) {
                if(cost) {
                    if(cost['rajaongkir']['results'][0]['costs'].length > 0) {
                        $.each(cost['rajaongkir']['results'][0]['costs'], function(key, value) {
                            $("#kurir_pos").append(
                                "<option value='" + value.service + "'>pos " + value.service + " ( " + value.cost[0]['etd']+ ") " + value.cost[0]['value'] + "</option>"
                            );
                        });
                    }
                }
            });
        
        //copy to value
      
       
    
    // Let's test it out
    });

   
</script>

<div class="box" id="hasil" >

    <div class="box-child" >
        <fieldset>
        
            <div class="box-form">
            

            <div class="box-form" id="mydiv">
                <label>Layanan 
                    <select name="service" id="service">
                    <optgroup label="JNE" id="kurir_jne">
                        
                    </optgroup>
                    <optgroup label="TIKI" id="kurir_tiki">
                        
                    </optgroup>
                    <optgroup label="POS" id="kurir_pos">
                        
                    </optgroup>
                    </select>
                </label>
            </div>

        </fieldset>
    </div>
    </div>
</div>

<script>


</script>
</body>
</html>