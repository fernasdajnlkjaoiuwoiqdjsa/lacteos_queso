<!doctype html>
<html lang="es">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Comentarios</title>
    <link  rel="icon"   href="../../css/vacaputa.png" type="image/png" />
    <link href="../../vendor/emoji-picker/lib/css/emoji.css" rel="stylesheet">
    <script src="../../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../../vendor/emoji-picker/lib/js/config.js"></script>
    <script src="../../vendor/emoji-picker/lib/js/util.js"></script>
    <script src="../../vendor/emoji-picker/lib/js/jquery.emojiarea.js"></script>
    <script src="../../vendor/emoji-picker/lib/js/emoji-picker.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="../../dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="../../dist/css/bootstrap-grid.css" rel="stylesheet">
	<link href="../../dist/css/bootstrap-reboot.css" rel="stylesheet">
	<link href="../../dist/css/bootstrap-reboot.min.css" rel="stylesheet">
	<link href="../../dist/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
	<link href="../../assets/style.css" rel="stylesheet">
	<link href="../../css/style.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<link href="../../css/style copy.css" rel="stylesheet">
    </head>

<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
            <a class="nav-link active" aria-current="page" href="#">
                <img src="../../css/titulo-removebg-preview.png" alt="" width="60" height="60" class="container-fluid">
            </a>
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="views/publico/inicio.html"><i
                                    class="bi bi-house-door">Inicio</i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="views/publico/index.html"><i
                                    class="bi bi-people-fill">Catalogo de Productos</i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="views/publico/nosotros.html"><i
                                    class="bi bi-people-fill">Acerca de
                                    Nosotros</i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="views/publico/carrito.html"><i
                                    class="bi bi-people-fill">Carrito</i></a>
                        </li> 
                        <li class="nav-item">
                              <a class="nav-link" aria-current="page" href="comentarios.php"><i class="bi bi-chat-dots"></i>comentarios</i></a>
                          </li> 
                    </ul>
                </div>
            </div>
        </nav>
	

<!-- Begin page content -->

<div class="container">
      <h3 class="mt-5"><center>Comentarios de Clientes</center></h3>
      <hr>
      <div class="row">
    <div class="col-12 col-md-12"> 
          <!-- Contenido -->

<div class="output-container">
<div class="comment-form-container">
<form id="frm-comment">
<div class="input-row">
    <input type="hidden" name="comment_id" id="commentId" placeholder="Name" /> 
    <input class="form-control" type="text" name="name" id="name" placeholder="Nombres" />
</div>

<div class="input-row">
    <p class="emoji-picker-container">
      <textarea class="input-field" data-emojiable="true" data-emoji-input="unicode" type="text" name="comment" id="comment" placeholder="Agrege su mensaje"></textarea>
    </p>
</div>

<div>
    <input type="button" class="btn btn-primary" id="submitButton" value="Agregar Comentario" />
    <div id="comment-message">Comentario creado con éxito!</div>
</div>


</form>
</div><div id="output"></div>

</div>
<script>

function postReply(commentId) {
	$('#commentId').val(commentId);
	$("#name").focus();
}

$("#submitButton").click(function () {
	$("#comment-message").css('display', 'none');
	var str = $("#frm-comment").serialize();

	$.ajax({
		url: "AgregarComentario.php",
		data: str,
		type: 'post',
		success: function (response)
		{
			$("#comment-message").css('display', 'inline-block');
			$("#name").val("");
			$("#comment").val("");
			$("#commentId").val("");
			listComment();
		}
	});
});

$(document).ready(function () {
	listComment();
});

$(function () {
	// Initializes and creates emoji set from sprite sheet
	window.emojiPicker = new EmojiPicker({
		emojiable_selector: '[data-emojiable=true]',
		assetsPath: '../../vendor/emoji-picker/lib/img/',
		popupButtonClasses: 'icon-smile'
	});

	window.emojiPicker.discover();
});


function listComment() {
$.post("ListaComentario.php",
function (data) {
	var data = JSON.parse(data);

	var comments = "";
	var replies = "";
	var item = "";
	var parent = -1;
	var results = new Array();

	var list = $("<ul class='outer-comment'>");
	var item = $("<li>").html(comments);

	for (var i = 0; (i < data.length); i++)
	{
		var commentId = data[i]['co_id'];
		parent = data[i]['parent_id'];

		if (parent == "0")
		{
			comments =  "<div class='comment-row'>"+
			"<div class='comment-info'><img src='../../css/user.png'><span class='posted-by'>" + data[i]['comentario_nombre'].toUpperCase() + "</span></div>" + 
			"<div class='comment-text'>" + data[i]['comentarios'] + "</div>"+
			"<div><a class='btn-reply' onClick='postReply(" + commentId + ")'>Respuesta</a></div>"+
			"</div>";
			var item = $("<li>").html(comments);
			list.append(item);
			var reply_list = $('<ul>');
			item.append(reply_list);
			listReplies(commentId, data, reply_list);
		}
	}
	$("#output").html(list);
});
}

function listReplies(commentId, data, list) {

	for (var i = 0; (i < data.length); i++)
	{
		if (commentId == data[i].parent_id)
		{
			var comments = "<div class='comment-row'>"+
			" <div class='comment-info'><img src='../css/user.png'><span class='posted-by'>" + data[i]['comentario_nombre'].toUpperCase() + " </span></div>" + 
			"<div class='comment-text'>" + data[i]['comentarios'] + "</div>"+
			"<div><a class='btn-reply' onClick='postReply(" + data[i]['co_id'] + ")'>Respuesta</a></div>"+
			"</div>";
			var item = $("<li>").html(comments);
			var reply_list = $('<ul>');
			list.append(item);
			item.append(reply_list);
			listReplies(data[i].co_id, data, reply_list);

		}
	}
}
</script>


          <!-- Fin Contenido --> 
        </div>
  </div>
      <!-- Fin row --> 
      
    </div>
<!-- Fin container -->
<footer>
            <div class="footer-content">
                  <center>
                        <h3>Lacteos Doña Queso</h3>
                  </center>
                  <p>Este año empezamos con la distrubucion de los mejores lacteos en toda ciudad ya que son productos
                        100%
                        natural</p>
                  <ul class="socials">
                        <li><a href="https://www.facebook.com/profile.php?id=61557180795985&mibextid=ZbWKwL"><i
                                          class="bi bi-facebook"></i></a></li>
                        <li><a href="#"><i class="bi bi-twitter"></i></a></li>
                        <li><a href="https://chat.whatsapp.com/Ja1XaBabc690ruCBIbzXcf"><i class="bi bi-whatsapp"></i></a></li>
                        <li><a href="https://www.instagram.com/papiriki22?igsh=eDJieml6MTIyeGNj"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com/@teclas568?_t=8krtubotSgX&_r=1"><i class="bi bi-tiktok"></i></a></li>
                  </ul>
            </div>
            <div class="footer-bottom">
                  <p style="font-family: Arial;">copyright &copy;2024 Lacteos Doña Queso. designed by
                        <span>Quesos</span>
                  </p>
            </div>
      </footer>
<!-- Bootstrap core JavaScript--> 
<script src="../../dist/js/bootstrap.min.js"></script> 
</body>
</html>