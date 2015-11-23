// $(document).ready(function()
//   {
//     $('button .create_event').click(function() {
//       alert('create an event!');
//     });

//     $('button .edit_event').click(function(){
//       alert('let\'s edit this');
//     });

//     $('button .delete_event').click(function(){
//       alert('let\'s delete this shit!');
//     });

//   });




/*  $('button.create_event').click(function() {


    loadEvent();
  });*/
  


// Fuction that requests events and loads them onto the page
function loadEvents() 
{
	$.ajax({
    method: "GET",
    dataType: "json",
    url: "database/events.php",
    data: { action : "event" },
    success: function(data) {
      console.log(data);

      // For each object, creates a div .event and fills each field
      for (var i = 0; i < data.length; i++) {
        $event = $('#hidden .event').clone(true);
        $event.find(".event_img").attr("src", 'thisfolder/' + data[i].eventPhoto);
        $event.find(".event_name").text(data[i].name);
        $event.find(".event_date").text(data[i].date);
        $event.find(".event_address").text(data[i].address);
        $event.find(".event_type").text(data[i].type);
        $event.find(".event_more").attr("href", 'view-event.php?idEvent=' + data[i].idEvent);

        $('#events').append($event);
      }
    }
  });
}

var lastEvent = null;
var lastEventDate = new Date();

// Function that requests event by id and loads it on the page
function loadEvent(id)
{
  $.ajax({

    method: "GET",
    dataType: "json",
    url: "database/events.php",
    data: { action : "event" , idEvent : id },
    success: function(data) {

      // Saves event on lastEvent var for future use
      // Fills in each field
      for (var i = 0; i < data.length; i++) {
        lastEvent = data[i];
        lastEventDate = setDate(data[i].date);
        var event_privacy = (data[i].private == "1") ? "Private event" : "Public event";
        $event = $('#hidden .event').clone(true);
        $event.find(".event_name").text(data[i].name);
        $event.find(".event_desc").text(data[i].description);
        $event.find(".event_address").text(data[i].address);
        $event.find(".event_date").text(data[i].date);
        $event.find(".event_date").text(data[i].date);
        $event.find(".event_type").text(data[i].type);
        $event.find(".event_privacy").text(event_privacy);
        $event.find(".event_img").attr("src", 'thisfolder/' + data[i].eventPhoto);

        $('#event').append($event);
      }
    }
  });
}

function editEvent() {
    $edit_event = $('#hidden .event_form').clone(true);
    console.log($edit_event);

    $edit_event.find(".event_id").val(lastEvent.id);
    $edit_event.find(".event_name").val(lastEvent.name);
    $edit_event.find(".event_desc").val(lastEvent.description);
    $edit_event.find(".event_address").val(lastEvent.address);
    $edit_event.find(".event_date input[type="date"]").val(lastEventDate.getFullYear()+'-'+(lastEventDate.getMonth()+1)+'-'+lastEventDate.getDate());
    $edit_event.find(".event_date input[type="time"]").val(lastEventDate.getFullYear()+'-'+(lastEventDate.getMonth()+1)+'-'+lastEventDate.getDate());
    //$edit_event.find(".event_type ").val(lastEvent.type);
    //$edit_event.find(".event_privacy").val(event_privacy);
    $edit_event.find(".event_img").val(lastEvent.eventPhoto);
    // $edit_event.find(".event_img").attr("src", 'thisfolder/' + lastEvent.eventPhoto);

    //console.log(event_type_list);

    /* date stuff

    $("input[type=date]").val(lastEventDate.getFullYear()+'-'+(lastEventDate.getMonth()+1)+'-'+lastEventDate.getDate());

    */

    var abc = $edit_event.find(".event_type option").clone(true);
    console.log("objeto nova opção: ");
    console.log(abc);
    console.log($.type(abc));
    for (var i = 0; i < event_type_list.length; i++) {
      console.log("tipo do evento = " + event_type_list[i].type);
      abc.text(event_type_list[i].type);
      console.log("texto = " + abc.text());
      abc.attr("value", event_type_list[i].type);
      console.log("attr valor = " + abc.attr("value"));

      console.log("objeto abc:");
      console.log(abc);
      // if ($abc.attr("value") == event_type_list[i].type) {
      //   $abc.attr("selected", "selected");

      // }
      $edit_event.find(".event_type").append(abc);

    }



    // for (i in event_type_list) {
    //   console.log(event_type_list[i].type);
    //   $edit_event.find(".event_type option").clone(true).val(event_type_list[i].type);
      // $new_option = $edit_event.find('.event_type option').clone(true);
      // $new_option.val(event_type_list[i].type);
      // $new_option.attr("value", event_type_list[i].type);
      // if (event_type_list[i].type == lastEvent.type) {
      //   $new_option.attr("selected", "selected");
      
      //$edit_event.find(".event_type").append("<option value =\"" + event_type_list[i].type + "\">" + event_type_list[i].type + "</option>");
    
    //getEventTypes();
    //console.log("tipos de evento:");
    //console.log($event_type_list);
    $('#event').prepend($edit_event);
}

var event_type_list = [];
/* Function that gets all event types from database */
function getEventTypes() {
  event_type_list = [];
  $.ajax(
    {
      method:"GET",
      dataType: "json",
      url: "database/events.php",
      data: { action : "event_types" },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          event_type_list.push(data[i]);
          //event_type_list.push(data[i].type);
        }
      }
    });
}

function loadButtons() {
    $('button.create_event').click(function() {
      alert('create an event!');
    });

    $('button.edit_event').click(function(){
      editEvent();
    });

    $('button.delete_event').click(function(){
      alert('let\'s delete this shit!');
    });
}
