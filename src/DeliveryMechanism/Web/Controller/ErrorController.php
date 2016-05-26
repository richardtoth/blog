<?php

namespace Refaktor\Blog\DeliveryMechanism\Web\Controller;

class ErrorController {
	public function notFound() {
		return [];
	}

	public function methodNotAllowed($allowedMethods) {
		return ['allowedMethods' => $allowedMethods];
	}
}