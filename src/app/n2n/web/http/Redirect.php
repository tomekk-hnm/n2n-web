<?php
/*
 * Copyright (c) 2012-2016, Hofmänner New Media.
 * DO NOT ALTER OR REMOVE COPYRIGHT NOTICES OR THIS FILE HEADER.
 *
 * This file is part of the N2N FRAMEWORK.
 *
 * The N2N FRAMEWORK is free software: you can redistribute it and/or modify it under the terms of
 * the GNU Lesser General Public License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * N2N is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details: http://www.gnu.org/licenses/
 *
 * The following people participated in this project:
 *
 * Andreas von Burg.....: Architect, Lead Developer
 * Bert Hofmänner.......: Idea, Community Leader, Marketing
 * Thomas Günther.......: Developer, Hangar
 */
namespace n2n\web\http;

use n2n\core\N2N;

/**
 * Causes a http redirect when sent to {@see Response}
 */
class Redirect extends BufferedResponseObject {
	private $httpStatus;
	private $httpLocation;
	
	/**
	 * @param string $httpLocation
	 * @param int $httpStatus
	 */
	public function __construct(string $httpLocation, int $httpStatus = null) {
		$this->httpStatus = $httpStatus;
		$this->httpLocation = $httpLocation;
		
		if (empty($this->httpStatus)) {
 			$this->httpStatus = Response::STATUS_302_FOUND;
		}
	}
	
	/**
	 * (non-PHPdoc)
	 * @see n2n\web\http.ResponseObject::prepareForResponse()
	 */
	public function prepareForResponse(Response $response) {
		$response->setStatus($this->httpStatus);
		$response->setHeader('Content-Type: text/html; charset=' . N2N::CHARSET);
		$response->setHeader('Location: ' . $this->httpLocation);
	}
	
	/**
	 * {@inheritDoc}
	 * @see \n2n\web\http\ResponseObject::getBufferedContents()
	 */
	public function getBufferedContents(): string {
		return '';
	}
	
	/**
	 * (non-PHPdoc)
	 * @see n2n\web\http.ResponseObject::toKownResponseString()
	 */
	public function toKownResponseString(): string {
		return $this->httpStatus . ' redirect to \'' . $this->httpLocation . '\'';
	}
}
