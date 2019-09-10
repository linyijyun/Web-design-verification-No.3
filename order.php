
<?php
//判斷是否有傳入$_GET['id'],$_GET['date'],$_GET['sess']
if(!empty($_GET['id'])){
  $id=$_GET['id'];
}else{
  $id=0;
}
if(!empty($_GET['date'])){
  $getDate=$_GET['date'];
}else{
  $getDate=0;
}
if(!empty($_GET['sess'])){
  $getSess=$_GET['sess'];
}else{
  $getSess=0;
}
?>
<style>
ul li{
  margin:3px 0;
}
ul li:nth-child(even){
  background:#ccc;
  border:1px solid #999;
}
ul li:nth-child(odd){
  background:#aaa;
  border:1px solid #999;
}

</style>
<form>
  <ul class="ul-init" style="width:50%;margin:auto;background:#eee;padding:20px;border:1px solid black">
    <li>電影：<select name="movie" id="movie">
      <?php
        /*
          1.上映中的電影(上映日後三天)
          2.設定為顯示的電影
          3.上映日三天內的電影
          4.依順序顯示
        */
        $today=date("Y-m-d");
        $startDate=date("Y-m-d",strtotime("-2 days"));
        
        //$movies=q("select * from movie where ondate>='$startDate' && ondate<='$today' && sh=1 order by rank ");
        $movies=q("select * from movie where ondate between '$startDate' and '$today' && sh=1 order by rank ");
        
        foreach($movies as $m){
          $sel=($m['id']==$id)?"selected":"";
          echo "<option value='".$m['id']."' $sel>".$m['name']."</option>";
        }

    ?>
    </select>

    </li>
    <li>日期：
    <select name="date" id="date">
    <?php
    //根據是否有傳入電影ID來決定日期欄位要顯示那一部電影的檔期
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
        $sel=(date("Y-m-d",$show_date)==$getDate)?"selected":""; //判斷那個項目為被選取的狀態
        echo "<option value='".date("Y-m-d",$show_date)."' $sel>".date("m月d日 l",$show_date)."</option>";
      }
    }

    ?>
    
    </select></li>
    <li>場次：<select name="session" id="session">
    <?php
    //建立一個場次時間字串
    $sess=[
      6=>"14:00~16:00",
      5=>"16:00~18:00",
      4=>"18:00~20:00",
      3=>"20:00~22:00",
      2=>"22:00~24:00",
    ];
    
    //計算迴圈的開始序號
    $now=ceil((24-date("G"))/2); //取得現在時間的代表序號(1~12)
    if($now<=6){ 
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
      $booked=20-q("select sum(`qt`) from ord where movie='".$first['name']."' && odate='".date("Y-m-d",$today)."' && sess='".$sess[$i]."'")[0][0];
      $sel=($sess[$i]==$getSess)?"selected":"";//判斷那個項目為被選取的狀態
      echo "<option value='".$sess[$i]."' $sel>".$sess[$i]."　剩餘座位 $booked</option>";
    }
    ?>
    </select></li>
    <li>
      <input type="button" value="確定" onclick="book()">
      <input type="reset" value="重置">
    </li>
  </ul>
</form>

<script>
//先宣告全域變數
let movie,date,sess;

//先取得目前被選中的電影id
movie=$("#movie option:selected").val();
date=$("#date option:selected").val();
//當電影選單被選擇時觸發事件
$("#movie").on("change",function(){
  movie=$("#movie option:selected").val();
  console.log(movie);

  //向api傳送電影id 並取得電影的檔期資料
  $.post("api.php?do=selMovie",{movie},function(dateOption){
    console.log(dateOption)

    //將檔期資料顯示在日期的下拉選單中
    $("#date").html(dateOption)

  })
})

//當日期選單被選擇時觸發事件
$("#date").on("change",function(){
  date=$("#date option:selected").val();

  //向api傳送電影id及被選擇的日期 並取得場次的資料
  $.post("api.php?do=selDate",{movie,date},function(sessOption){
    console.log(sessOption)

    //將場次資料顯示在場次的下拉選單中
    $("#session").html(sessOption)

  })
})

//選擇完成後按下確定按鈕先執行book()函式
function book(){

  //取得場次選單的值
  sess=$("#session option:selected").val()

  //取得電影名稱
  movieName=$("#movie option:selected").text()

  //將所有選擇的資料放在URL後面當成GET的參數傳遞到book.php頁面
  lof(`?do=book&id=${movie}&movieName=${movieName}&date=${date}&sess=${sess}`)
}
</script>
