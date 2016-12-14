var logo = document.getElementById("logo");
var box = document.getElementById("box");
logo.draggable=true;
box.ondragover = function(event){
	event.preventDefault();
}
box.ondrop = function(event){
	box.appendChild(logo);
}