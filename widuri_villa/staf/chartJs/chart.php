<script type="text/javascript">
  //chart Transaksi
  var ctx = document.getElementById("chartTransaksi").getContext('2d');
  ctx.height = 150;
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "Ma", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec"],
      datasets: [{
        label: "Transaksi valid (<?php echo date('Y') ?>)",
        data: [ 
          <?php 
            $data =  grafikValid(date('Y'));
            for ($i=0; $i <count($data) ; ++$i) { 
              echo  $data[$i].',';
            }
          ?>
        ],
        borderColor: "rgba(54, 162, 235, 1)",
        borderWidth: "1",
        backgroundColor: "rgba(54, 162, 235, 0.2)" }, {
          label: "Transaksi Ditolak (<?php echo date('Y') ?>)",
          data: [ 
            <?php 
              $data =  grafikGakValid(date('Y'));
              for ($i=0; $i <count($data) ; ++$i) { 
                echo  $data[$i].',';
              }
            ?>
          ],
          borderColor: "rgba(255,99,132,1)",
          borderWidth: "1",
          backgroundColor: "rgba(255, 99, 132, 0.2)"
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
  // chart Resrvasi
  var ctx = document.getElementById( "chartResrvasi" );
  ctx.height = 150;
  var myChart = new Chart( ctx, {
    type: 'line',
    data: {
      labels: ["Jan", "Feb", "Ma", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct","Nov","Dec"],
      datasets: [{
        label: "Reservasi tahun ini (<?php echo date('Y') ?>)",
        data: [ 
          <?php 
            $data =  grafikReservasi(date('Y'));
            for ($i=0; $i <count($data) ; ++$i) { 
              echo  $data[$i].',';
            }
          ?>
        ],
        borderColor: "rgba(0, 123, 255, 0.9)",
        borderWidth: "0.8",
        backgroundColor: "rgba(0, 123, 255, 0.5)",
        pointHighlightStroke: "rgba(26,179,148,1)"
        },
        {
          label: "Reservasi tahun lalu (<?php echo date('Y',strtotime("-1 year")); ?>)",
          data: [ 
            <?php 
              $data =  grafikReservasi(date('Y',strtotime("-1 year")));
              for ($i=0; $i <count($data) ; ++$i) { 
                echo  $data[$i].',';
              }
            ?>
          ],
          borderColor: "rgba(0,0,0,.3)",
          borderWidth: "0.8",
          backgroundColor: "rgba(0,0,0,.2)",
          pointHighlightStroke: "rgba(26,179,148,1)"
        }
      ]
    },
    options: {
      tooltips: {
        mode: 'index',
        intersect: false,
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