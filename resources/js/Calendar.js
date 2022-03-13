const cal = document.getElementById('calendar');
const hdr = '<div>пн</div><div>вт</div><div>ср</div><div>чт</div><div>пт</div><div>сб</div><div>вс</div>';
const getTitle = (d, y) => `<div class="title">${d + 1 + '.' + y}</div>`;
let first_date = '';
let sec_date = '';
let id = document.querySelector('.user_id').value;
$.ajax({
    url: 'http://localhost:8000/api/application/',
    type: "GET",
    data: {user_id: id},
    success: function (data) {
        first_date = data[0][0]['date_start'];
        sec_date = data[1][data[1].length - 1]['date_finish'];
        let dStart = new Date(`${first_date}`);
        let dEnd = new Date(`${sec_date}`);
        let ds = new Date(dStart);
        let de = new Date(dEnd);
        ds.setDate(1);
        de.setMonth(dEnd.getMonth() + 1, 1);
        de.setHours(0, 0, 0, 0);
        let date = [];
        let eMonth = null;
        for (let i = 0; i < data[0].length; i++) {
            date.push([data[0][i]['date_start'], data[0][i]['date_finish'], data[0][i]['status']]);
        }
        while (ds < de) {
            let day = ds.getDate();
            let dayOfWeek = ds.getDay() == 0 ? 7 : ds.getDay();
            let dayDiv = document.createElement('div');

            if (day == 1) {
                cal.appendChild(eMonth = document.createElement('div'));
                eMonth.innerHTML = getTitle(ds.getMonth(), ds.getFullYear()) + hdr;
                dayDiv.style.gridColumn = dayOfWeek;
            }
            for (let i = 0; i < date.length; i++) {
                let dateStart = new Date(`${date[i][0]}`);
                let dateFinish = new Date(`${date[i][1]}`);
                let status = date[i][2];
                dayDiv.innerText = day;
                if (ds >= dateStart && ds <= dateFinish) {
                    if (status == 'CONFIRMED') {
                        if (dayDiv.style.background == 'green') {
                            dayDiv.style.background = 'green'
                        } else if (dayDiv.style.background == 'red') {
                            dayDiv.style.background = 'linear-gradient(green 50%, red 50%)'
                        } else if (dayDiv.style.background == 'orange') {
                            dayDiv.style.background = 'linear-gradient(green 50%, orange 50%)';
                        } else if (dayDiv.style.background == 'linear-gradient(green 50%, red 50%)') {
                            dayDiv.style.background = 'linear-gradient(green 50%, red 50%)'
                        } else if (dayDiv.style.background == 'linear-gradient(green 50%, orange 50%)') {
                            dayDiv.style.background = 'linear-gradient(green 50%, orange 50%)'
                        } else if (dayDiv.style.background == 'linear-gradient(red 50%, orange 50%)') {
                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                        } else if (dayDiv.style.background == 'linear-gradient(red 25%, green 50%, orange 80%)') {
                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                        } else {
                            dayDiv.style.background = 'green'
                        }
                    } else if (status == 'WAITING') {
                        if (dayDiv.style.background == 'orange') {
                            dayDiv.style.background = 'orange'
                        } else if (dayDiv.style.background == 'red') {
                            dayDiv.style.background = 'linear-gradient(red 50%, orange 50%)'
                        } else if (dayDiv.style.background == 'green') {
                            dayDiv.style.background = 'linear-gradient(green 50%, orange 50%)';
                        } else if (dayDiv.style.background == 'linear-gradient(red 50%, orange 50%)') {
                            dayDiv.style.background = 'linear-gradient(red 50%, orange 50%)'
                        } else if (dayDiv.style.background == 'linear-gradient(green 50%, orange 50%)') {
                            dayDiv.style.background = 'linear-gradient(green 50%, orange 50%)'
                        } else if (dayDiv.style.background == 'linear-gradient(green 50%, red 50%)') {
                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                        } else if (dayDiv.style.background == 'linear-gradient(red 25%, green 50%, orange 80%)') {
                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                        } else {
                            dayDiv.style.background = 'orange'
                        }
                    } else if (status == 'REFUSED') {
                        if (dayDiv.style.background == 'red') {
                            dayDiv.style.background = 'red'
                        } else if (dayDiv.style.background == 'green') {
                            dayDiv.style.background = 'linear-gradient(green 50%, red 50%)'
                        } else if (dayDiv.style.background == 'orange') {
                            dayDiv.style.background = 'linear-gradient(red 50%,orange 50%)';
                        } else if (dayDiv.style.background == 'linear-gradient(green 50%, red 50%)') {
                            dayDiv.style.background = 'linear-gradient(green 50%, red 50%)'
                        } else if (dayDiv.style.background == 'linear-gradient(red 50%, orange 50%)') {
                            dayDiv.style.background = 'linear-gradient(red 50%, orange 50%)'
                        } else if (dayDiv.style.background == 'linear-gradient(green 50%, orange 50%)') {
                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                        } else if (dayDiv.style.background == 'linear-gradient(red 25%, green 50%, orange 80%)') {
                            dayDiv.style.background = 'linear-gradient(red 25%, green 50%, orange 80%)'
                        } else {
                            dayDiv.style.background = 'red'
                        }
                    }

                }
            }
            eMonth.appendChild(dayDiv);
            ds.setDate(ds.getDate() + 1);
        }
    }
});
