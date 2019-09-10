//交換排序使用的函式
function sw(table,id1,id2){

  //將相關資訊傳送到api
  $.post("api.php?do=sw",{table,id1,id2},function(res){

    //api處理完後重整頁面即可以看到排序的結果
    location.reload();
  })
}

function lof(url){
  location.href=url;
}