
$().ready(loadDocument);

function loadDocument() {
  loadEvents();
 
}

function loadEvents() {
	alert('Hello 3');
  $.getJSON("events.php", eventsLoaded);
}

function eventsLoaded(data) {
	alert('Hello 2');
  $.each(data, insertEvent);
  
  // Saves the first line for easy cloning
  //savedLine = $("#products .line:first-child").clone();
}

function insertEvent(key, evento) {
  // Create the option tag for the product
  var event = $("<option></option>");
  alert('Hello');
  //console.log(event.text(evento));
  event.text(evento);
  event.val(evento);
  
  // Insert the option tag in the select
  $("#events .line:first-child select").append(event);
}
