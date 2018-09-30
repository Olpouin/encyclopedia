function openNav() {
    document.getElementById("sidenav").classList.add("open");
}

function closeNav() {
    document.getElementById("sidenav").classList.remove("open");
}

function openImg(e) {
	document.getElementById("fs-img_title").innerHTML = e.target.getAttribute('alt');
	document.getElementById("fs-img_img").setAttribute("src", e.target.getAttribute('src'));

	document.getElementById("sidenav").style.filter = "blur(3px)";
	document.getElementById("card").style.filter = "blur(3px)";

	document.getElementById("fullscreen-image").classList.add("open");
}

function closeImg() {
	document.getElementById("sidenav").style.filter = "";
	document.getElementById("card").style.filter = "";
	document.getElementById("fullscreen-image").classList.remove("open");
}
