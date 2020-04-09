<script src="highcharts/code/highcharts.js"></script>
<script src="highcharts/code/modules/exporting.js"></script>
<script src="highcharts/code/modules/export-data.js"></script>
<script src="highcharts/code/highcharts-more.js"></script>
<script src="highcharts/code/modules/data.js"></script>

<?php

//Récupération des infos BDD pour le live
$DB_host = 'xxx';
$DB_name = 'xxx';
$DB_user = 'xxx';
$DB_pass = 'xxx';


// Create connection
$conn = new mysqli($DB_host, $DB_user, $DB_pass, $DB_name);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


//Temp 24h
//on recupère les 96 dernieres valeurs de chaque quart d'heure
$sql = 'SELECT DATE_FORMAT(date, "%H:%i") as heure,temp from xxx where (MINUTE(date) = 0 or MINUTE(date) = 15 or MINUTE(date) = 45 or MINUTE(date) = 30) order by date DESC limit 96 ';
$result = $conn->query($sql);
$tabCategorie = array();
$tabData = array();
while($row = $result->fetch_assoc()){
    $tabCategorie[] = $row['heure'];
    $tabData[] = $row['temp'];
} 
$tabCategorie = array_reverse($tabCategorie);
$tabData = array_reverse($tabData);
//print_r($tabCategorie);



?>
<div id="graphTempDaily" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
             

<script type="text/javascript">


Highcharts.chart('graphTempDaily', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Temperature Dernières 24h'
    },
    xAxis: {
        categories: ['<?php echo join($tabCategorie, "','"); ?>']
    },
    yAxis: {
        title: {
            text: 'Temperature (°C)'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Température',
        data: [<?php echo join($tabData, ',') ?>],
    }]
});

</script>
