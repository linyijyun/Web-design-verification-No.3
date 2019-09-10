<style>
.half *{
  box-sizing:border-box;
}

.lists{
  width:200px;
  height:250px;
  margin:auto;
  position:relative;
  overflow:hidden; /*限制海報只能在這個DOM中*/
}
.controls{
  height:150px;
  width:100%;
  display:flex;
  justify-content: center;
  align-items: center;
}

.btns{
  width:320px;
  height:100px;
  display:flex;
  overflow:hidden;
}
.lbtn,.rbtn{
  width:30px;
}
.lbtn{
  width:0;
  height:50px;
  border-top:25px solid transparent;
  border-right:25px solid black;
  border-bottom:25px solid transparent;
  margin-right:10px;
  
}

.rbtn{
  width:0;
  height:50px;
  border-top:25px solid transparent;
  border-bottom:25px solid transparent;
  border-left:25px solid black;
  margin-left:10px;
}
.pos{
  text-align:center;
  border:1px solid red;
  width:200px;
  height:250px;
  position:absolute;
  display:none;
}
.pos img{
  width:100%;
}
.icon{
  width:80px;
  height:100px;
  flex-shrink:0;
  padding:10px;
  position:relative;
}
.icon img{
  width:100%;
}
.icon img:hover{
  border:1px solid white;
}

</style>
<div class="half" style="vertical-align:top;">
      <h1>預告片介紹</h1>
      <div class="rb tab" style="width:95%;">
          <ul class="lists ul-init">
            <?php
              $posters=q("select * from poster where sh='1' order by rank");
              foreach($posters as $k => $p){
                echo "<div class='pos' id='p$k' data-ani='".$p['ani']."'>";
                echo "<img src='./poster/".$p['file']."'>";
                echo "<br>".$p['name'];
                echo "</div>";
              }

            ?>
          </ul>

          <ul class="controls ul-init">
            <div class="lbtn" onclick="btnMove(1)"></div>
            <div class="btns">
            <?php
              $posters=q("select * from poster where sh='1' order by rank");
              foreach($posters as $k => $p){
                echo "<div class='icon' id='i$k'>";
                echo "<img src='./poster/".$p['file']."'>";
                echo "<br>".$p['name'];
                echo "</div>";
              }

            ?>
            </div>
            <div class="rbtn" onclick="btnMove(2)"></div>
          </ul>
      </div>
    </div>
    <script>
    let total=<?=count($posters);?>;

    let now=1;
    let slide
        slide=setInterval(showPoster,2500);

    /* let ani=<?php
        //echo find("ani",1)['ani'];
        ?>; */

    //先顯示第一張海報
    $("#p0").show();

    function showPoster(){
      //console.log(now+"id",$("#p"+now).attr("data-ani")+"ani");
      //console.log(now+"id",$("#p"+now).data("ani")+"ani");

      //取得下一張海報的動畫
      let ani=$("#p"+now).data("ani");

      //取得當前在畫面上顯示中的海報物件
      let show=$(".pos:visible")

      //取得下一張海報的物件
      let next=$("#p"+now);
      //console.log(show)
      switch(ani){
        case 1:
          //淡入淡出 動畫時間1秒(1000毫秒) 先淡出上一張(fadeOut)，再淡入下一張(fadeIn)
          $(show).fadeOut(1000,function(){
            $(next).fadeIn(1000);
          });
        break;
        case 2:
          //滑入滑出 動畫時間1秒(1000毫秒) 先滑出上一張(slideUp)，再滑入下一張(slideDown)
          $(show).slideUp(1000,function(){
            $(next).slideDown(1000);
            
          });
         
        break;
        case 3:
          //縮放 動畫時間1秒(1000毫秒) 先縮放上一張(hide)，再縮放下一張(show)
          $(show).hide(1000,function(){
            $(next).show(1000);

          });
        break;
        case 4:
          //滑入滑出2

          //先將下一張的位置定位好
          $(next).css({left:200,top:0})

          //顯示下一張
          $(next).show();

          //當前的海報進行向左移動
          $(show).animate({left:-200,top:0},function(){
            //移動結束後隱藏
            $(show).hide()
            //定位回原本的位置
            $(show).css({left:0,top:0})
          })

          //同時將下一張向左移動至指定的位置
          $(next).animate({left:0,top:0})

        break;
        case 5:
          //縮放2

          //先將下一張海報的大小及位置定好
          $(next).css({width:0,height:0,left:100,top:125})

          //當前海報進行縮小的動畫
          $(show).animate({width:0,height:0,left:100,top:125},function(){

            //動畫結束後將當前海報隱藏
            $(show).hide();

            //回復當前海報的大小及位置
            $(show).css({width:200,height:250,left:0,top:0})

            //顯示下一張海報
            $(next).show()
            
            //放大下一張海報至指定的大小及位置
            $(next).animate({width:200,height:250,left:0,top:0})
          })
        break;
        case 6:
          //翻轉

          //將下一張海報的大小及位置先定好
          $(next).css({width:0,height:250,left:100,top:0})

          //將下一張區塊內的圖片大小及位置先定好
          $(next.children("img")).css({width:0,height:220,left:100,top:0})

          //當前海報執行向中間緊縮的動畫
          $(show).animate({width:0,height:250,left:100,top:0},function(){

            //動畫結束後隱藏當前海報
            $(show).hide();

            //將當前海報恢復原本的大小及位置
            $(show).css({width:200,height:250,left:0,top:0})

            //顯示下一張海報
            $(next).show()

            //下一張海報進行向兩側擴張的動畫
            $(next).animate({width:200,height:250,left:0,top:0})
          })


          
          //同時進行當前海報及下一張海報區塊內部的圖片大小及位置變換
          $(show.children("img")).animate({width:0,height:220,left:100,top:0},function(){

            //翻轉結束後將圖片的CSS設回原值
            $(show.children("img")).css({width:"100%"})

            $(next.children("img")).animate({width:200,height:220,left:0,top:0},function(){

              //翻轉結束後將圖片的CSS設回原值
              $(next.children("img")).css({width:"100%"})
            })
          })
         
        break;
      }

      if(now<(total-1)){
        now++
      }else{
        now=0;
      }
    }

    $(".icon").on("click",function(){
      let p=$(this).attr("id").substr(1);
      now=p;

    })


    let mov=0;
    btnMove(1);
    function btnMove(x){
      switch(x){
        case 2:
          //向左移動;
          if(mov<(total-4)){
            mov++
            $(".icon").animate({right:80*mov});
          }

        break;
        case 1:
          //向右移動;
        if(mov>0){
            mov--
            $(".icon").animate({right:80*mov});
          }
        break;
      }

    /*
      不做也不會扣分,僅供參考

       if(mov==0){
        $(".lbtn").css({"border-left-color":"transparent"});
      }else if(mov==(total-4)){
        $(".rbtn").css({"border-right-color":"transparent"});
      }else{
        $(".lbtn").css({"border-right-color":"black"});
        $(".rbtn").css({"border-left-color":"black"});
      } 
    */
    }
    
/* 
    不做也不會扣分,僅供參考
    $(".btns").hover(
      function(){
        //滑鼠移入時清除輪播
        clearInterval(slide)
      },
      function(){
        //滑鼠移出時繼續輪播
        slide=setInterval(showPoster,2500);
      }
    ) */

    </script>

    <!----院線片---->
    <div class="half">
      <h1>院線片清單</h1>
      <div class="rb tab" style="width:95%;">
      <?php
        /*
          1.上映中的電影(上映日後三天)
          2.設定為顯示的電影
          3.上映日三天內的電影
          4.依順序顯示
        */
        $today=date("Y-m-d");
        $startDate=date("Y-m-d",strtotime("-2 days"));
        $all=q("select count(*) from movie where ondate>='$startDate' && ondate<='$today' && sh=1")[0][0];
        $div=4;
        $pages=ceil($all/$div);
        $now=(!empty($_GET['p']))?$_GET['p']:"1";
        $start=($now-1)*$div;
        
        $movies=q("select * from movie where ondate>='$startDate' && ondate<='$today' && sh=1 order by rank limit $start,$div");
        foreach( $movies as $m){
      ?>
        <table style="width:48%;display:inline-block;border:1px solid white;border-radius:10px;padding:5px 0">
            <tr>
            <td><img src='./movie/<?=$m['poster'];?>' style="border:2px solid white;width:60px;height:80px;cursor:pointer" onclick="lof('?do=intro&id=<?=$m['id'];?>')"></td>
            <td>
              <ul class="ul-init">
                <li><?=$m['name'];?></li>
                <li style="font-size:13px">分級：<img src="icon/03C0<?=$m['level'];?>.png" style="display:inline-block;width:20px;vertical-align:middle"><?=$lvStr[$m['level']];?></li>
                <li style="font-size:13px">上映日期：<?=$m['ondate'];?></li>
              </ul>
            </td>
            </tr>
            <tr>
              <td colspan="2">
              <button onclick="lof('?do=intro&id=<?=$m['id'];?>')">劇情簡介</button>
                <button onclick="lof('?do=order&id=<?=$m['id'];?>')">線上訂票</button>
              </td>
            </tr>
        </table>
      <?php
      }
      ?>
        <div class="ct"> 
        <?php
        //分頁編號
        for($i=1;$i<=$pages;$i++){
          echo "<a href='?p=$i' style='text-decoration:none'> $i </a>";
        }
          ?>
        
         </div>
      </div>
    </div>