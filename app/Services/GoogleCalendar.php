<?php
namespace App\Services;

class GoogleCalendar{

	public static function getClient()
	{
		$client = new \Google_Client();
		$client->setApplicationName(config('app.name'));
		$client->setScopes(\Google_Service_Calendar::CALENDAR_READONLY.' '.\Google_Service_Oauth2::USERINFO_PROFILE.' '.\Google_Service_Oauth2::USERINFO_EMAIL);
		$client->setAuthConfig(storage_path('keys/client_secret.json'));
		$client->setAccessType('offline');

		return $client;
	}


	/**
	 * Returns an authorized API client.
	 * @return Google_Client the authorized client object
	 */

	public static function oauth()
	{

        $client = self::getClient();

        // Load previously authorized credentials from a file.	
        $credentialsPath = storage_path('keys/client_secret_generated.json');
        if (!file_exists($credentialsPath)) {
         	return false;
        }

        $accessToken = json_decode(file_get_contents($credentialsPath), true);

        if(!$accessToken) return false;
        $client->setAccessToken($accessToken);

        // Refresh the token if it's expired.
        if ($client->isAccessTokenExpired()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
        }

        return $client;
	}

	public static function getResources($client)
	{
		$oauth2 = new \Google_Service_Oauth2($client);
		$userInfo = $oauth2->userinfo->get();
		
		$service = new \Google_Service_Calendar($client);
		// On the user's calenda print the next 10 events .

		$calendarId = $userInfo->email;

		$optParams = array(
		  'maxResults' => 10,
		  'orderBy' => 'startTime',
		  'singleEvents' => true,
		  'timeMin' => date('c'),
		);

		$results = $service->events->listEvents($calendarId, $optParams);
		$events = $results->getItems();
		return $events;
	}

	public static function getUserInfo(){

	}
}