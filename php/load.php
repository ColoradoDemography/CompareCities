<?php
header("Access-Control-Allow-Origin: *");


require '../../CensusAPI/connect.php';


$arr=[];
$arrfull=[];

// attempt a connection
$dbh = pg_connect("host=".$server." dbname=acs0913 user=".$user." password=".$password);

if (!$dbh) {
    die("Error in connection: " . pg_last_error());
}

$sumlev=" and sumlev=160";
$state=" and state=8";
$pop=" and b01001001>4999";

  //Query metadata
  $sql="select geonum, geoname, state, ((b19001002+b19001003+b19001004+b19001005+b19001006) / b19001001) as hhi1, ((b19001007+b19001008+b19001009+b19001010+b19001011) / b19001001) as hhi2, ((b19001012+b19001013) / b19001001) as hhi3, ((b19001014+b19001015+b19001016+b19001017) / b19001001) as hhi4, (b11001002 / b11001001) as fam1, (b11001003 / b11001001) as fam2, (b11001007 / b11001001) as fam3, (b11001008 / b11001001) as fam4, ((b25075002+b25075003+b25075004+b25075005+b25075006+b25075007+b25075008+b25075009+b25075010+b25075011+b25075012+b25075013+b25075014) / NULLIF(b25075001, 0)) as val1, ((b25075015+b25075016+b25075017+b25075018) / NULLIF(b25075001,0)) as val2, ((b25075019+b25075020) / NULLIF(b25075001, 0)) as val3, ((b25075021+b25075022) / NULLIF(b25075001, 0)) as val4, ((b25075023+b25075024+b25075025) / NULLIF(b25075001,0)) as val5, ((b25063003+b25063004+b25063005+b25063006+b25063007+b25063008+b25063009+b25063010+b25063011+b25063012+b25063013) / NULLIF(b25063002,0)) as rent1, ((b25063014+b25063015+b25063016+b25063017+b25063018+b25063019) / b25063002) as rent2, ((b25063020 + b25063021) / b25063002) as rent3, ((b25063022+b25063023) / b25063002) as rent4, ((b25034010 + b25034009) / b25034001) as built1, ((b25034008 + b25034007) / b25034001) as built2, ((b25034006 + b25034005) / b25034001) as built3, ((b25034004 + b25034003 + b25034002) / b25034001) as built4, (b23025004 / b23025001) as labor1, (b23025005 / b23025001) as labor2, (b23025006 / b23025001) as labor3, (b23025007 / b23025001) as labor4, ((b05001002+b05001003+b05001004) / b05001001) as native1, (b05001005 / b05001001) as native2, (b05001006 / b05001001) as native3, (b03002012 / b03002001) as race1, (b03002003 / b03002001) as race2, (b03002004 / b03002001) as race3, (b03002005 / b03002001) as race4, (b03002006 / b03002001) as race5, (b03002007 / b03002001) as race6, ((b01001003+b01001004+b01001005+b01001006+b01001027+b01001028+b01001029+b01001030) / b01001001) as age1, ((b01001007+b01001008+b01001009+b01001010+b01001031+b01001032+b01001033+b01001034) / b01001001) as age2, ((b01001011+b01001012+b01001035+b01001036) / b01001001) as age3, ((b01001013+b01001014+b01001037+b01001038) / b01001001) as age4, ((b01001015+b01001016+b01001017+b01001018+b01001019+b01001039+b01001040+b01001041+b01001042+b01001043) / b01001001) as age5, ((b01001020+b01001021+b01001022+b01001023+b01001024+b01001025+b01001044+b01001045+b01001046+b01001047+b01001048+b01001049) / b01001001) as age6, (b01001001) as pop, ((b14001008+b14001009) / b14001001) as enr, (b08006002 / b08006001) as drive, (b07003004 / b07003001) as nomove, (b25003002 / b25003001) as own, ((b15003002+b15003003+b15003004+b15003005+b15003006+b15003007+b15003008+b15003009+b15003010+b15003011+b15003012+b15003013+b15003014+b15003015+b15003016) / b15003001) as edu1, ((b15003017+b15003018) / b15003001) as edu2, ((b15003019+b15003020+b15003021) / b15003001) as edu3, (b15003022 / b15003001) as edu4, ((b15003023+b15003024+b15003025) / b15003001) as edu5 from search.data natural join data.b19001 natural join data.b01001 natural join data.b11001 natural join data.b25075 natural join data.b03002 natural join data.b25003 natural join data.b05001 natural join data.b07003 natural join data.b25063 natural join data.b15003 natural join data.b25034 natural join data.b08006 natural join data.b14001 natural join data.b23025 where 1=1".$sumlev.$state.$pop.";";

  $result = pg_query($dbh, $sql);
  
while ($row = pg_fetch_array($result)) {

  //add metadata information to metadata array for each (non-moe) field
  $arr=array('geonum' => $row['geonum'], 'geoname' => $row['geoname'], 'state' => $row['state'], 'pop' => $row['pop'], 'hhi1' => $row['hhi1'], 'hhi2' => $row['hhi2'], 'hhi3' => $row['hhi3'], 'hhi4' => $row['hhi4'], 'fam1' => $row['fam1'], 'fam2' => $row['fam2'], 'fam3' => $row['fam3'], 'fam4' => $row['fam4'], 'val1' => $row['val1'], 'val2' => $row['val2'], 'val3' => $row['val3'], 'val4' => $row['val4'], 'val5' => $row['val5'], 'rent1' => $row['rent1'], 'rent2' => $row['rent2'], 'rent3' => $row['rent3'], 'rent4' => $row['rent4'], 'built1' => $row['built1'], 'built2' => $row['built2'], 'built3' => $row['built3'], 'built4' => $row['built4'], 'labor1' => $row['labor1'], 'labor2' => $row['labor2'], 'labor3' => $row['labor3'], 'labor4' => $row['labor4'], 'native1' => $row['native1'], 'native2' => $row['native2'], 'native3' => $row['native3'], 'race1' => $row['race1'], 'race2' => $row['race2'], 'race3' => $row['race3'], 'race4' => $row['race4'], 'race5' => $row['race5'], 'race6' => $row['race6'], 'age1' => $row['age1'], 'age2' => $row['age2'], 'age3' => $row['age3'], 'age4' => $row['age4'], 'age5' => $row['age5'], 'age6' => $row['age6'], 'enr' => $row['enr'], 'drive' => $row['drive'], 'nomove' => $row['nomove'], 'own' => $row['own'], 'edu1' => $row['edu1'], 'edu2' => $row['edu2'], 'edu3' => $row['edu3'], 'edu4' => $row['edu4'], 'edu5' => $row['edu5']);
    array_push($arrfull, $arr);
  }



      header('Content-Type: application/json');
      echo json_encode($arrfull);



?>