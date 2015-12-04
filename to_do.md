TO DO
=========
# High priority
* Database:
	* add 'active' collumn to any relevant table (Event, Registration, Invite, User(?))
	* add default value to userPhoto (default.png)
* Add/verify session_start() on all pages 
* Permission checks on all pages (User X CAN do Y)
	* __Guest user__:
		* Sign up
		* Log in
		* Search, Browse and View Public Events
	* __Logged user__:
		* Create Event
		* Share Event IF Public
		* Comment on Public Event
		* Share Public Event
		* __ User NOT registered in event__:
			* Register to Public Event
		* __User Invited to Private Event__, but hasn't accepted ):
			* View
			* Accept Invitation (Register to Event)
			* Decline Invitation
			* Comment
		* __User Registered to Private Event__:
			* 'DeRegister from Event' (decide not to go to event)
		* __Event Owner__:
			* Edit
			* Delete
			* Invite people
* Event Create / Edit: add User ID to hidden form
* Events.PHP:
	* only return active items
	* Delete: set bool active to 0
	* add User ID (from session or wherever it's stored)
	* get Events user is attending
	* get Events user is Invited to 
	* get Events user is hosting
* Comments: add Event ID to form
* User page:
	* List events:
		~~ * Attending~~
		* Invites
		~~ * Hosting~~
* Registration in Event
	~~ * User Attends event~~
	* User decides not to attend anymore
* Index: list all Public Events
* Search (requests are handled by events.php, functions at events.js) [NOTE: only returns Public Events]
* Add Event / User Photo
* Security:
	* XSS
	* CSRF
	* Validate all inputs in PHP (at least one form)
* CSS

# Medium-high priority
* Invite user X to Event by email [NOTE: Really should be done, but last-case-scenario we ditch private events]
	* if User X exists, update Invite
	* if User X doesn't exist, send email asking to sign up
		* once ANY user registers, if email exists in PendingInvite, update Invite when creating account

# Medium Priority
* Index:
	* Different sections
		* Concerts
		* Events in Porto
		* Parties
		* ...
# Low Priority
* Responsive design
* Share
	* by email
	* by social network
* Confirm email after registration
* Add photos (and/or albums) to Event
