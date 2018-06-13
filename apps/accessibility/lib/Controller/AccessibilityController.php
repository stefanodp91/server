<?php
declare (strict_types = 1);
/**
 * @copyright Copyright (c) 2018 John Molakvoæ (skjnldsv) <skjnldsv@protonmail.com>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Accessibility\Controller;

use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\AppFramework\Http\DataDisplayResponse;
use OCP\AppFramework\Utility\ITimeFactory;
use OCP\IConfig;
use OCP\ILogger;
use OCP\IRequest;
use OCP\IURLGenerator;
use OCP\IUserManager;

class AccessibilityController extends Controller {

	/** @var string */
	protected $appName;

	/** @var IConfig */
	private $config;

	/** @var IUserManager */
	private $userManager;

	/** @var ILogger */
	private $logger;

	/** @var IURLGenerator */
	private $urlGenerator;

	/** @var ITimeFactory */
	protected $timeFactory;

	/**
	 * Account constructor.
	 *
	 * @param string $appName
	 * @param IRequest $request
	 * @param IConfig $config
	 * @param IUserManager $userManager
	 * @param ILogger $logger
	 * @param IURLGenerator $urlGenerator
	 * @param ITimeFactory $timeFactory
	 */
	public function __construct(string $appName,
								IRequest $request,
								IConfig $config,
								IUserManager $userManager,
								ILogger $logger,
								IURLGenerator $urlGenerator,
								ITimeFactory $timeFactory) {
		parent::__construct($appName, $request);
		$this->appName      = $appName;
		$this->config       = $config;
		$this->userManager  = $userManager;
		$this->logger       = $logger;
		$this->urlGenerator = $urlGenerator;
		$this->timeFactory  = $timeFactory;
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 *
	 * @return DataResponse
	 */
	public function getCss() : DataDisplayResponse	{
		$css = '
		@keyframes swing {
			5% {
				-webkit-transform: rotate3d(0, 0, 1, 15deg);
				transform: rotate3d(0, 0, 1, 15deg);
			}

			10% {
				-webkit-transform: rotate3d(0, 0, 1, -10deg);
				transform: rotate3d(0, 0, 1, -10deg);
			}

			15% {
				-webkit-transform: rotate3d(0, 0, 1, 5deg);
				transform: rotate3d(0, 0, 1, 5deg);
			}

			20% {
				-webkit-transform: rotate3d(0, 0, 1, -5deg);
				transform: rotate3d(0, 0, 1, -5deg);
			}

			25%, to {
				-webkit-transform: rotate3d(0, 0, 1, 0deg);
				transform: rotate3d(0, 0, 1, 0deg);
			}
		}
		.logo {
			transform-origin: top center;
			animation-name: swing;
			animation-iteration-count: infinite;
			animation-duration: 3s;
			animation-fill-mode: both;
			animation-timing-function: ease-in-out;
		}';

		$response = new DataDisplayResponse($css, Http::STATUS_OK, ['Content-Type' => 'text/css']);

		$ttl = 31536000;
		$response->addHeader('Cache-Control', 'max-age=' . $ttl . ', immutable');

		$expires = new \DateTime();
		$expires->setTimestamp($this->timeFactory->getTime());
		$expires->add(new \DateInterval('PT' . $ttl . 'S'));
		$response->addHeader('Expires', $expires->format(\DateTime::RFC1123));
		$response->addHeader('Pragma', 'cache');

		return $response;
	}

}
