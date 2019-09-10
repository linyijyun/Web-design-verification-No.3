<button onclick="lof('?do=newMovie')">新增電影</button>
<hr>
<div style="width:100%;height:400px;overflow:auto;">
<?php
//取出所有的電影資料並排序
$movies=q("select * from movie order by rank");;
foreach ($movies as $k => $m) {
  //依序將資料寫入相應的位置
?>
<table style="width:98%;margin:3px auto;background:white;padding:2px;color:black">
  <tr>
    <td><img src="./movie/<?=$m['poster'];?>" style="width:80px;height:120px;"></td>
    <td>分級:<img src="./icon/03C0<?=$m['level'];?>.png" style="width:25px;height:25px;vertical-align:middle"></td>
    <td>
      <ul class="ul-init">
        <li>
          片名:<?=$m['name'];?>
          片長:<?=$m['length'];?>
          上映時間: <?=$m['ondate'];?>
        </li>
        <li>
          <!---每個功能按鈕都有相應的js函式，並寫入相應的參數--->
          <button id="sh<?=$m['id'];?>" onclick="show(<?=$m['id'];?>)"><?=($m['sh']==1)?"顯示":"隱藏";?></button>
          <!---在交換排序的按鈕功能中寫入需要交換的電影id---->
          <button onclick="sw('movie',<?=$m['id'];?>,<?=(($k-1)>=0)?$movies[$k-1]['id']:$m['id'];?>)">往上</button>
          <button onclick="sw('movie',<?=$m['id'];?>,<?=(($k+1)<=(count($movies)-1))?$movies[$k+1]['id']:$m['id'];?>)">往下</button>
          <button onclick="lof('?do=editMovie&id=<?=$m['id'];?>')">編輯電影</button>
          <button onclick="del('movie',<?=$m['id'];?>)">刪除電影</button>
        </li>
        <li><?=$m['intro'];?></li>
      </ul>
    </td>
  </tr>
</table>
<?php
}
?>
</div>
<script>

//顯示與隱藏電影的函式
function show(id){
  //以ajax的方式向api請求更改電影的顯示/隱藏
  $.post("api.php?do=show",{id},function(){

    //方法一:直接重整頁面，此時php會去向資料庫更新資料，因此可以看到更新後的顯示狀態
    location.reload();

    /*
    方法二:利用jQuery來操作DOM，讓按鈕即時切換顯示或隱藏的狀態
     $str=$("#sh"+id).text();
    if($str=="隱藏"){
      $("#sh"+id).text("顯示");
    }else{
      $("#sh"+id).text("隱藏");
    } */
  })

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