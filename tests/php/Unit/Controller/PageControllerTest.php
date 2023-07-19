<?php

namespace OCA\FormMail\Tests\Unit\Controller;

use OCA\FormMail\Controller\PageController;

use OCA\FormMail\Db\FormResponseMapper;
use OCP\AppFramework\Http\JSONResponse;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use PHPUnit\Framework\TestCase;

class PageControllerTest extends TestCase {
	private $controller;
	private $mapper;

	
	public function setUp(): void {
		parent::setUp();
		$this->dbConnection = \OC::$server->getDatabaseConnection();
		$this->mapper = new FormResponseMapper($this->dbConnection);
	}

	public function testIndex() {
		$request = $this->createMock(IRequest::class);
		$controller = new PageController(
			'formmail', $request, $this->mapper
		);

		$response = $controller->index();

		$body = $response->render();
		$this->assertStringContainsString('Download CSV', $body);
		$this->assertEquals('index', $response->getTemplateName());
		$this->assertTrue($response instanceof TemplateResponse);
	}

	public function testSaveWithInvalidParams() {
		$request = $this->createMock(IRequest::class);
		$request->post = [];
		$controller = new PageController(
			'formmail', $request, $this->mapper
		);
		$response = $controller->save();

		// $response = new JSONResponse($error)
		$body = $response->render();
		$this->assertEquals(
			'["Invalid email","Invalid name","Invalid identity","Invalid message","Invalid phone"]',
			$body
		);
		$this->assertTrue($response instanceof JSONResponse);
	}

}
