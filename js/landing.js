window.onload = function () {
    const starRadios = document.querySelectorAll('.star__radio');

    starRadios.forEach((inputRadio, index, inputs) => {
        inputRadio.addEventListener('input', function (event) {
            for (let i = 0; i < inputs.length; i++) {
                const element = inputs[i];
                if (i <= index) {
                    element.nextElementSibling.classList.add(
                        'star__icon--fill'
                    );
                } else {
                    element.nextElementSibling.classList.remove(
                        'star__icon--fill'
                    );
                }
            }
        });
    });

    document
        .getElementById('btn-reset')
        .addEventListener('click', function (event) {
            starRadios.forEach((inputRadio) => {
                inputRadio.nextElementSibling.classList.remove(
                    'star__icon--fill'
                );
            });
        });
};
