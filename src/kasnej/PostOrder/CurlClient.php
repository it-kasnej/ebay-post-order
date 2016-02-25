<?php

namespace kasnej\PostOrder;

use kasnej\PostOrder\Exception\ClientException;

class CurlClient implements HttpClient
{
	/**
	 * @param string $method
	 * @param string $uri
	 * @param string[] $headers
	 * @param array $body
	 * @return string
	 * @throws ClientException
	 */
	public function send($method, $uri, array $headers = array(), array $body = array())
	{
		$ch = curl_init();
		$uri = $this->updateUri($method, $uri, $body);

		if ($method != self::GET) {
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
		}

		curl_setopt($ch, CURLOPT_URL, $uri);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$output = curl_exec($ch);

		if (false === $output) {
			$message = 'Curl error "'.curl_error($ch)."\" \nCurl error number ".curl_errno($ch)." see http://curl.haxx.se/libcurl/c/libcurl-errors.html";
			curl_close($ch);
			throw new ClientException($message);
		}
		
		curl_close($ch);

		return $output;
	}

	/**
	 * @param string $method
	 * @param string $uri
	 * @param array $body
	 * @return string
	 */
	private function updateUri($method, $uri, array $body)
	{
		if (self::GET == $method) {
			$uri .= '/' . http_build_query($body);
		}

		return $uri;
	}
}
