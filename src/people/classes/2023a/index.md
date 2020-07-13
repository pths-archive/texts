<!--?title Класс 2023-А-->
<div id="field">
    <center>
    <h1>Здесь будет класс 2023-А</h1>
    <img id="lil" src="https://i.imgur.com/HzW8F2S.png"/>
</div>

<script>
var lil = {};

document.addEventListener("DOMContentLoaded", function(event) {
    lil.container = $('div.container:nth-child(2)');
    lil.field = $('#field');
    lil.field.css('position', 'relative').css('overflow', 'hidden');
    lil.me = $('#lil');
    lil.me.css('position', 'absolute');
    function setSizes() {
        var h0 = $(window).height();
        var h1 = $('nav.navbar').outerHeight();
        var h2 = $('div.container:last').outerHeight();
        lil.fieldW = $(window).width();
        lil.fieldH = h0 - h1 - h2 - 1;
        lil.container.height(lil.fieldH).css('padding', '0px 0px 0px 0px');
        lil.field.css('height', '100%');
        if (lil.fieldW / lil.fieldH > 64 / 55) {
            lil.me.height(Math.floor(lil.fieldH / 4));
            lil.speed = lil.fieldH / 7 / 1000;
        } else {
            lil.me.height(Math.floor(lil.fieldW / 4  / 64 * 55));
            lil.speed = lil.fieldW / 7 / 1000;
        }
        lil.x = 0;
        lil.y = 0;
    }
    $(window).resize(setSizes);
    $(window).focus(setSizes);
    setSizes();
    lil.t = new Date().getTime();
    function doFrame() {
        var tNew = new Date().getTime();
        lilMove(tNew - lil.t);
        lil.t = tNew;
        requestAnimationFrame(doFrame);
    }
    function lilMove(dt) {
        if (!document.hasFocus()) {
            return;
        }
        if (lil.y >= lil.fieldH - lil.me.height()) lil.vy = -lil.speed;
        if (lil.x >= lil.fieldW - lil.me.width()) lil.vx = -lil.speed;
        if (lil.y <= 0) lil.vy = lil.speed;
        if (lil.x <= 0) lil.vx = lil.speed;
        lil.x += lil.vx * dt;
        lil.y += lil.vy * dt;
        lil.me.css('left', Math.round(lil.x) + 'px');
        lil.me.css('top', Math.round(lil.y) + 'px');
    }
    requestAnimationFrame(doFrame);
});
</script>
