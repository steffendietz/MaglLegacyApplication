<?php

/**
 * @author Steffen Dietz <steffo.dietz@gmail.com>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplication\Controller;

use MaglLegacyApplication\Options\LegacyControllerOptions;
use Zend\Http\Header\GenericHeader;
use Zend\Http\Headers;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * This controller is here to serve static files from the configured document root
 * in case this document root is not reachable for the web server.
 */
class LegacyStaticController extends AbstractActionController
{

	/**
	 *
	 * @var LegacyControllerOptions
	 */
	private $options;

	public function __construct(LegacyControllerOptions $options)
	{
		$this->options = $options;
	}

	public function indexAction()
	{
		$docroot = getcwd() . '/' . $this->options->getDocRoot();
		$docroot = rtrim($docroot, '/');

		$staticName = $this->params('static');

		$staticUri = '/' . ltrim($staticName, '/'); // force leading '/'
		$legacyStaticFilename = $docroot . $staticUri;

		/** @var Response $response */
		$response = $this->getResponse();

		if (!file_exists($legacyStaticFilename)) {
			// if we're here, the file doesn't really exist and we do not know what to do
			$response->setStatusCode(404);
			return;
		}

		$mimeType = null;
		$extension = pathinfo($legacyStaticFilename, PATHINFO_EXTENSION);
		switch(strtolower($extension)) {
			case 'css':
				$mimeType = 'text/css';
				break;
			case 'js':
				$mimeType = 'text/javascript';
				break;
			case 'jpg':
			case 'jpeg':
				$mimeType = 'image/jpeg';
				break;
			case 'png':
				$mimeType = 'image/png';
				break;
			case 'gif':
				$mimeType = 'image/gif';
				break;
		}
		if($mimeType !== null) {
			$header = new GenericHeader('Content-Type', $mimeType);
			$response->getHeaders()->addHeader($header);
		}
		$response->setContent(file_get_contents($legacyStaticFilename));

		return $response;
	}

}