<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Blagovest</title>
		<link href="<?php echo $this->assetsBase; ?>/css/bootstrap/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo $this->assetsBase; ?>/css/font-awesome/font-awesome.css" rel="stylesheet">
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<style type="text/css">
			@font-face{
		    font-family:  "Helios-Thin";
		    src: url(<?php echo $this->assetsBase; ?>/fonts/heliosthinc.otf);
		}
		a{
			text-decoration: none;
		}
		.container{
			width: 800px!important;
		}
		.mail{
			text-align: center;
		}
		.logo-top img{
			margin: 70px 0px 30px;
			width: 170px;
		}
		.header .fa{
			color: #eac20a;
			font-size: 9px;
			margin: 0px 23px;
		}
		.header a{
			color: #7e7d7d;
			font-size: 16px;
		}
		.header{
			height: 650px;
			background: url("<?php echo $this->assetsBase; ?>/mail/images/bg_header.jpg")no-repeat;
		}
		h1{
			font-family: "Helios-Thin";
			margin-top: 65px;
		}
		.content h4{
			color: #7e7d7d;
			margin: 40px 0px 35px;
			padding: 0px 40px 0px 40px;
    		line-height: 25px;
		}
		.content a{
			width: 228px;
			height: 82px;
			background-color: #eac20a;
			display: inline-block;
			line-height: 82px;
			color: #fff;
			text-transform: uppercase;
		}
		.footer{
			background-color: #34085d;
			margin-top: 70px;
			color: #fff;
			font-size: 16px;
			font-family: "Helios-Thin";
		}
		.footer img{
			margin: 54px 0px 35px;
		}
		.footer p{
			font-size: 16px;
			color: #8c74a4;
		}
		.footer .fa{
			font-size: 20px;
			margin-right: 10px;
			margin-left: 20px;
		}
		.social .fa{
		    font-size: 35px;
		    margin-right: 19px;
		    margin-top: 37px;
		    margin-bottom: 40px;
		}
		.social a{
			color: #9a84ae;
		}
	</style>
	<body>
		<div class="container mail">
			<div class="row header">
				<div class="col-md-12">
					<a class="logo-top" href=""><img src="<?php echo $this->assetsBase; ?>/images/mail/logo_top.png"></a><br />
					<a href="https://blago-vest.org/about-fund">о фонде</a><i class="fa fa-circle"></i>
					<a href="https://blago-vest.org/projects">проекты</a><i class="fa fa-circle"></i>
					<a href="https://blago-vest.org/contacts">контакты</a>
				</div>
			</div>
			<div class="row content">
				<div class="col-md-12">
					<h1>Название письма</h1>
					<h4>Наши интересы и цели выходят далеко за пределы Информационных Технологий. Мы делаем мир счастливее! Мы знаем, что путь к настоящему успеху, на самом деле ...</p>
				</div>
				<a href="">Назва кнопки</h4>
			</div>
			<div style="background-color: #34085d;" class="row footer">
				<div class="col-md-12">
					<a href=""><img src="images/logo_bottom.png"></a>
					<p>04300, Украина, Киев, ул. Днепровская набережная 26Ж.</p>
					<div class="phone"><i class="fa fa-phone-square"></i>+380974834318 <i class="fa fa-envelope"></i>info@blago-vest.org</div>
					<div class="social">
						<a href="http://vk.com/fundblagovest"><i class="fa fa-vk"></i></a>
						<a href="https://www.facebook.com/groups/1584264545157407/"><i class="fa fa-facebook-official"></i></a>
						<a href="https://www.youtube.com/channel/UCMyRfi5RTZryr869sXWi3WA"><i class="fa fa-youtube"></i></a>
					</div>
				</div>
			</div>
		</div>	
	</body>
</html>