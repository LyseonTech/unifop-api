<?php

namespace OCA\FormMail\Controller;

use OCA\FormMail\Db\FormResponse;
use OCA\FormMail\Db\FormResponseMapper;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\Attribute\AnonRateLimit;
use OCP\AppFramework\Http\Attribute\NoAdminRequired;
use OCP\AppFramework\Http\Attribute\NoCSRFRequired;
use OCP\AppFramework\Http\Attribute\PublicPage;
use OCP\AppFramework\Http\DataDownloadResponse;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;

class PageController extends Controller {
	public function __construct(
		$AppName,
		IRequest $request,
		private FormResponseMapper $mapper
	) {
		parent::__construct($AppName, $request);
		$this->mapper = $mapper;
	}

	#[NoCSRFRequired]
	public function index() {
		return new TemplateResponse('formmail', 'index');  // templates/index.php
	}

	/**
	 * Download CSV
	 */
	#[NoCSRFRequired]
	public function download(): DataDownloadResponse {
		$responses = $this->mapper->findAll();
		$handle = fopen('php://memory', 'r+');

		fputcsv($handle, array_keys($responses[0]->serialize()));
		foreach ($responses as $response) {
			fputcsv($handle, $response->serialize());
		}

		rewind($handle);
		$output = stream_get_contents($handle);
		fclose($handle);

		$response = new DataDownloadResponse($output, date('Ymd_His') . '.csv', 'text/csv');
		return $response;
	}

	#[NoAdminRequired]
	#[NoCSRFRequired]
	#[PublicPage]
	#[AnonRateLimit(limit:1, period:100)]
	public function save() {
		$response = new JSONResponse();
		$response->addHeader('Access-Control-Allow-Origin', '*');
		$post = $this->request->post;
		$error = [];
		if (!isset($post['email']) || !filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
			$error[] = 'Invalid email';
		}
		if (!isset($post['name']) || strlen($post['name']) < 3) {
			$error[] = 'Invalid name';
		}
		if (!isset($post['identity']) || strlen($post['identity']) < 3) {
			$error[] = 'Invalid identity';
		}
		if (!isset($post['message']) || strlen($post['message']) < 3) {
			$error[] = 'Invalid message';
		}
		$phone = isset($post['phone'])?$post['phone']:null;
		preg_replace('/\D/', '', $phone);
		if (!is_numeric($phone) || strlen($phone) < 9) {
			$error[] = 'Invalid phone';
		}
		if ($error) {
			$response->setData($error);
			$response->setStatus(400);
			return $response;
		}
		$formResponse = new FormResponse();
		$formResponse->setEmail($post['email']);
		$formResponse->setName($post['name']);
		$formResponse->setIdentity($post['identity']);
		$formResponse->setMessage($post['message']);
		$formResponse->setPhone($post['phone']);
		$this->mapper->insert($formResponse);
		$response->setData(['success' => ['success' => 'Success']]);
		return $response;
	}
}
