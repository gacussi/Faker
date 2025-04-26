<?php
header("Content-Type: application/json");

// Receber dados da requisição
$input = json_decode(file_get_contents("php://input"), true);

if (isset($input['message'])) {
    $userMessage = $input['message'];

    // Processar a mensagem (lógica do bot)
    $response = "Você disse: " . htmlspecialchars($userMessage);

    // Retornar resposta como JSON
    echo json_encode(["response" => $response]);
} else {
    // Retornar erro caso a mensagem não seja recebida
    http_response_code(400);
    echo json_encode(["error" => "Mensagem não recebida."]);
}
?>
