$(document).ready(loadDocument);

function loadDocument() {
  loadEvents();
 
}

// Fuction that requests events and loads them onto the page
function loadEvents() {
	$.ajax({
    dataType: "json",
    url: "events.php",
    success: function(data) {
      console.log(data);

      // for each object, creates a div .event and fills each field
      for (var i = 0; i < data.length; i++) {
        $event = $('#hidden .event').clone(true);
        $event.find(".event_name").text(data[i].name);
        $event.find(".event_desc").text(data[i].description);
        $event.find(".event_date").text(data[i].date);
        $event.find(".event_img").attr("src", 'thisfolder/' + data[i].eventPhoto);

        $('#events').append($event);
      }
    }
  });
}
