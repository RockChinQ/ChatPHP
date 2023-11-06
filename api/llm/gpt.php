<?php
try{
    require('../../vendor/autoload.php');

    $yourApiKey = getenv("OPENAI_API_KEY");
    $client = OpenAI::client($yourApiKey);

    $result = $client->chat()->create([
        'model' => $_POST['model'],
        'messages' => json_decode($_POST['messages']),
    ]);

    header('Content-Type: application/json');
    // echo $result->choices[0]->message->content; // an open-source, widely-used, server-side scripting language.
    echo json_encode(array("code" => "0", "msg" => "ok", "data" => $result, 'model' => $_POST['model'], 'messages' => json_decode($_POST['messages'])));
} catch (Exception $e) {
    echo json_encode(array("code" => "-1", "msg" => $e -> getMessage()));
}
?>