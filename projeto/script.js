/*
    FUNCTIONS THAT GET EVENTS
*/

// AJAX request to get all Events that loads events to page
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
        event.find(".event_date_time").text(moment(data[i].date).format('MMM D, YYYY [at] h:mm A'));
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

// AJAX request to get Events by id that loads event to page
function loadEvent(id)
{
  $.ajax({

    method: "GET",
    dataType: "json",
    url: "database/events.php",
    data: { action : "event" , idEvent : id },
    success: function(data) {

      $('#event').empty();
      // Saves event on lastEvent var for future use
      // Fills in each field
      for (var i = 0; i < data.length; i++) {
        lastEvent = data[i];

        var event_privacy = (data[i].private == "1") ? "Private event" : "Public event";
        var event = $('#hidden .event').clone(true);
        event.find(".event_name").text(data[i].name);
        event.find(".event_desc").text(data[i].description);
        event.find(".event_address").text(data[i].address);
        event.find(".event_date_time").text(moment(data[i].date).format('dddd, MMMM Do, YYYY [at] h:mm A'));
        event.find(".event_type").text(data[i].type);
        event.find(".event_privacy").text(event_privacy);
        event.find(".event_img").attr("src", 'thisfolder/' + data[i].eventPhoto);

        $('#event').append(event);
      }
    }
  });
}

/*
    FUNCTIONS RELATED TO EVENT EDITION
*/

/* Loads event edit form and sets the inputs' default values to the event's current values */
function fillEditEventForm() {
  $('#comments').hide();
  $('#event').empty();
  var edit_event = $('#hidden .event_form').clone(true);

  edit_event.find(".event_id").val(lastEvent.idEvent);
  edit_event.find(".event_name").val(lastEvent.name);
  edit_event.find(".event_desc").val(lastEvent.description);
  edit_event.find(".event_address").val(lastEvent.address);
  edit_event.find(".event_date").val(moment(lastEvent.date).format('YYYY-MM-DD'));
  edit_event.find(".event_time").val(moment(lastEvent.date).format('hh:mm'));

  if (lastEvent.private == "1") {
    edit_event.find('.event_privacy option[value="1"]').attr("selected", "selected");
  } else {
    edit_event.find('.event_privacy option[value="0"]').attr("selected", "selected");
  };

  $('#event').prepend(edit_event);
  loadEventTypeOptions($('#event .event_type'));
  verifyEditEventData();

  $('button.delete_event').click(function(){
      deleteEventDialog();
  });

}

// Verifies data on edit event form
function verifyEditEventData() {
  $('.save_button').click(function() {

    //Verification
    // if (SOMETHING_BAD_HAPPENED)
    //   return false;

    // TESTE
    if (1 == 2) {
      console.log('somehting bad happened');
      return false;
    }
    editEvent();
});
}

// AJAX request to edit Event
function editEvent() {
  $.ajax(
  {
    method: "PUT",
    dataType: "json",
    url: "database/events.php",
    data: {
        action: "edit_event",
        idEvent: $('input[name="idEvent"]').val(),
        name: $('input[name="name"]').val(),
        description: $('textarea[name="description"]').val(),
        date: $('input[name="date"]').val(),
        time: $('input[name="time"]').val(),
        address: $('input[name="address"]').val(),
        type: $('select[name="type"]').val(),
        private: $('select[name="private"]').val() },
    success: function() {
      loadEvent(lastEvent.idEvent);
      $('#comments').show();
    },
    error: function(data) {
      console.log(data.responseText);
    }
  });
}

/*
    FUNCTIONS RELATED TO EVENT DELETION
*/

// Launches a confirmation dialog for event deletion
function deleteEventDialog() {
    swal({
    title: null,
    text: "Are you sure you want to delete this event?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes",
    closeOnConfirm: false,
    html: true
  }, function(isConfirm) {
    if (isConfirm) {
      deleteEvent();
      swal({
        title: null,
        text: "Your event has been deleted.",
        type: "success",
        html: true,
        allowEscapeKey: false,
      }, function(isConfirm){
        if (isConfirm) {
          window.location.href = 'index.php';
        } else {
          return false;
        }
      });
    } else {
      return false;
    }
  });
}

// AJAX request to delete Event
function deleteEvent() {
  $.ajax(
  {
    method: "DELETE",
    url: "database/events.php",
    data: { idEvent : lastEvent['idEvent'] },
    success: function(data) {
      if (data.redirect !== undefined && data.redirect) {
        window.location.href = data.redirect_url;
      }
    },
    error: function(data) {
      console.log(data.responseText);
    }
  });
}

/*
    FUNCTIONS RELATED TO EVENT CREATION
*/

// Verifies data on create event form
function verifyCreateEventData() {
  $('.save_button').click(function() {

    //Verification
    // if (SOMETHING_BAD_HAPPENED)
    //   return false;

    // TESTE
    if (1 == 2) {
      console.log('somehting bad happened');
      return false;
    }
    createEvent();
});
}

// AJAX request to create Event
function createEvent() {
    $.ajax(
      {
        method: "POST",
        dataType: "json",
        url: "database/events.php",
        data: {
          action: "create_news",
          name: $('input[name="name"]').val(),
          description: $('textarea[name="description"]').val(),
          date: $('input[name="date"]').val(),
          time: $('input[name="time"]').val(),
          address: $('input[name="address"]').val(),
          type: $('select[name="type"]').val(),
          private: $('select[name="private"]').val(),
        },
        success: function(data) {
          if (data.redirect !== undefined && data.redirect)
            window.location.href = data.redirect_url;
        },
        error: function(data) {
          console.log(data.responseText);
        }
      });
}

/*
    OTHER FUNCTIONS
*/

// Gets event types, appends a list of options to the select element (el)
function loadEventTypeOptions(el) {
  $.ajax(
    {
      method:"GET",
      dataType: "json",
      url: "database/events.php",
      data: { action : "event_types" },
      success: function(data) {
        for (var i = 0; i < data.length; i++) {
          if (lastEvent !== null && lastEvent.type == data[i].type) {
            el.append("<option value=\"" + data[i].idEventType + "\" selected=\"selected\">" + data[i].type + "</option>");
          } else {
            el.append("<option value=\"" + data[i].idEventType + "\">" + data[i].type + "</option>");
          }
        }
      },
        error: function(data) {
          console.log(data.responseText);
        }
      });
}
