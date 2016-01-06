"use strict";

var name;

document.observe("dom:loaded", function() {

 	var img = $$("#tg img");
	for (var i = 0; i < img.length; i++) {
		new Draggable(img[i], {revert : true});
	}
	Droppables.add("trashcan", {onDrop: removeData});

	new Ajax.Request("admin_user_remove.php", {
        method: "post",
        parameters: {name: findId()},
        onFailure: ajaxFailed,
        onException: ajaxFailed
    });
});

function removeData(drag, drop, event) {
	var removeTr;
	var num = drag.getAttribute("alt");
	for (var i = 0; i < $$("tr").length - 2; i++){
		if(drag.getAttribute("alt") == num){
			num = "tablerow" + num;
			removeTr = $(num);
			name = $(num).firstChild.nextSibling.nextSibling.nextSibling.innerHTML;
			removeTr.innerHTML = "";
		}
	}
}

function findId(){
	return name;
}

function ajaxFailed(ajax, exception) {
	var errorMessage = "Error making Ajax request:\n\n";
	if (exception) {
		errorMessage += "Exception: " + exception.message;
	} else {
		errorMessage += "Server status:\n" + ajax.status + " " + ajax.statusText + "\n\nServer response text:\n" + ajax.responseText;
	}
	alert(errorMessage);
}