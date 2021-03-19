<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Models\{UserNotification, Polo};
use Twilio\Rest\Client;

class DebugController extends Controller
{
	public function testUserNotification()
	{
		$user = User::find(1);
		UserNotification::create([
			"user_id" => $user->id,
			"data" => [
				"message" => "Lorem ipsum dolor sit amet, <b>consectetur adipiscing elit</b>. Morbi nisi elit, condimentum et velit eget, <b>finibus condimentum eros</b>. Proin viverra aliquet purus, id sodales erat facilisis varius. Donec quis tortor in augue mattis malesuada quis nec augue. Lorem ipsum dolor sit amet, consectetur adipiscing eli",
				"icon" => "el-icon-picture-outline-round",
				"url" => "https://www.google.com"
			]
		]);

		return ['success' => true];
	}

	public function testPoloNotification()
	{
		$polo = Polo::find(8);
		for ($y = 0; $y < 20; $y++) {
			foreach ($polo->getAllPossibleUsers() as  $user) {
				UserNotification::create([
					"user_id" => $user->id,
					"data" => [
						"message" => "Lorem ipsum dolor sit amet, <b>consectetur adipiscing elit</b>. Morbi nisi elit, condimentum et velit eget, <b>finibus condimentum eros</b>",
						"icon" => "el-icon-s-ticket",
						"url" => "https://www.google.com"
					]
				]);
			}
		}
		return ['success' => true];
	}

	public function testWpp()
	{
		$curl = curl_init();
		$chave = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiYjg0MzFkODgyYWFjOTNjMTYxZjBkYjE4YWI3ZmNmOWYyYzk3MDE5YzI1NDFlNmZhN2JmZjRhNjdiMWQ1NzMyMzY5ODZjMTA0ZTQ3NTQ4OTAiLCJpYXQiOjE2MTU1ODkyNTQsIm5iZiI6MTYxNTU4OTI1NCwiZXhwIjoxNjQ3MTI1MjU0LCJzdWIiOiIyNzQxIiwic2NvcGVzIjpbXX0.i_2oH054WnnnHQmyPzeP4RweRntCm2YDjrWSvlzlo1KfHAJIYxDukzG54hku57f-vnBRhq45j-aocNJIORKIHewyvBCTZbujf4lTXTPoYYZWucPB1HxtTKhbmBmxG8rly7fsCgYSKLdxUA_PsZOEVPwnO7SObwFxZm4aQVRgSdjEQGiNAH07LNryWc5BnXt9S0HUXMr-2emrnQ9wfflr9at0gCr_o4WwquiHVkAyfH_-dxXUMGqYrbOdTMqKY7-X0uFo0zQliw5KoCdlUlLSa3KKuosM_YjcLJRBfF-p6VuHyv5M_cYCrUFn9-lSLw-yUqLDWs-MaJ98iXjBxH-LcXQybBcstP9GrHkQViJDVxozApAIfa9KnOlOTREWtjFcVZbrJK385qgMXjx4cQt4lgU61Sk9Xr5TlBSrC6QWiW819UU9ZCFonkQ8PEJhuZNb8Os754Ol2FXUW1UWzslLUPT4i7_9SJF-gow1pqufQRH7TNDC0UtYukF6AsuUBeaDMNRNo9Wg5T8CO82TC2JrQVxOlg8kJArFR73NiumuMiZUCMuopXKRpeGpt2eWQJcQqUzIveR5nvgMsLzlbzIXiGmar1SLPJfuwL05Qd0YIejZKzeAI4KvoEIDlZSIuYcLdp2hZlm0LdJjAqr97IO3pOQe5cxWcPVmdvzQtFvfhi8";
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://api.positus.global/v2/sandbox/whatsapp/numbers/{{chave}}/messages",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\r\n  \"to\": \"+5514996766177\",\r\n  \"type\": \"text\",\r\n  \"text\": {\r\n      \"body\": \"your-message-content\"\r\n  }\r\n}",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"Authorization: Bearer $chave"
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
	}
}
