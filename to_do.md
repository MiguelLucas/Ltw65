# TO DO

## Pages
## Different pages and its elements

### Main page
* Header
	* Website title / logo
	* Login / Register
	* Nav (if user is logged in)
		* Hosting (events created by user)
		* Invites (events user was invited to)
	* Search
* Body
	* Lists all events

### User registration page
* Form

### User account page
* Edit account information
* Delete account

### Event page
* Event info
* Users registered in event
* Users invited to event (if event is private)


Actions
---------
Creating, editing, deleting and fetching info from database.
---------

### User
* User registration
	* by email
	* by username
* User login / logout

### Event
* Create event
* Display event(s)
	* get all events (public + invited / registered to private)
	* get one event
* Edit event
* Delete event
* Registration in event
	* User registers in event
	* User unregisters in event

### Invites
* Event owner invites user
	* registered user
		* Registered user accepts or declines event invitation
	* unregistered user (by email)
		* Unregistered user receives email inviting them to register in order to get notification

### Comments
* Display comments
	* get all comments from event
* Edit comment
* Delete comment
* Nested comments
	* 1 comment may have N comments as replies
* Comment with a photo

### Search
* Basic search
	* searches… everywhere??
* Advanced search (filters)
	* by location (city?)
	* by date (from x to y)
	* by title
	* by type

### Photos
* Add photos to event
* Add albums to event

### Sharing
* Share event
	* by email
	* on social network
		* maybe we can start with FB, and go from there?



# DONE

* ...



# VERIFICATIONS / PERMISSIONS

## Required by project brief
* Only the registered event owner can manage (edit, delete) the event
* A user can't register to the same event twice
* Only event owners and users registered to an event may comment on it
* Private events only show for the owner, registered users and invitied users
* Private events do not show on searches

## Recommended / Makes sense / Just so we don't forget this
* Verify that required fields are filled (with useful info)
	* Check for unique username
	* Check for unique email
	* ...
* Validate email

## Security stuff
* ...



# IDEAS FOR EXTRAS

* Confirm emails after registration

* Users registered in public event may invite other users to event

* Responsive design