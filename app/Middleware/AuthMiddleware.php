<?php
/**
 * Created by PhpStorm.
 * User: shiblie
 * Date: 11/13/16
 * Time: 4:13 PM
 */

namespace App\Middleware;


class AuthMiddleware extends Middleware {

	public function __invoke($request, $response, $next) {

		if (!$this->container->auth->check()) {
			$this->container->flash->addMessage('danger', 'Please sign in to continue.');
			return $response->withRedirect($this->container->router->pathFor('auth.signin'));
		}

		$response = $next($request, $response);
		return $response;
	}

}
