<?php
echo "I am a bot";

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'my_voice_is_my_password_verfiy_me') {
  echo $challenge;
}

$input = json_decode(file_get_contents('php://input'), true);
error_log(print_r($input, true));
