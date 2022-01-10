    <style>
#x {
	position: fixed;
	bottom: 0;
	width: 100%;
	background-image: url("back/colors.jpg");
}
.smiles{
    cursor: pointer;
    outline: none;
      -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none;   /* Chrome/Safari/Opera */
  -khtml-user-select: none;    /* Konqueror */
  -moz-user-select: none;      /* Firefox */
  -ms-user-select: none;       /* Internet Explorer/Edge */
  user-select: none;

}
.sm-block{

  position: relative;

  display: none;
  z-index: 0;
  /*background-image: url('back/water.jpg');*/

  margin-top: 5px;
  transition: all 2s linear;
}
.sm-block span{
    transition: all .3s linear;
  filter: grayscale(90%);
}
.sm-block span:hover{
    filter: grayscale(0%);

}
    
.vid:hover .sm-block{
    display: block;
      opacity: 0;
  visibility: 0;
}
.poster{
    transition: all 1s linear;
}

.poster:hover .sm-block{
    display:block;
}
.poster:hover p{
    display: none;
}
@keyframes disappear {
    0% {background-color: white;z-index: 999;}
    80% {background-color: white;}
    99.9% {z-index: 999}
    100% {background-color: none;z-index: -999;}
}
#headingOne{
  text-align: right;
  padding: 0;
  margin-right: 10px;

}
.card-body{
  padding: 0;
  margin-left: 10px;
  margin-right: 2px;

}
.card-body span{
  padding: 5px;
  margin-top: 2px;
  margin-bottom: 2px;
  filter: grayscale(100);
  transition: all 0.3s linear;
}
.card-body span:hover{
  
  filter: grayscale(0);
  transform: scale(2,2); 
}

    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript">
function insertTextAtCursor(el, text, offset) {
    var val = el.value, endIndex, range, doc = el.ownerDocument;
    if (typeof el.selectionStart == "number"
            && typeof el.selectionEnd == "number") {
        endIndex = el.selectionEnd;
        el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length+(offset?offset:0);
        el.focus();
    } else if (doc.selection != "undefined" && doc.selection.createRange) {
        el.focus();
        range = doc.selection.createRange();
        range.collapse(false);
        range.text = text;
        range.select();
//el.selectionEnd=1;
    }
}
    function addCITE(id){
     // var t =  document.getElementById('main').value;
      var text = $('span#mess'+id).html();
      var user = $('#user'+id).html();

      text = text.replace(/<a[^>]*>(.*?)<\/a>/g, '$1');
      text = text.replace(/<br>/, ' ');
      text = text.replace(/&lt;/g, '<');
      text = text.replace(/&gt;/g, '>');
      //console.log(text);
      var area = document.getElementById('texting');
      //var mess ='<? echo($dire); ?>/forum/message.php?id=poisk&id_mess='+id; 
      //var createADRESS ='<a href= '+ mess+'>@'+user+'</a>';
      var createADRESS = '<'+id+'>@'+user;
      var val = '"' + text+'" by ' + createADRESS;
       // Вставляем input в DOM
  //tmp.select(); // Выделяем весь текст в input
  //document.execCommand('copy'); // Магия! Копирует в буфер выделенный текст (см. команду выше)

      //var tex = convertTOhtml(text);
      //var div = document.createElement('INPUT');
      //div.nnerHTML = val;
      //var message = "&lt;strong&gt;testmessage&lt;/strong&gt";
      //document.getElementById('message').innerHTML = bericht;
      insertTextAtCursor(area,val);
    }
    function editing(id){
     // var t =  document.getElementById('main').value;
      var text = $('span#mess'+id).html();
      //var user = $('#user'+id).html();

      text = text.replace(/<a[^>]*>(.*?)<\/a>/g, '$1');
      text = text.replace(/<br>/g, ' ');
      text = text.replace(/&lt;/g, '<');
      text = text.replace(/&gt;/g, '>');
      //console.log(text);
      var area = document.getElementById('texting');
      var form = document.getElementById('forma');
      form.action="edit.php?id="+id;
      $('.but').html("<button class='btn btn-warning' type='submit'>Редактировать</button><br><button style='margin-top: 10px;' class='btn btn-danger' onclick='canceling()'>Отмена</button></form>");
      //var mess ='<?// echo($dire); ?>/forum/message.php?id=poisk&id_mess='+id; 
      //var createADRESS ='<a href= '+ mess+'>@'+user+'</a>';
      //var createADRESS = '<'+id+'>@'+user;
      //var val = '"' + text+'" by ' + createADRESS;
       // Вставляем input в DOM
  //tmp.select(); // Выделяем весь текст в input
  //document.execCommand('copy'); // Магия! Копирует в буфер выделенный текст (см. команду выше)

      //var tex = convertTOhtml(text);
      //var div = document.createElement('INPUT');
      //div.nnerHTML = val;
      //var message = "&lt;strong&gt;testmessage&lt;/strong&gt";
      //document.getElementById('message').innerHTML = bericht;
      insertTextAtCursor(area,text);
    }
    function canceling(){
      var area = document.getElementById('texting');
      area.value='';
            var form = document.getElementById('forma');
      form.action="add_mess.php";
      $('.but').html("<button class='btn btn-primary' type='submit' name='add' >Добавить</button></form>");
    }
    function addSMILE(id){
            var area = document.getElementById('texting');
            var val = $('span#smile'+id).html();
            //var val = '&#1285'+id+';';
            //insertAtCursor(area, val);
            insertTextAtCursor(area,val);
    }
function convertTOhtml(str){
  let tmp   = document.createElement('INPUT'), // Создаём новый текстовой input
      focus = document.activeElement; // Получаем ссылку на элемент в фокусе (чтобы не терять фокус)
      tmp.id = 'idName';
  tmp.value = str; // Временному input вставляем текст для копирования

  document.body.appendChild(tmp); // Вставляем input в DOM
  var text = $('#idName').html();
  console.log(text);
  tmp.select(); // Выделяем весь текст в input
  document.execCommand('copy'); // Магия! Копирует в буфер выделенный текст (см. команду выше)
  document.body.removeChild(tmp); // Удаляем временный input
  focus.focus();
  return text;
}

$('.add_text').click(function(){
    insertText('info_sms_id', $(this).val());
});
</script>
    <div class="table-responsive" id="x">
      <div id="accordion" role="tablist">
  <div class="card">
    <div class="card-header" role="tab" id="headingOne">
      
        <a id='label-smile'data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Откройте смайлы
        </a>
    </div>
    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
      <div class="card-body">
        <div>
                                    <? for ($i=13; $i < 92 ; $i++) {
                   $smile =  "&#1285".$i.";";
                   $idsmile='smile'.$i;
    echo "<span id= '$idsmile' class='smiles' onclick='addSMILE($i)'>$smile</span>";
}?>    
        </div>
      </div>
    </div>
  </div>
</div><form id="forma" action="add_mess.php" method="post">
        <table class="table">
            <tbody>
                <!--<tr>
                    <div class="poster"><p style="color: white; text-align: center; margin-bottom: 0;">Наведите для показа смайлов</p>
                    
                <div class="sm-block">
                                     <? /*for ($i=13; $i < 92 ; $i++) {
                                      $idsmile='smile'.$i;
                    $smile =  "&#1285".$i.";";
    echo "<span id= '$idsmile' class='smiles' onclick='addSMILE($i)'>$smile</span>";
}*/?>    
                </div>
                </div>
                </tr>-->
                <tr>
                    
                    <td style="width: 90%">
                    <textarea class="form-control" style="height: 103px; width: 100%"  id='texting' name="message"></textarea></td>
                    <td class="but" style="text-align: center; width: 10%;"><button class="btn btn-primary" type="submit" name="add" >Добавить</button></td>
                    
                </tr>
            </tbody>
        </table>
        </form>
    </div>
