function openNav() {
    document.getElementById("sidenav").classList.add("open");
}

function closeNav() {
    document.getElementById("sidenav").classList.remove("open");
}

function openImg(e) {
	document.getElementById("fs-img_title").innerHTML = e.target.getAttribute('alt');
	document.getElementById("fs-img_img").setAttribute("src", e.target.getAttribute('src'));
	document.getElementById("fullscreen-image").classList.add("open");
}

function closeImg() {
	document.getElementById("fullscreen-image").classList.remove("open");
}

function imgResize() {
	document.getElementById("fs-img_img").style.maxHeight = "100%";
}
