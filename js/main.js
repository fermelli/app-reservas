const inputStartDate = document.getElementById('fechainicio');
const inputEndDate = document.getElementById('fechafin');

const setMinimumDate = () => {
    const now = new Date();
    let currentDay = now.getDate();
    let currentMonth = now.getMonth() + 1;
    currentMonth = currentMonth <= 9 ? `0${currentMonth}` : currentMonth;
    let currentYear = now.getFullYear();
    let minimumDate = `${currentYear}-${currentMonth}-${currentDay}`;
    inputStartDate.setAttribute('min', minimumDate);
    inputEndDate.setAttribute('min', minimumDate);
};

window.onload = function () {
    setMinimumDate();
    inputStartDate.addEventListener('input', function (event) {
        if (inputEndDate.value == '' || this.value == '') {
            inputEndDate.value = this.value;
        } else {
            if (new Date(inputEndDate.value).getTime() < new Date(this.value).getTime()) {
                inputEndDate.value = this.value;
            }
        }
        inputEndDate.setAttribute('min', this.value);
    });
}