<?php namespace Cartalyst\SentrySocial\Services\OAuth2;
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
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Cartalyst\SentrySocial\Services\ServiceInterface;
use OAuth\OAuth2\Service\Microsoft as BaseService;

class Microsoft extends BaseService implements ServiceInterface {

	/**
	 * Array of cached user info.
	 *
	 * @var array
	 */
	protected $cachedInfo = array();

	/**
	 * Returns the user's unique identifier on the service.
	 *
	 * @return mixed
	 */
	public function getUniqueIdentifier()
	{
		$info = $this->getUserInfo();
		return $info['id'];
	}

	/**
	 * Returns the user's email address. Note, some services
	 * do not provide this in which case "null" is returned.
	 *
	 * @return string|null
	 * @link   http://social.msdn.microsoft.com/Forums/en-US/messengerconnect/thread/c6dcb9ab-aed4-400a-99fb-5650c393a95d
	 */
	public function getEmail()
	{
		$info = $this->getUserInfo();

		// There are a few emails that can be accessed,
		// "preferred", "account", "personal" and "business".
		// We will stick with "account" for now as that's most
		// likely what they'd want.
		if (isset($info['emails']['account']))
		{
			return $info['emails']['account'];
		}

		return null;
	}

	/**
	 * Returns the user's name. If first / last name can be
	 * determined, an array is returned. If not, a string is
	 * returned. If it cannot be determined, "null" is returned.
	 *
	 * @return array|string|null
	 */
	public function getName()
	{
		$info = $this->getUserInfo();
		return array($info['first_name'], $info['last_name']);
	}

	/**
	 * Retuns an array of basic user information.
	 *
	 * @return array
	 * @link   https://developers.google.com/accounts/docs/OAuth2Login#userinfocall
	 */
	public function getUserInfo()
	{
		if ($this->cachedInfo === null)
		{
			$this->cachedInfo = json_decode($this->request('me'), true);
		}

		return $this->cachedInfo;
	}

}