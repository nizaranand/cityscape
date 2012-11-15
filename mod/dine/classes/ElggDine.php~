<?php
/**
 * Extended class to override the time_created
 * 
 * @property string $status      The published status of the dine post (published, draft)
 * @property string $comments_on Whether commenting is allowed (Off, On)
 * @property string $excerpt     An excerpt of the dine post used when displaying the post
 */
class ElggDine extends ElggUser {

	/**
	 * Set subtype to dine.
	 */
	protected function initializeAttributes() {
		parent::initializeAttributes();

		$this->attributes['subtype'] = "dine";
	}

	/**
	 * Registers a dine, returning false if the username already exists
	 *
	 * @param string $username              The username of the new user
	 * @param string $password              The password
	 * @param string $name                  The user's display name
	 * @param string $email                 Their email address
	 *
	 * @return true|false The dine registered successfully; false on failure
	 */
	public function registerDine($username, $password, $name, $email) {

		// Load the configuration
//		global $CONFIG;

		// no need to trim password.
		$username = trim($username);
		$name = trim(strip_tags($name));
		$email = trim($email);

		// A little sanity checking
		if (empty($username)
		|| empty($password)
		|| empty($name)
		|| empty($email)) {
			return false;
		}

		// Make sure a user with conflicting details hasn't registered and been disabled
		$access_status = access_get_show_hidden_status();
		access_show_hidden_entities(true);

		if (!validate_email_address($email)) {
			throw new RegistrationException(elgg_echo('registration:emailnotvalid'));
		}

		if (!validate_password($password)) {
			throw new RegistrationException(elgg_echo('registration:passwordnotvalid'));
		}

		if (!validate_username($username)) {
			throw new RegistrationException(elgg_echo('registration:usernamenotvalid'));
		}

		if ($user = get_user_by_username($username)) {
			throw new RegistrationException(elgg_echo('registration:userexists'));
		}

		access_show_hidden_entities($access_status);

		// Register user
		$this->username = $username;
		$this->email = $email;
		$this->name = $name;
		$this->access_id = ACCESS_PUBLIC;
		$this->salt = generate_random_cleartext_password(); // Note salt generated before password!
		$this->password = generate_user_password($user, $password);
		$this->owner_guid = 0; // Users aren't owned by anyone, even if they are admin created.
		$this->container_guid = 0; // Users aren't contained by anyone, even if they are admin created.
		$this->language = get_current_language();
		$this->save();

		// Turn on email notifications by default
		set_user_notification_setting($user->getGUID(), 'email', true);

		return true;
	}
}
