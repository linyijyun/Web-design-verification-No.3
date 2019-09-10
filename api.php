<?php


include "base.php";

$do=(!empty($_GET['do']))?$_GET['do']:"";
switch($do){
  case "newPoster":

    if(!empty($_FILES['file']['tmp_name'])){
      $data['file']=$_FILES['file']['name'];
      move_uploaded_file($_FILES['file']['tmp_name'],"./poster/".$data['file']);
    }

    $data['rank']=q("select max(rank) from poster")[0][0] + 1;
    $data['name']=$_POST['name'];
    save("poster",$data);
    to("admin.php","do=poster");
  break;
  case "editPoster":
    foreach($_POST['id'] as $k => $id){
      if(!empty($_POST['del']) && in_array($id,$_POST['del'])){
          del("poster",$id);
      }else{
          $po=find("poster",$id);
          $po['sh']=(in_array($id,$_POST['sh']))?1:0;
          $po['name']=$_POST['name'][$k];
          $po['ani']=$_POST['ani'][$k];
          save("poster",$po);
      }
    }
    to("admin.php","do=poster");

  break;
  case "sw":
    $table=$_POST['table'];
    $data1=find($table,$_POST['id1']);
    $data2=find($table,$_POST['id2']);
    $tmp=$data1['rank'];
    $data1['rank']=$data2['rank'];
    $data2['rank']=$tmp;
    save($table,$data1);
    save($table,$data2);
    echo 1;
  break;
  case "newMovie":
    //利用id來判斷要行新增還是修改
    if(!empty($_POST['id'])){
      $data=find("movie",$_POST['id']);
    }

    if(!empty($_FILES['poster']['tmp_name'])){
      $data['poster']=$_FILES['poster']['name'];
      move_uploaded_file($_FILES['poster']['tmp_name'],"./movie/" . $data['poster']);
    }
  
    if(!empty($_FILES['trailer']['tmp_name'])){
      $data['trailer']=$_FILES['trailer']['name'];
      move_uploaded_file($_FILES['trailer']['tmp_name'],"./movie/" . $data['trailer']);
    }

    $data['ondate']=$_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];
    if(empty($_POST['id'])){
      $data['rank']=q("select max(rank) from movie")[0][0]+1;
    }

    foreach($_POST as $key => $val){
      switch($key){
        case "poster":
        case "trailer":
        case "year":
        case "month":
        case "day":
        break;
        default:
        $data[$key]=$val;
      }
    }
    save("movie",$data);
    to("admin.php","do=movie");
    
  break;
  case "editMovie":
    $data=find("movie",$_POST['id']);

    if(!empty($_FILES['poster']['tmp_name'])){
      $data['poster']=$_FILES['poster']['name'];
      move_uploaded_file($_FILES['poster']['tmp_name'],"./movie/" . $data['poster']);
    }
  
    if(!empty($_FILES['trailer']['tmp_name'])){
      $data['trailer']=$_FILES['trailer']['name'];
      move_uploaded_file($_FILES['trailer']['tmp_name'],"./movie/" . $data['trailer']);
    }

    $data['ondate']=$_POST['year'] . "-" . $_POST['month'] . "-" . $_POST['day'];
    

    foreach($_POST as $key => $val){
      switch($key){
        case "poster":
        case "trailer":
        case "year":
        case "month":
        case "day":
        break;
        default:
        $data[$key]=$val;
      }
    }
    save("movie",$data);
    to("admin.php","do=movie");
  break;
  case "del":
    $table=$_POST['table'];
    $id=$_POST['id'];
    del($table,$id);
  break;
  case "show":
    $movie=find("movie",$_POST['id']);
    $movie['sh']=($movie['sh']+1)%2;
    /* if($movie['sh']==1){
      $movie['sh']=0;
    }else{
      $movie['sh']=1;
    } */
    save("movie",$movie);
  break;
  case "selMovie":
  $id=$_POST['movie'];

  if(!empty($id)){
    //如果有帶入電影id則直接取得該部電影資料
    $first=find("movie",$id);

  }else{
  //如果沒有帶入電影id則取得$movies陣的第一筆電影資料
    $first=$movies[0];
  }
  
  //取得電影的上映日期並轉成時間序列值
  $f_ondate=strtotime($first['ondate']);

  //取得今天的日期，並轉成時間序列值
  $today=strtotime(date("Y-m-d"));

  //以回圈來顯示最多三天的上映檔期
  for($i=0;$i<3;$i++){

    //取得上映檔期的時間序列值
    $show_date=strtotime("+$i days",$f_ondate);

    //把今天的日期和上映檔期的日期做比較，大於等於今天的日期才是要顯示的日期
    if($show_date>=$today){
      echo "<option value='".date("Y-m-d",$show_date)."'>".date("m月d日 l",$show_date)."</option>";
    }
  }


  break;
  case "selDate":
  $sess=[
    6=>"14:00~16:00",
    5=>"16:00~18:00",
    4=>"18:00~20:00",
    3=>"20:00~22:00",
    2=>"22:00~24:00",
  ];
  
    $movieId=$_POST['movie'];
    $showDate=$_POST['date'];
  $movieName=find("movie",$movieId)['name'];
  //計算迴圈的開始序號
  $now=ceil((24-date("G"))/2); //取得現在時間的代表序號(1~12)
  
  //判斷時間及日期是否為今天的時間
  if($now<=6 && $showDate==date("Y-m-d")){ 
    //下午兩點後的時間則$start值為計算出來的代表序號
    $start=$now;
  }else{
    //其它時間都以6來代表
    $start=6;
  }
  //從$start值開始遞減到2顯示場次時間
  for($i=$start;$i>=2;$i--){
    //計算剩餘座位(根據選擇的電影/日期/場次來決定)
    //由訂單資料表中找出符合的資料,並加總qt欄位來計算被訂走了多個座位
    $booked=20-q("select sum(`qt`) from ord where movie='$movieName' && odate='$showDate' && sess='".$sess[$i]."'")[0][0];

    echo "<option value='".$sess[$i]."'>".$sess[$i]."　剩餘座位 $booked</option>";
  }
  break;
  case "order":
    $data=[];
    $data['movie']=$_POST['movieName'];
    $data['odate']=$_POST['date'];
    $data['sess']=$_POST['sess'];
    $data['qt']=$_POST['count'];
    $data['seat']=serialize($_POST['seats']) ;
    $ordMax=q("select max(`id`) from ord")[0][0]+1;
    $data['no']=date("Ymd").sprintf("%04d",$ordMax);
    echo $data['no'];
    save('ord',$data);
    
  break;
  case "qDel":
    //訂單快速刪除功能

    //根據type 來決定要刪除的動作
    switch($_POST['type']){
      case "1":
        //依日期來刪除
        $date=$_POST['val'];
        del('ord',['odate'=>$date]);

        //del('ord',['odate'=>$_POST['val']]);
      break;
      case "2":
        //依電影名稱來刪除
        $movie=$_POST['val'];
        del('ord',['movie'=>$movie]);
        
        //del('ord',['movie'=>$_POST['val']]);
      break;
    }
  break;
}