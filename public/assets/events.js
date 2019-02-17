document.addEventListener('keypress', function (e) {
    if (e.key === 'a') {
        fetch('?destroy=1')
            .then(function (response) {
                response.text().then(function (html) {
                    document.querySelector('.map').innerHTML = html;
                });
            })
    } else {
        e.preventDefault();
        console.log(e.key);
        if (e.key === 'ArrowLeft' || e.key === 'q') {
            dir = 'W';
        }
        if (e.key === 'ArrowUp' || e.key === 'z') {
            dir = 'N';
        }
        if (e.key === 'ArrowRight' || e.key === 'd') {
            dir = 'E';
        }
        if (e.key === 'ArrowDown' || e.key === 's') {
            dir = 'S';
        }


        fetch('?dir=' + dir)
            .then(function (response) {
                response.text().then(function (html) {
                    document.querySelector('.map').innerHTML = html;
                });
            })
    }

});

document.getElementById('level').addEventListener('change', function (e) {
    console.log('a');
    document.getElementById('formlevel').submit();
});
