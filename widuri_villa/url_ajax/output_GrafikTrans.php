<?php
  session_start();
  $tahun = $_SESSION['tahun'];
  require '../koneksi/function_global.php';
  // $already_selected_value = 2019;
  $earliest_year = 2017;
?>
<div class="row">
  <canvas id="chartTrans" width="600" height="260"></canvas>
</div>
<script type="text/javascript">
  var ctx = document.getElementById("chartTrans").getContext('2d');
  ctx.height = 150;
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Ma", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec"],
      datasets: [{
        label: "Transaksi valid (<?php echo $tahun ?>)",
        data: [ 
          <?php 
            $data =  grafikValid($tahun);
            for ($i=0; $i <count($data) ; ++$i) { 
              echo  $data[$i].',';
            }
          ?>
        ],
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: "1",
        backgroundColor: "rgba(54, 162, 235, 1)" }, {
          label: "Transaksi Ditolak (<?php echo $tahun ?>)",
          data: [ 
            <?php 
              $data =  grafikGakValid($tahun);
              for ($i=0; $i <count($data) ; ++$i) { 
                echo  $data[$i].',';
              }
            ?>
          ],
          borderColor: "rgba(255, 87, 87,1)",
          borderWidth: "1",
          backgroundColor: "rgba(255, 87, 87,1)"
        }
      ]
    },
    options: {
      responsive: true,
      tooltips: {
        mode: 'index',
        intersect: false
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true,
            callback: function(value) {if (value % 1 === 0) {return value;}}
          }
        }]
      }
    }
  });
</script>