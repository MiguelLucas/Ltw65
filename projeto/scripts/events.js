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

      // For each object, creates a div .event and fills each field
      for (var i = 0; i < data.length; i++) {
        var event = $('#hidden .event').clone(true);
        event.find(".event_img").attr("src", 'img/events/' + data[i].eventPhoto);
        event.find(".event_name").text(data[i].name);
        event.find(".event_date_time").text(moment(data[i].date).format('MMM D, YYYY [at] h:mm A'));
        event.find(".event_address").text(data[i].address);
        event.find(".event_type").text(data[i].type);
        event.find(".event_more").attr("href", 'view-event.php?idEvent=' + data[i].idEvent + '&replytocom=0');

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
        var userFullName = data[i].userFirstName + ' ' + data[i].userLastName;
        var event = $('#hidden .event').clone(true);
        event.find(".event_name").text(data[i].name);
        event.find(".event_desc").text(data[i].description);
        event.find(".event_address").text(data[i].address);
        event.find(".event_date_time").text(moment(data[i].date).format('dddd, MMMM Do, YYYY [at] h:mm A'));
        event.find(".event_type").text(data[i].type);
        event.find(".event_privacy").text(event_privacy);
        event.find(".event_owner").text(userFullName);
        event.find(".event_img").attr("src", 'img/events/' + data[i].eventPhoto);

        $('#event').append(event);
      }
    }
  });
}



// AJAX request to get Events by id that loads event to page
function loadEventsCreatedByUser(idUser)
{
 
  $.ajax({
    
    method: "GET",
    dataType: "json",
    url: "database/events.php",
    data: { action : "event" , idUserCreator : idUser },
    success: function(data) {
    //  $('#event').empty();
      // Saves event on lastEvent var for future use
      // Fills in each field
      for (var i = 0; i < data.length; i++) {
        lastEvent = data[i];

        var event_privacy = (data[i].private == "1") ? "Private event" : "Public event";
        var userFullName = data[i].userFirstName + ' ' + data[i].userLastName;
        var event = $('#hidden .event').clone(true);
        event.find(".event_name").text(data[i].name);
        event.find(".event_desc").text(data[i].description);
        event.find(".event_address").text(data[i].address);
        event.find(".event_date_time").text(moment(data[i].date).format('dddd, MMMM Do, YYYY [at] h:mm A'));
        event.find(".event_type").text(data[i].type);
        event.find(".event_privacy").text(event_privacy);
        event.find(".event_owner").text(userFullName);
        event.find(".event_img").attr("src", 'img/events/' + data[i].eventPhoto);
		event.find(".event_more").attr("href", 'view-event.php?idEvent=' + data[i].idEvent + '&replytocom=0');
		
        $('#myEvents').append(event);
      }
    }
  });
}

// AJAX request to get Events the User is Attending
function loadAttendingEventsByUser(idUser)
	{

	$.ajax({

		method: "GET",
		dataType: "json",
		url: "database/events.php",
		data: { action : "attending" , idAttendingUser : idUser },
		success: function(data) {
			console.log(data);
			//  $('#event').empty();
			// Saves event on lastEvent var for future use
			// Fills in each field
			for (var i = 0; i < data.length; i++) {
				lastEvent = data[i];

				var event_privacy = (data[i].private == "1") ? "Private event" : "Public event";
				var userFullName = data[i].userFirstName + ' ' + data[i].userLastName;
				var event = $('#hidden .event').clone(true);
				event.find(".event_name").text(data[i].name);
				event.find(".event_desc").text(data[i].description);
				event.find(".event_address").text(data[i].address);
				event.find(".event_date_time").text(moment(data[i].date).format('dddd, MMMM Do, YYYY [at] h:mm A'));
				event.find(".event_type").text(data[i].type);
				event.find(".event_privacy").text(event_privacy);
				event.find(".event_owner").text(userFullName);
				event.find(".event_img").attr("src", 'img/events/' + data[i].eventPhoto);
				event.find(".event_more").attr("href", 'view-event.php?idEvent=' + data[i].idEvent + '&replytocom=0');
				
				$('#attendingEvents').append(event);
			}
		}
	});
}

/*
 * Register user in event
*/
function registerUserEvent(idEvent, idUser){
	$.ajax({
		method: "POST",
		dataType: "json",
		url: "database/events.php",
		data: {
		  action: "user_register_event",
		  user_id: idUser,
		  event_id: idEvent,

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
 * Register user in event
*/
function cancelUserEventRegistration(idEvent, idUser){
	$.ajax({
		method: "POST",
		dataType: "json",
		url: "database/events.php",
		data: {
		  action: "user_cancel_register_event",
		  user_id: idUser,
		  event_id: idEvent,

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
    FUNCTIONS RELATED TO EVENT EDITION
*/

/* Loads event edit form and sets the inputs' default values to the event's current values */
function fillEditEventForm() {
  $('#comments').hide();
  $('#event').empty();
  var edit_event = $('#hidden .event_form').clone(true);

  edit_event.find(".user_id").val(lastEvent.idUserCreator);
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
  verifyEventData(editEvent);

  $('button.delete_event').click(function(){
      deleteEventDialog();
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
		console.log(data);
		if (data.redirect !== undefined && data.redirect) {
			window.location.href = data.redirect_url;
      }
    },
    error: function(data) {
		console.log('sou parvo');
      console.log(data.responseText);
    }
  });
}

/*
    FUNCTIONS RELATED TO EVENT CREATION
*/

// AJAX request to create Event
function createEvent() {
	$.ajax({
		method: "POST",
		dataType: "json",
		url: "database/events.php",
		data: {
		  action: "create_event",
		  user_id: $('input[name="idUser"]').val(),
		  name: $('input[name="name"]').val(),
		  description: $('textarea[name="description"]').val(),
		  date: $('input[name="date"]').val(),
		  time: $('input[name="time"]').val(),
		  address: $('input[name="address"]').val(),
		  type: $('select[name="type"]').val(),
		  private: $('select[name="private"]').val(),
		},
	success: function(data) {
	console.log(data);
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

// Form data is verified while filling in the form and on submission
function verifyEventData(fnName) {
  // name verification
  verifyFieldOnChangeAndBlur(isEmpty, $('input[name="name"]'), $('#event_name_error'));
  onFocusRemoveErrorMsgs($('input[name="name"]'), $('#event_name_error'));

  // date verification
  $('input[name="date"]').focusout(function() {
    isDateInvalid($('input[name="date"]'), $('#event_date_error'));
    isDatePast($('input[name="date"]'), $('#event_date_error'));
  });
  onFocusRemoveErrorMsgs($('input[name="date"]'), $('#event_date_error'));

  // address verification
  verifyFieldOnChangeAndBlur(hasNotLetters, $('input[name="address"]'), $('#event_address_error'));
  onFocusRemoveErrorMsgs($('input[name="address"]'), $('#event_address_error'));

  $('.save_button').click(function() {
    if (isEmpty($('input[name="name"]'), $('#event_name_error')))
      return false;
    if (isDateInvalid($('input[name="date"]'), $('#event_date_error')))
      return false;
    if (isDatePast($('input[name="date"]'), $('#event_date_error')))
      return false;
    if (hasNotLetters($('input[name="address"]'), $('#event_address_error')))
      return false;
    fnName();
  });
}

/*
  VERIFICATION FUNCTIONS
  Receive field to be checked and div to insert the error message in.
  If TRUE {display error}
*/

// If input has focus, remove error messages
function onFocusRemoveErrorMsgs(field, error_div) {
  $(field).focus(function() {
    if ($(field).hasClass('invalid')) {
      $(field).removeClass('invalid');
      $(error_div).empty();
    }
  });
}

// Verifies if field is empty. (empty string == false)
function isEmpty(field, error_div) {
  if (!field.val()) {
    field.addClass('invalid');
    error_div.text('You can\'t leave this empty.');
    return true;
  }
}

// Verifies if date is invalid
function isDateInvalid(field, error_div) {
  if (!moment(field.val()).isValid()) {
    field.addClass('invalid');
    $(error_div).text('Insert a valid date.');
    return true;
  }
}

// Verifies if date is in the past.
function isDatePast(field, error_div) {
  if (moment(field.val()).diff(moment(), 'days') < 0) {
    field.addClass('invalid');
    $(error_div).text('The date can\'t be in the past.');
    return true;
  }
}

// Verifies if field contains numbers or (some) punctuation. 
function hasNotLetters(field, error_div) {
  if (/[0-9]+|[\\\|!\"@#£$§%€&\/()\[\]{}=?'»«\*\+<>;,:._^~´`¨]+/i.test(field.val())) {
    field.addClass('invalid');
    error_div.text('This field only accepts letters.');
    return true;
  }
}

/*
  Meta Verification Functions
*/
function verifyFieldOnChangeAndBlur(fnName, field, error_div) {
  field.change(function() {
    fnName(field, error_div);
  });

  field.blur(function() {
    fnName(field, error_div);
  });
}
