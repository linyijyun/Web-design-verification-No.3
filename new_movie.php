<style>
table{
  width:80%;
  margin:auto;
}
.ul-init input[type='text']{
  width:350px;
}

</style>


<h4 class="title">新增院線片</h3>
<form action="api.php?do=newMovie" method="post" enctype="multipart/form-data">
  <table>
    <tr>
      <td style="vertical-align:top">影片資料</td>
      <td>
        <ul class="ul-init">
          <li>片　　名：<input type="text" name="name" value=""></li>
          <li>分　　級：
            <select name="level" id="">
              <option value="1">普遍級</option>
              <option value="2">保護級</option>
              <option value="3">輔導級</option>
              <option value="4">限制級</option>
            </select>

          </li>
          <li>片　　長：<input type="text" name="length" value=""></li>
          <li>上映日期：
            <select name="year">
              <option value="<?=date("Y");?>"><?=date("Y");?></option>
            </select>年
            <select name="month">
              <?php
                  for($i=1;$i<=12;$i++)
                  echo "<option value='$i'>$i</option>"
              ?>
              
            </select>月
            <select name="day">
            <?php
                  for($i=1;$i<=31;$i++)
                  echo "<option value='$i'>$i</option>"
              ?>
            </select>日          
          </li>
          <li>發 行 商：<input type="text" name="publish" value=""></li>
          <li>導　　演：<input type="text" name="director" value=""></li>
          <li>預告影片：<input type="file" name="trailer" value=""></li>
          <li>電影海報：<input type="file" name="poster" value=""></li>
        </ul>
  
      </td>
    </tr>
    <tr>
      <td style="vertical-align:top">劇情簡介</td>
      <td><textarea name="intro"  style="width:350px;height:50px;"></textarea></td>
    </tr>
  </table>
  <hr>
  <div class="ct"><input type="submit" value="新增"><input type="reset" value="重置"></div>
</form>