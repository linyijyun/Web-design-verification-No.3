<style>
/*ul-head標題,ul-body列表內容的基本css設定*/
.uh,.ub{
  display:flex;
  width:100%;
  align-items:center;
 
}

/*標題欄位的css設定*/
.uh li{
  width:14.28%;
  text-align:center;
  margin:0 1px;
  background:#999;
}

/*標題欄位最後一欄的css設定*/
/* .uh li:nth-last-child(1){
  width:27%;
} */

/*列表區的高度設定,並設為有滾軸*/
.list{
  height:350px;
  overflow:auto;
}

/*列表內的欄位設定*/
.ub li{
  width:25%;
  text-align:center;

  color:white;
}

</style>
<h4 class="title">預告片清單</h4>
快速刪除：
<input type="radio" name="type" value="1" checked>依日期<input type="text" name="date" id="date">
<input type="radio" name="type" value="2">依電影
<select name="movie" id="movie">
<?php
$movies=q("select movie from ord group by movie");
foreach ($movies as $key => $value) {
  echo "<option value='".$value['movie']."'>".$value['movie']."</option>";
}
?>
</select>
<button onclick="qDel()">刪除</button>

<ul class="ul-init ct uh">
  <li>訂單編號</li>
  <li>電影名稱</li>
  <li>日期</li>
  <li>場次時間</li>
  <li>訂購數量</li>
  <li>訂購位置</li>
  <li>操作</li>
</ul>
<div class="list">
<?php
$ords=q("select * from ord order by no desc");
foreach ($ords as $k => $o) {

?>

<ul class="ul-init ct ub">
  <li><?=$o['no'];?></li>
  <li><?=$o['movie'];?></li>
  <li><?=$o['odate'];?></li>
  <li><?=$o['sess'];?></li>
  <li><?=$o['qt'];?></li>
  <li>
    <?php
      $seats=unserialize($o['seat']) ;

      //排序陣列,預設是由小到大排列,如果要由大到小使用rsort()
      sort($seats);
    
      //以迴圈的方式列出座位的訊息
      foreach($seats as $s){
        echo ceil(($s+1)/5)."排".($s%5+1)."號<br>";
      }
    
    ?>
  </li>
  <li><button onclick="del('ord',<?=$o['id'];?>)">刪除</button></li>
</ul>
<hr>
<?php
 
}
?>
</div>
<script>

//快速刪除函式
function qDel(){

  //取得要選擇的刪除方式值
  let type=$("input[name='type']:checked").val();

  //console.log(type)

  //一宣告兩個變數，一個用來存放日期或電影名稱，一個用來檢查是否真的要刪除
  let val="";
  let chk;
  //以switch case的方式來根據不同的值進行不同的刪除動作
  switch(type){
    case "1":
      //console.log("依日期刪除")
      //取得日期欄位的值
      val=$("#date").val()

      //彈出確認視窗
      chk=confirm("你確定要刪除"+val+"的全部資料嗎?")
      console.log(chk)
    break;
    case "2":
      //console.log("依電影刪除")

      //取得電影名稱
      val=$("#movie").val()

      //彈出確認視窗
      chk=confirm("你確定要刪除"+val+"的全部資料嗎?")
      console.log(chk)
    break;
  }
if(chk==true){

  //如果使用者點擊"確認"按鈕,則將要刪除的資料送到API去處理,並重整頁面
  $.post("api.php?do=qDel",{type,val},function(){
    location.reload();
  })
}

}
//刪除資料的函式
function del(table,id){
  //以ajax的方式告知API要刪除那一張資料表的那一筆資料
  $.post("api.php?do=del",{table,id},function(){

    //直接重整頁面來觀看刪除後的結果
    location.reload();
  })
}

</script>