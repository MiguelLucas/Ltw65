$(document).ready(loadDocument);

function loadDocument() {
  //loadEvents();


  $('button.create_event').click(function() {
/*    $newEvent = $('#hidden form .event_form').clone(true);
    console.log($newEvent.html());
    $('#events').prepend($newEvent);
    alert('form');*/

    loadEvent();
  });
  


}

// Fuction that requests events and loads them onto the page
function loadEvents(id) 
{
	$.ajax({
    method: "GET",
    dataType: "json",
    url: "events.php",
    data: "idEvent=" + id,
    success: function(data) {
      console.log(data);

      // for each object, creates a div .event and fills each field
      for (var i = 0; i < data.length; i++) {
        $event = $('#hidden .event').clone(true);
        $event.find(".event_name").text(data[i].name);
        $event.find(".event_name").attr("href", 'view-event.php?idEvent=' + data[i].idEvent);
        $event.find(".event_desc").text(data[i].description);
        $event.find(".event_address").text(data[i].address);
        $event.find(".event_date").text(data[i].date);
        $event.find(".event_type").text(data[i].type);
        $event.find(".event_privacy").text(data[i].private);
        $event.find(".event_img").attr("src", 'thisfolder/' + data[i].eventPhoto);

        $('#events').append($event);
      }
    }
  });
}

var lastEvent = null;

function loadEvent() {
  $.ajax({
    method: "GET",
    dataType: "json",
    url: "events.php",
    data: { idEvent : "1" },
    success: function(data) {
      console.log(data);

      // do this thing
      for (var i = 0; i < data.length; i++) 
      {
        lastEvent = data[i];
        $event = $('#hidden .event').clone(true);
        $event.find(".event_name").text(data[i].name);

        $('#events').append($event);
      }

    }
  });
}

// $('button .create_event').click(function() {
//   alert('button was clicked!')
// });