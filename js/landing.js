window.onload = function () {
	const starRadios = document.querySelectorAll('.star__radio');
	const errors = document.getElementById('form-comment__errors');

	const getComments = () => {
		fetch('./../obtenercomentarios.php', {
			headers: {
				'Content-Type': 'application/json',
			},
		})
			.then((response) => response.json())
			.catch((error) => console.error(error))
			.then(({ data }) => {
				const containerCards = document.getElementById(
					'card-comment-container',
				);
				containerCards.innerHTML = '';
				if (data.length) {
					containerCards.innerHTML = `<small>Últimos ${data.length} comentarios</small>`;
					data.forEach((comment) => {
						let cardComment = `
                        <div class="card-comment">
                            <div class="card-comment__head">
                                <h4 class="card-comment__full-name">${comment.nombre_completo}</h4>
                                <span class="card_comment__rating">${comment.valuacion}/5</span>
                            </div>
                            <p class="card-comment__text">
                                ${comment.texto}
                            </p>
                        </div>`;
						containerCards.innerHTML += cardComment;
					});
				} else {
					containerCards.innerHTML = '<p>No hay comentarios</p>';
				}
			});
	};

	const removeStars = () => {
		starRadios.forEach((inputRadio) => {
			inputRadio.nextElementSibling.classList.remove('star__icon--fill');
		});
	};

	starRadios.forEach((inputRadio, index, inputs) => {
		inputRadio.addEventListener('input', function (event) {
			for (let i = 0; i < inputs.length; i++) {
				const element = inputs[i];
				if (i <= index) {
					element.nextElementSibling.classList.add(
						'star__icon--fill',
					);
				} else {
					element.nextElementSibling.classList.remove(
						'star__icon--fill',
					);
				}
			}
		});
	});

	document
		.getElementById('btn-reset')
		.addEventListener('click', function (event) {
			removeStars();
		});

	document
		.getElementById('form-comment')
		.addEventListener('submit', function (event) {
			event.preventDefault();
			if (this.checkValidity()) {
				let nombreCompleto = this.nombrecompleto.value;
				let inputValuacion = Array.from(
					document.querySelectorAll('[id*=valuacion]'),
				).find((inputRadio) => {
					return inputRadio.checked;
				});
				let valuacion = inputValuacion ? inputValuacion.value : 0;
				let texto = this.texto.value;
				let codigoCaptcha = this.codigocaptcha.value;

				const data = `nombrecompleto=${nombreCompleto}&valuacion=${valuacion}&texto=${texto}&codigocaptcha=${codigoCaptcha}`;

				fetch('./../registrarcomentario.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: data,
				})
					.then((response) => response.json())
					.catch((error) => console.log(error))
					.then((data) => {
						if (data.success) {
							console.log(data);
							removeStars();
							this.reset();
							document.getElementById('captcha').src =
								'./../securimage/securimage_show.php?' +
								Math.random();
							getComments();
						} else {
							errors.innerHTML =
								"<h4 class='title-error'>Errores</h4>";
							data.errors.forEach((error) => {
								const p = document.createElement('p');
								p.textContent = error;
								p.classList.add('text-error');
								errors.append(p);
							});
						}
					});
			}
		});

	document
		.getElementById('form-comment')
		.addEventListener('reset', function (event) {
			errors.innerHTML = '';
		});

	getComments();
};
