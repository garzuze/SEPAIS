<?php

function generate_jwt($headers, $payload, $secret = 'SomosOsSepinhosBananaoDoChicao') {
	$headers_encoded = base64url_encode(json_encode($headers));
	
	$payload_encoded = base64url_encode(json_encode($payload));
	
    $secret_encoded = base64_encode($secret);
	
    $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret_encoded, true);
	$signature_encoded = base64url_encode($signature);
	
	$jwt = "$headers_encoded.$payload_encoded.$signature_encoded";
	
	return $jwt;
}

function is_jwt_valid($jwt, $secret = 'SomosOsSepinhosBananaoDoChicao') {
	// Splitar o JWT e decodificar informações
	$tokenParts = explode('.', $jwt);
	$header = base64_decode($tokenParts[0]);
	$payload = base64_decode($tokenParts[1]);
	$signature_provided = $tokenParts[2];
    $secret_encoded = base64_encode($secret);

	// Checar se token expirou
	$expiration = json_decode($payload)->exp;
	$is_token_expired = ($expiration - time()) < 0;

	// Criar uma signature baseado no header e no payload com a senha
	$base64_url_header = base64url_encode($header);
	$base64_url_payload = base64url_encode($payload);
	$signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
	$base64_url_signature = base64url_encode($signature);

	// Verificar se as signatures coincidem
	$is_signature_valid = ($base64_url_signature === $signature_provided);
	
	if ($is_token_expired || !$is_signature_valid) {
		return FALSE;
	} else {
		return TRUE;
	}
}

function base64url_encode($str) {
    return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
}