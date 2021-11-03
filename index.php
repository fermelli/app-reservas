<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Good Room: Encuentra tu habitación ideal</title>
	<link rel="stylesheet" href="./css/estilos.css" />
</head>

<body>
	<div class="notice">
		<div class="container font-12">
			ACTUALIZACIÓN COVID -19: CONOCE MÁS ACERCA DE NUESTRAS MEDIDAS
			DE BIOSEGURIDAD
		</div>
	</div>
	<?php
	$enlaceActivo = null;
	require_once "./commons/header.php";
	?>
	<div id="banner">
		<div class="banner__content container">
			<span>Simplemente delicioso</span>
			<p>Con diseños frescos, servicios de calidad y hospitalidad genuina, Good Room ofrece la comodidad que necesita para una estadía inolvidable.</p>
		</div>
	</div>
	<main class="container">
		<section class="section">
			<h1 class="landing__title">Bienvenidos a Good Room Hotel</h1>
			<p class="landing__leyend">Un hotel donde la tradición se encuentra con la modernidad
			</p>
			<div class="grid">
				<p class="landing__paragraph">
					Good Room Hotel ofrece 20 años de experiencia en comodidad y servicios personalizados para todos nuestros clientes. Ubicado en el centro de negocios de la ciudad, somos un oasis de 5 estrellas en Sucre con una exuberante vegetación, una piscina única y una exquisita experiencia gastronómica en La Terraza, Piegari o Jardín de Asia; nuestros tres encantadores restaurantes dentro del Hotel. Estamos completamente preparados para albergar el mayor de sus eventos en nuestro Centro de Convenciones e invitamos a viajeros de negocios, grupos y familias a formar parte de la experiencia en Good Room y sienta la diferencia.
				</p>
				<img class="landing__image" src="./images/hall.jpg" alt="Good Room">
			</div>
		</section>
		<section class="section">
			<h2 class="section__title">Diseñado para ti</h2>
			<div class="container-card-services">
				<div class="card-service">
					<img class="card-service__image" src="./images/flexible.webp">
					<h3 class="card-service__title">Opciones gastronómicas flexibles</h3>
					<p class="card-service__content">Con restaurantes y bares en cada lugar, Good Room le ofrece una variedad de cocinas, bebidas y lugares de fácil acceso. Para adaptarse a su apretada agenda, ofrecemos opciones de servicio a la habitación, comida para llevar o servicio a la habitación.</p>
				</div>
				<div class="card-service">
					<img class="card-service__image" src="./images/restfull.webp">
					<h3 class="card-service__title">Sueño reparador</h3>
					<p class="card-service__content">Después de un día de reuniones o un largo viaje en avión, nuestros colchones de felpa, ropa de cama de calidad y una selección de almohadas le permiten experimentar la gran noche de sueño que tanto anhela. Despiértese renovado y listo para el itinerario del día siguiente.</p>
				</div>
				<div class="card-service">
					<img class="card-service__image" src="./images/plugged.webp">
					<h3 class="card-service__title">Mantente conectado</h3>
					<p class="card-service__content">Durante sus viajes, puede mantenerse conectado con las personas que más le importan utilizando nuestro Wi-Fi gratuito. Ya sea para tocar la base de la oficina o ponerse al día con la familia, lo tenemos cubierto.</p>
				</div>
			</div>
		</section>
		<section class="section">
			<h2 class="section__title">Manténgase al día con nuestros últimos desarrollos</h2>
			<div class="container-card-products">
				<div class="card-product">
					<img class="card-product__image" src="./images/hotels.webp">
					<div class="card-product__container">
						<h3 class="card-product__title">Nuevas habitaciones</h3>
						<p class="card-product__content">¿Siente la necesidad de reservar una escapada emocionante? Nuestras últimas inauguraciones le ofrecen nuevos experiencias para explorar, además de todas las comodidades de la experiencia Good Room.</p>
						<div class="card-product__actions">
							<a class="btn-link btn-link--outline" href="./listarhabitaciones.php">Buscar</a>
						</div>
					</div>
				</div>
				<div class="card-product">
					<div class="card-product__container">
						<h3 class="card-product__title">Garantía de la mejor tarifa en línea</h3>
						<p class="card-product__content">Consulte nuestras ofertas en línea para que su próximo viaje de negocios o personal sea más asequible. Los miembros de Good Room Americas también disfrutan de ofertas especiales y ventajas.</p>
						<div class="card-product__actions">
							<a class="btn-link btn-link--outline" href="./promociones.php">Promociones</a>
						</div>
					</div>
					<img class="card-product__image" src="./images/promo.webp">
				</div>
			</div>
		</section>
	</main>
	<footer class="footer">
		<div class="foot">
			<ul class="footer__list">
				<h4 class="footer__list-title">Enlaces rápidos</h4>
				<li class="footer__list-item"><a class="footer__link" href="#">Garantía de la mejor tarifa en línea</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Actualización COVID-19</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Descarga nuestra aplicación móvil</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Hoteles nuevos y próximos</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Hoteles aprobados para deportes</a></li>
			</ul>
			<ul class="footer__list">
				<h4 class="footer__list-title">Profesionales de viajes</h4>
				<li class="footer__list-item"><a class="footer__link" href="#">Socios</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Agentes de viajes</a></li>
			</ul>
			<ul class="footer__list">
				<h4 class="footer__list-title">Corporativo</h4>
				<li class="footer__list-item"><a class="footer__link" href="#">Carrera</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Oportunidades de desarrollo</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Salud y Seguridad</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Noticias y medios</a></li>
			</ul>
			<ul class="footer__list">
				<h4 class="footer__list-title">Legal</h4>
				<li class="footer__list-item"><a class="footer__link" href="#">Política de publicidad y cookies</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Accesibilidad digita</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Ley de derechos de autor del milenio digital</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Política de privacidad</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Términos y condiciones de Good Room Americas</a></li>
				<li class="footer__list-item"><a class="footer__link" href="#">Acuerdo de uso del siti</a></li>
			</ul>
		</div>
		<div class="rights-reserved">
			© <strong>2021 Good Room.</strong> Todos los derechos reservados.
		</div>
	</footer>
</body>

</html>