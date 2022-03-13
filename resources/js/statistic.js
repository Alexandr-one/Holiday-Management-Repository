$(document).ready(function() {
    let data = $('#groupData');
    data = JSON.parse(data[0].innerText);
    let max_days = document.querySelector('.max_days').value;
    Object.keys(data).forEach(item => {
        let countDays = 0;
        data[item].forEach(object => {
            countDays += object.number_of_days
        })
        var ctx = $(`#chart-line-${item}`);
        var myLineChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ["Использованно", "Не использованно"],
                datasets: [{
                    data: [countDays, max_days - countDays],
                    backgroundColor: ["rgba(255, 0, 0, 0.5)", "rgba(100, 255, 0, 0.5)"]
                }]
            },
            options: {
                title: {
                    display: true,
                    text: `Учет статистики за ${item} год`
                }
            }
        });
    })
});
