(function () {
    const menuToggle = document.querySelector('.menu-toggle');
    menuToggle.onclick = function (e) {
        const body = document.querySelector('body');
        body.classList.toggle('hide-sidebar');
    }
})()

function addSeconds(hours, minutes, seconds) {
    const day = new Date();
    day.setHours(parseInt(hours));
    day.setMinutes(parseInt(minutes));
    day.setSeconds(parseInt(seconds) + 1);

    const h = `${day.getHours()}`.padStart(2, 0);
    const m = `${day.getMinutes()}`.padStart(2, 0);
    const s = `${day.getSeconds()}`.padStart(2, 0);

    return `${h}:${m}:${s}`;
}

function activateClock() {
    const activeClock = document.querySelector('[active-clock]');
    if (!activeClock) return;

    setInterval(function() {
        const parts = activeClock.innerHTML.split(':');
        activeClock.innerHTML = addSeconds(...parts);
    },1000);
}

activateClock();