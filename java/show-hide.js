var angezeigt = false;
function versteckt()
{
if (angezeigt)
{
document.getElementById('ghost').style.display = 'none';
angezeigt = false;
}
else
{
document.getElementById('ghost').style.display = 'block';
angezeigt = true;
document.getElementById('ghost_fb').style.display = 'none';
angezeigt_fb = false;
}
}
var angezeigt_fb = false;
function versteckt_fb()
{
if (angezeigt_fb)
{
document.getElementById('ghost_fb').style.display = 'none';
angezeigt_fb = false;
}
else
{
document.getElementById('ghost_fb').style.display = 'block';
angezeigt_fb = true;
document.getElementById('ghost').style.display = 'none';
angezeigt = false;
}
}
//-----------------------------
var angezeigt_info = false;
function zeigen_info()
{
if (angezeigt_info)
{
document.getElementById('ghost_info').style.display = 'none';
angezeigt_info = false;
}
else
{
document.getElementById('ghost_info').style.display = 'block';
angezeigt_info = true;
}
}
function versteckt_info()
{
if (angezeigt_info)
{
document.getElementById('ghost_info').style.display = 'none';
angezeigt_info = true;
}
else
{
document.getElementById('ghost_info').style.display = 'block';
angezeigt_info = false;
}
}