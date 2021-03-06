<?php namespace Kiwing\SentrySocial\Links;
/**
 * Part of the Sentry Social package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Sentry
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\Sentry\Users\UserInterface;

interface LinkInterface {

	/**
	 * Store a token with the link.
	 *
	 * @param  mixed  $token
	 * @return void
	 */
	public function storeToken($token);

	/**
	 * Get the user associated with the social link.
	 *
	 * @return \Cartalyst\Sentry\Users\UserInterface  $user
	 */
	public function getUser();

	/**
	 * Set the user associated with the social link.
	 *
	 * @param  \Cartalyst\Sentry\Users\UserInterface  $user
	 * @return void
	 */
	public function setUser(UserInterface $user);

}
