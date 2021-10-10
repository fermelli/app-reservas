<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="registrahab.css">
    <title>Registrar Habitacion</title>
</head>
<body>
    <div class="container">
		<header class="superior">
		<div class="logo">
			<img src="" alt="">
		</div>
		<nav class="menu">
			<ul class="opciones">
				<li><a href="">TEXT</a></li>
				<li><a href="">TEXT</a></li>
				<li><a href="">TEXT</a></li>
				<li><a href="">TEXT</a></li>
				<li><a href="">TEXT</a></li>
			</ul>
		</nav>
		</header>
		<section class="cuerpo">
			<h1 class="titulo">HOTEL .................</h1>
            <div class="izquierda">
				<p class="abajo">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur, asperiores aut quae porro exercitationem odio, rem laboriosam quam vel incidunt expedita dolores eius in nobis impedit, adipisci fugit numquam dolorem!</p>
			</div>
			<div class="derecha">
            <h1>REGISTRAR HABITACION</h1>
            <form action="create.php" method="POST">
                <div class='field'>
                    <label>Numero</label>
                    <input name='numero' type='number' required value="numero" placeholder='Número de habitacion' autocomplete />
                </div>
                <div class='field'>
                    <label>Tipo Habitación</label>
                    <select name='tipohabitacion' required>
                        <option selected disabled>Sel. una opción</option>
                        <?php
                        include("database-init.php");
                        $tipos=$db->getRoomTypes();
                        foreach ($tipos as $tipo) {?>
                            <option value="<?=$tipo;?>"><?=ucfirst($tipo);?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class='banio'>
                    <label>¿Baño Privado?</label>
                    <div><input name='banio' type='radio' value="1" />Sí</div>
                    <div><input name='banio' type='radio' value="0"/>No</div>
                </div>
                <div class='field'>
                    <label>Precio</label>
                    <input name='precio' type='number' required placeholder='Precio de Habitación' />
                </div>
                <div class='submit'>
                    <button type="submit" name="registrar">Registrar</button>   
                </div>
            </form>

			</div>
		</section>
		<div class="pie">

		</div>
	</div>
</body>
</html>