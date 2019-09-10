<?php
include_once "base.php";
$sess=[
  6=>"14:00~16:00",
  5=>"16:00~18:00",
  4=>"18:00~20:00",
  3=>"20:00~22:00",
  2=>"22:00~24:00",
];

for($i=1;$i<10;$i++){
  $data['no']=date("Ymd").sprintf("%04d",$i);
  $data['movie']="院線片".sprintf("%02d",rand(1,6));
  $data['odate']="2019-07-".sprintf("%02d",rand(8,10));
  $data['sess']=$sess[rand(2,6)];
  $data['qt']=rand(1,4);
  $data['seat']=serialize([rand(0,19),rand(0,19)]);
  save("ord",$data);
}

?>