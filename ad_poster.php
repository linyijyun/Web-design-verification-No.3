<style>
/*ul-head標題,ul-body列表內容的基本css設定*/
.uh,.ub{
  display:flex;
  width:100%;
 
}

/*標題欄位的css設定*/
.uh li{
  width:25%;
  text-align:center;
  margin:0 1px;
  background:#999;
}

/*標題欄位最後一欄的css設定*/
.uh li:nth-last-child(1){
  width:27%;
}

/*列表區的高度設定,並設為有滾軸*/
.list{
  height:200px;
  overflow:auto;
}

/*列表內的欄位設定*/
.ub li{
  width:25%;
  text-align:center;
  background:#fff;
  color:black;
}

</style>
<h4 class="title">預告片清單</h3>

<ul class="ul-init uh">
  <li>預告片海報</li>
  <li>預告片片名</li>
  <li>預告片排序</li>
  <li>操作</li>
</ul>
<form action="api.php?do=editPoster" method="post">
<div class="list">
<?php
//取出所有的海報資料並排序
$pos=q("select * from poster order by rank");
foreach($pos as $k => $p){
  //以迴圈方式逐一將資料寫入相應的位置
?>
<ul class="ul-init ub">
  <li><img src='./poster/<?=$p['file'];?>' style="width:60px;height:80px;"></li>
  <li><input type="text" name="name[]" value="<?=$p['name'];?>"></li>
  <li>
    <input type="button" value="往上" onclick="sw('poster',<?=$p['id'];?>,<?=(($k-1)>=0)?$pos[$k-1]['id']:$p['id'];?>)">
    <input type="button" value="往下" onclick="sw('poster',<?=$p['id'];?>,<?=(($k+1)<=(count($pos)-1))?$pos[$k+1]['id']:$p['id'];?>)">
  </li>
  <li>
    <input type="checkbox" name="sh[]" value="<?=$p['id'];?>" <?=($p['sh']==1)?"checked":"";?>>顯示
    <input type="checkbox" name="del[]" value="<?=$p['id'];?>"> 刪除  
    <select name="ani[]">
      <option value="1" <?=($p['ani']==1)?"selected":"";?>>淡入淡出</option>
      <option value="2" <?=($p['ani']==2)?"selected":"";?>>滑入滑出</option>
      <option value="3" <?=($p['ani']==3)?"selected":"";?>>縮放</option>
    </select>
    <input type="hidden" name="id[]" value="<?=$p['id'];?>">
  </li>
</ul>
<?php
}
?>
</div>
<div class="ct"><input type="submit" value="編輯確定"><input type="reset" value="重置"></div>
</form>



<hr>
<h4 class="title">新增預告片海報</h3>
<form action="api.php?do=newPoster" method="post" enctype="multipart/form-data">
<table>
  <tr>
    <td class="ct">
      預告片海報：<input type="file" name="file">
    </td>
    <td class="ct">
      預告片片名：<input type="text" name="name">
    </td>
  </tr>
</table>
<div class="ct">
  <input type="submit" value="新增">
  <input type="reset" value="重置">
</div>
</form>
