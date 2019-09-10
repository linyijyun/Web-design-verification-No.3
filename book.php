<style>
/*設定一個座位區內的全部class都統一設定*/
.room *{
  box-sizing:border-box;
  margin:0;
  padding:0;
}

/*設定座位區內的可用空間大小*/
.room{
  width:320px;
  height:370px;
  margin:auto;
  background:url("./icon/03D04.png") no-repeat;
  padding:16px 110px 0 115px;
}

/*下方的資訊區設定*/
.info{
  box-sizing:border-box;
  width:540px;
  height:150px;
  background:#ccc;
  margin:auto;
  padding:10px 0px 10px 120px;/*上右下左*/
}

/*單一座位的css設定*/
.seat{
  width:63px;
  height:87px;
  display:inline-block;
  position:relative;
}

/*無人座位背景圖*/
.s1{
  background:url("./icon/03D02.png") no-repeat center;
}

/*有人座位背景圖*/
.s2{
  background:url("./icon/03D03.png") no-repeat center;
}

/*勾選欄位的css設定*/
.chk{
  position:absolute;
  right:5px;
  bottom:5px;
}
</style>
<?php
    //取得網址參數傳過來的各項值
    $id=$_GET['id'];
    $movieName=$_GET['movieName'];
    $date=$_GET['date'];
    $sess=$_GET['sess'];
?>

<div class="room">
<?php
  //取得所有符合電影,觀看日期,場次資料的訂單
  $ords=all("ord",['movie'=>$movieName,'odate'=>$date,'sess'=>$sess]);

  //建立一個存於座位的空陣列;
  $seats=[];

  foreach($ords as $o){

    //以迴圈的方式取出每一筆訂單的座位,並將陣列合併
    $seats=array_merge($seats,unserialize($o['seat']));
  }


  //以迴圈的方式畫出20個座位的html碼
  for($i=0;$i<20;$i++){

    //判斷目前要畫的座位是否己經被訂走了
    //分別以class s1/s2來代表己經訂走及尚未訂走的狀態
    if(in_array($i,$seats)){
      echo "<div class='s2 seat'>";
    }else{
      echo "<div class='s1 seat'>";

    }

    //計算並顯示座位訊息
    echo ceil(($i+1)/5)."排".($i%5+1)."號";

    //判斷是否需要顯示勾選欄位
    if(!in_array($i,$seats)){
      echo "<input type='checkbox' name='no' id='no$i' class='chk' value='$i'>";
    }
    echo "</div>";
  }


?>

</div>
<div class="info">
 您選擇的電影是：<?=$movieName;?><br>
 您選擇的時刻是：<?=$date;?> <?=$sess;?><br>
 您己經勾選<span id='ticket'></span>張票，最多可以購買四張票
 <div>
  <!--將電影選擇的相關訊息放url參數中，按下上一步時可以直接把參數帶回電影選擇頁-->
  <button onclick="lof('?do=order&id=<?=$id;?>&date=<?=$date;?>&sess=<?=$sess;?>')">上一步</button>

  <!--劃位完成時，按下按鈕執行checkout()函式-->
  <button onclick="checkout()">訂購</button>
 </div>
</div>
<script>
//建立一個全域的陣列變數用來存放選擇的座位
let seats=new Array;

//建立一個變數來統計座位數的變化
let count=0;

//建立checkbox的onchange事件
$(".chk").on("change",function(){

  //取得點選時的checkbox的值
  let val=$(this).val();

  //取得鈎選狀態的值,勾選->true ,未勾選->false
  let status=$(this).prop("checked");
  //console.log(val+"被勾選了"+status)

  //根據勾選的狀態來決定要進行的動作
  if(status==true){
    //如果是勾選的狀態,則計數加1
    count++;
    
    //判斷計數是否超過4,如果超過4則減1並將勾選狀態取消
    if(count>4){
      console.log("超過四張了")
      count--;
      $(this).prop("checked",false)

    }else{
      //如果計數未超過4,則將座位值寫入陣列seats中
      seats.push(val)

      /* 
        即時改變座位class的做法，可以即時看到座位背景圖變化
          let str=$(this).parent(".seat").attr("class").replace("s1","s2")
          $(this).parent(".seat").attr("class",str) */

    
    }
  }else{

    //如果取消勾選則計數減1並將座位資料從陣列中刪除
    count--;
    
    //console.log("索引位置"+seats.indexOf(val))

    seats.splice(seats.indexOf(val),1)
    
    /*    
      即時改變座位class的做法，可以即時看到座位背景圖變化
        let str=$(this).parent(".seat").attr("class").replace("s2","s1")
        $(this).parent(".seat").attr("class",str) */

  }
  //console.log(count,seats);

  //在資訊區即時顯示勾選後的張數
  $("#ticket").text(count);
})

//劃位完畢後要執行的函式
function checkout(){

  //取得需要傳遞到結果頁的資訊
  let movieName="<?=$_GET['movieName'];?>";
  let date="<?=$_GET['date'];?>";
  let sess="<?=$_GET['sess'];?>";

  //先以ajax的方式將訂單資訊傳送到api中去儲存到資料庫
  $.post("api.php?do=order",{movieName,date,sess,seats,count},function(no){
    console.log(no)
    //api在儲存完訂單後會回傳一個訂單編號到前端來
    //將訂單編號及結果頁需要顯示的資訊都放在url參數中傳遞到結果頁中
    lof(`?do=result&name=${movieName}&date=${date}&sess=${sess}&no=${no}&seats=${seats}&qt=${count}`);
  })

}

</script>