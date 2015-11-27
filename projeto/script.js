/* Function receives a date and returns it as a string, formatted to yyyy-mm-dd */
function formatDate(date) {
    var d = new Date(date);
    var month = (d.getMonth() + 1).toString();
    var day = d.getDate().toString();
    var year = d.getFullYear().toString();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

/* Function receives a date and returns it as a string, formatted to HH:MM:SS */
function formatTime(date) {
    var d = new Date(date);
    var hours = d.getHours().toString();
    var minutes = d.getMinutes().toString();
    var seconds = d.getSeconds().toString();

    if (hours.length < 2) hours = '0' + hours;
    if (minutes.length < 2) minutes = '0' + minutes;
    if (seconds.length < 2) seconds = '0' + seconds;

    return [hours, minutes, seconds].join(':');
}

// Fuction that requests events and loads them onto the page
function loadEvents() 
{
  $.ajax(
  {
    method: "GET",
    url: "database/events.php",
    data: { action : "event" },
    success: function(data) {
      console.log(data);

      // For each object, creates a div .event and fills each field
      for (var i = 0; i < data.length; i++) {
        var event = $('#hidden .event').clone(true);
        event.find(".event_img").attr("src", 'thisfolder/' + data[i].eventPhoto);
        event.find(".event_name").text(data[i].name);
        event.find(".event_date").text(formatDate(data[i].date));
        event.find(".event_time").text(formatTime(data[i].date));
        event.find(".event_address").text(data[i].address);
        event.find(".event_type").text(data[i].type);
        event.find(".event_more").attr("href", 'view-event.php?idEvent=' + data[i].idEvent);

        $('#events').append(event);
      }
    },
      error: function(data)
      {
        console.log(data.responseText);
      }
  });
}

var lastEvent = null;

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

        var event_privacy = (data[i].private == "1") ? "Private event" : "Public event";
        var event = $('#hidden .event').clone(true);
        event.find(".event_name").text(data[i].name);
        event.find(".event_desc").text(data[i].description);
        event.find(".event_address").text(data[i].address);
        event.find(".event_date").text(formatDate(data[i].date));
        event.find(".event_time").text(formatTime(data[i].date));
        event.find(".event_type").text(data[i].type);
        event.find(".event_privacy").text(event_privacy);
        event.find(".event_img").attr("src", 'thisfolder/' + data[i].eventPhoto);

        $('#event').append(event);
      }
    }
  });
}

/* Function that loads event edit form and sets the inputs default values to the event's current values */
function editEvent() {
  $('#event .event').remove();
  var edit_event = $('#hidden .event_edit').clone(true);

  edit_event.find(".event_id").val(lastEvent.idEvent);
  edit_event.find(".event_name").val(lastEvent.name);
  edit_event.find(".event_desc").val(lastEvent.description);
  edit_event.find(".event_address").val(lastEvent.address);
  edit_event.find(".event_date").val(formatDate(lastEvent.date));
  edit_event.find(".event_time").val(formatTime(lastEvent.date));
  //edit_event.find(".event_type ").val(lastEvent.type);

  if (lastEvent.private == "1") {
    edit_event.find('.event_privacy option[value="1"]').attr("selected", "selected");
  } else {
    edit_event.find('.event_privacy option[value="0"]').attr("selected", "selected");
  };

  edit_event.find(".event_img").val(lastEvent.eventPhoto);
  // edit_event.find(".event_img").attr("src", 'thisfolder/' + lastEvent.eventPhoto);

  for (i in event_type_list) {
    var new_option = edit_event.find('.event_type option:first-child').clone(true);
    new_option.val(event_type_list[i].idEventType);
    new_option.text(event_type_list[i].type);
    if (event_type_list[i].type == lastEvent.type) {
      new_option.attr("selected", "selected");
    }

    edit_event.find(".event_type").append(new_option);
}
  $('#event').prepend(edit_event);

  edit_event.submit(function() {
    $.ajax(
      {
        method: "PUT",
        dataType: "json",
        url: "database/events.php",
        data: {
            action: "edit_event",
            idEvent: $('input[name="idEvent"]').val(),
            name: $('input[name="name"]').val(),
            description: $('input[name="description"]').val(),
            date: $('input[name="date"]').val(),
            time: $('input[name="time"]').val(),
            address: $('input[name="address"]').val(),
            type: $('select[name="type"]').val(),
            private: $('select[name="private"]').val(),
            eventPhoto: $('input[name="eventPhoto"]').val() },
        success: function() {
          alert('sucess!');
          loadEvent(lastEvent.idEvent);
        },
        error: function(data) {
          console.log(data.responseText);
        }
      });
  });
}

var event_type_list = [];

/* Function that gets all event types from database */
function getEventTypes() {
  // var event_type_list = [];
  if (event_type_list.length > 0) { event_type_list.length = 0; }

  $.ajax(
    {
      // async: false,
      method:"GET",
      dataType: "json",
      url: "database/events.php",
      data: { action : "event_types" },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          event_type_list.push(data[i]);
        }
      }
    });
  // return event_type_list;
}

/* Function that loads button events */
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
