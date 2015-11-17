
$().ready(loadDocument);

function loadDocument() {
  loadEvents();
 
}

function loadEvents() {
  $.getJSON("events.php", eventsLoaded);
}

function eventsLoaded(data) {
  $.each(data, insertEvent);
  
  // Saves the first line for easy cloning
  //savedLine = $("#products .line:first-child").clone();
}

function insertEvent(key, name, description) {
  // Create the option tag for the product
  var event = $("<option></option>");
  event.text(name);
  event.val(description);
  
  // Insert the option tag in the select
  $("#events .line:first-child select").append(event);
}
