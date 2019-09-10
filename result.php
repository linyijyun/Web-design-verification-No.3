<!---利用GET帶過來的參數直接在結果頁中呈現訂單的訊息--->


<table style="width:500px;margin:auto;background:#eee;padding:20px;border:1px solid #999">
  <tr>
    <td colspan="2" style="background:#ccc;border:1px solid #999">感謝您的訂購，您的訂單編號是：<?=$_GET['no'];?><br></td>
  </tr>
  <tr>
    <td width="100px"  style="background:#aaa;border:1px solid #999">電影名稱：</td>
    <td style="border:1px solid #999"><?=$_GET['name'];?></td>
  </tr>
  <tr>
    <td style="background:#ccc;border:1px solid #999">日期：</td>
    <td style="border:1px solid #999"><?=$_GET['date'];?></td>
  </tr>
  <tr>
    <td  style="background:#aaa;border:1px solid #999">場次時間：</td>
    <td style="border:1px solid #999"><?=$_GET['sess'];?></td>
  </tr>
  <tr>
  <td colspan="2" style="border:1px solid #999">
    座位：<br>
    <?php

  //坐位的資訊會被組合成為一個以逗號分隔的字串，因此使用explode()函式來將字串轉換成陣列
  $seats=explode(",",$_GET['seats']) ;

  //排序陣列,預設是由小到大排列,如果要由大到小使用rsort()
  sort($seats);

  //以迴圈的方式列出座位的訊息
  foreach($seats as $s){
    echo ceil(($s+1)/5)."排".($s%5+1)."號<br>";
  }
  echo "共".$_GET['qt']."張電影票";

?>
  </td>
  </tr>
  <tr>
  <td colspan="2" class="ct" style="background:#ccc;border:1px solid #999">
  <button onclick="lof('?do=home')">確認</button>
  </td>
  </tr>
</table>