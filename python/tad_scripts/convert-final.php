<?php

// curl -s -F password="admin" "http://localhost:8089/users/admin/login"
// curl -s -F password="Nz:vbW}4$pQ`CUDh" "http://lac-archives-test.is.ed.ac.uk:8089/users/gvanbre/login"
// curl -H "X-ArchivesSpace-Session: $SESSION" "http://localhost:8089/repositories/101/archival_objects/1/children"
//
// /d/xampp/php/php.exe convert.php --test --2 --flag --tags --qualifyRA --qualifyIA --tacl --update | tee full.test.--2

// Full data load for agents on local = 4hours.

// /d/xampp/php/php.exe convert-final.php --test --agents --flag --tags --qualifyRA --qualifyIA --tacl --update --limit | tee update.test.--2
// /d/xampp/php/php.exe convert-final.php --test --tracks --flag --tags --qualifyRA --qualifyIA --tacl --update --limit | tee update.test.--3
// /d/xampp/php/php.exe convert-final.php --test --tapes --flag --tags --qualifyRA --qualifyIA --tacl --update --limit | tee update.test.--4

// /d/xampp/php/php.exe convert-final.php --live --agents --tags --qualifyRA --qualifyIA --tacl --update | tee create.live.--2
// /d/xampp/php/php.exe convert-final.php --live --tracks --tags --qualifyRA --qualifyIA --tacl --update | tee create.live.--3
// /d/xampp/php/php.exe convert-final.php --live --tapes --tags --qualifyRA --qualifyIA --tacl --update | tee create.live.--4.1

// Lookups required
// Tapes need
//  A repository ID
//  A resource ID
//  A level of series
//  Extent type lookups must include ttype values, plus "Undefined"
//  Language codes eng, gla, sco
//
// Tracks need
//  Y : A repository ID
//  Y : A resource ID
//  Y : A level of item
//  A : Extent type "digital file"
//  Y : date_type lookup includes "inclusive","single"
//  date certainty lookup includes "approximate",'certain'
//  Y : Linked agent role: creator
//  A : Linked agent relator: cbt, ivr, "Fieldworker"
//  Genre and location vocabulary
//
// Agent
//  Y : source include "TaD English" "TaD Gaelic"

// I need permission to delete agents and archival objects

// &tf(}9VZY4Xs*!m<

// Database
$host="localhost";
$port="5432";
$dbname="TOBAR";
$username="postgres";
$password="postgres";
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$username;password=$password";

// API
$env = 'dev';
$api = [
	'dev' => [
		"base" => "http://localhost:8089",
		"user" => "admin",
		"password" => "admin",
		"agentColumn" => "dev_remote_agent_id",
		"tapeColumn" => "dev_remote_resource_id",
		"trackColumn" => "dev_remote_object_id",
		// Repository Test/"GvB test" = 101
		"repositoryId" => 101,
		// Fonds "test resource" = resource 1
		"resourceId" => 1,
		// Sub-Fonds "Test Collection" = archival object 1
		// Item "test item" = resource 2
		"sources" => ["s" => 1, "b" => 1, "c" => 1],
		"vocabularies" => ["genre" => 1, "location" => 1],
		"languageMode" => "object"
	],
	'test' => [
		"base" => "http://lac-archives-test.is.ed.ac.uk:8089",
		"user" => "gvanbre",
		"password" => "%9W;:CN93p#T)HfM",
		"agentColumn" => "test_remote_agent_id",
		"tapeColumn" => "test_remote_resource_id",
		"trackColumn" => "test_remote_object_id",
		// Repository "TaD test" = 18
		"repositoryId" => 18,
		// Fonds "Tobar an Dualchais" = resource 86851
		"resourceId" => 86851,
		// Sub-Fonds "SOSS" = archival object 161692
		// Series (Tape) "SA1979.134" = archival object 161699 (original tape_id 8267)
		// Item (Track) "Spaewives and witches" = archival object 161700
		// Sub-Fonds "BBC" = archival object 161693
		// Sub-Fonds "NTOS Canna" = archival object 161694
		"sources" => ["s" => 161692, "b" => 161693, "c" => 161694],
		"vocabularies" => ["genre" => 1, "location" => 1],
		"languageMode" => "object" /* "note" */
	],
	'live' => [
		"base" => "http://lac-archivesspace-live2.is.ed.ac.uk:8089",
		"user" => "gvanbre",
		"password" => "f0r-ch@ng1ng",
		"agentColumn" => "live_remote_agent_id",
		"tapeColumn" => "live_remote_resource_id",
		"trackColumn" => "live_remote_object_id",
		"repositoryId" => 2, // Repository "TaD sandbox"
		"resourceId" => 1, // Fonds "Tobar an Dualchais" = resource 1
		"sources" => ["s" => 110465, "b" => 110466, "c" => 110467],
		"vocabularies" => ["genre" => 1, "location" => 2],
		"languageMode" => "object" /* "note" */
	]
];
$apiSession="";

$lookUps = [
	// Agents
	"gender" => [
		"M" => 'Male',
		'F' => 'Female',
		'O' => 'Other'
	],
	"trace_status" => [
		"0" => "Not attempted yet",
		"1" => "Traced - possible",
		"2" => "Traced - certain",
		"3" => "Untraceable"
	],
	"copyright-source" => [
		"b" => "BBC",
		"c" => "Canna",
		"s" => "SOSS"
	],
	"copyright-statement" => [
		"0" => "Not sought",
		"1" => "Granted",
		"2" => "Verify",
		"3" => "Refused",
		"4" => "Granted-Pending",
		"5" => "Risk management"
	],
	// Tapes
	"catalogue_status" => [
		"0" => "Completed",
		"1" => "Verified",
		"2" => "Redirected",
		"3" => "Returned",
		"4" => "Not started",
		"5" => "Started",
		"6" => "MP3 damaged"
	],
	"ttype" => [
		"0" => "Born Digital",
		"1" => "Cassette",
		"2" => "CD",
		"3" => "Cylinder",
		"4" => "DAT",
		"5" => "Disc",
		"6" => "Minidisc",
		"7" => "Reel to Reel",
		"8" => "Wire",
		"9" => "Microcassette",
		"10" => "Digital",
		"11" => "Wav"
	],
	"copy" => [
		"o" => 'Copy of original',
		'c' => 'Original',
	],
	"tformat" => [
		"0" => "Four Track",
		"1" => "Full track",
		"2" => "Half track (mono)",
		"3" => "Other",
		"4" => "Twin Track (Stereo)",
		"5" => "Two Track (Mono)"
	],
	"manufacturer" => [
		"0" => "AGFA",
		"1" => "Ampex",
		"2" => "Astropulse",
		"3" => "Audiotape",
		"4" => "BASF",
		"5" => "Currys",
		"6" => "Durex",
		"7" => "EMI",
		"8" => "Fuji",
		"9" => "Grundig",
		"10" => "i",
		"11" => "Just",
		"12" => "Mastertape",
		"13" => "Maxell",
		"14" => "Memorex",
		"15" => "Miracle Mart",
		"16" => "MSS",
		"17" => "Uspecific",
		"18" => "NA",
		"19" => "Philips",
		"20" => "Plaza",
		"21" => "Pyral",
		"22" => "Quantegy",
		"23" => "Realistic",
		"24" => "Scotch",
		"25" => "Sonotape",
		"26" => "Sony",
		"27" => "Soundcraft",
		"28" => "Synchrotape",
		"29" => "TDK",
		"30" => "UDI",
		"31" => "Unknown",
		"32" => "Webcor",
		"33" => "Wilcox-Gay",
		"34" => "XHE",
		"35" => "Zonal",
		"36" => "Zonatape",
		"37" => "zz"
	],
	"site" => [
		"s" => "SOSS",
		"u" => "Uist",
	],
	"delivery" => [
		"i" => "Internet (ftp/http)",
	],
	"tape-state" => [
		"0" => "Not entered",
		"10" => "Duplicate",
		"20" => "Entered",
		"40" => "Baking",
		"50" => "Wav exists",
		"60" => "MP3 exists",
		"70" => "To catalogue",
		"75" => "Being catalogued",
		"80" => "Catalogued",
		"90" => "Indexed",
		"100" => "Completed",
		"120" => "Verified",
		"150" => "Unknown"
	],
	// Tracks
	"track-status" => [
		"o" => "Audio OK",
		"g" => "Gap",
		"i" => "Incomplete",
		"u" => "Audio unusable",
		"c" => "Continuation",
		"r" => "Commercial recording",
	],
	"publication-restrictions" => [
		"0" => "Not licensed for publication (comm rec)",
		"1" => "Track content unsuitable for publication",
		"2" => "Restricted by contributor/fieldworker",
		"3" => "Restricted by SOSS"
	],
	"audio-quality" => [
		"g" => "Good",
		"f" => "Fair",
		"p" => "Poor"
	],
	"language-level" => [
		"d" => "General - Difficult",
		"m" => "General - Medium",
		"s" => "General - Simple",
		"t" => "Technical"
	],
	"computed-copyright-statement" => [
		"0" => "Not sought",
		"5" => "Risk management",
		"10" => "Refused",
		"13" => "Granted - pending",
		"14" => "Granted",
		"30" => "Never Computed"
	]
];

$locations = [];
$subjectGenres = [];

//*************************************************************************************************
// 
//
function getApiSession() {
	global $api;
	global $env;
	global $apiSession;

	echo "Initialising CURL session to " . $api[$env]["base"].'/users/'.$api[$env]["user"].'/login' . "\n";
	$session = curl_init($api[$env]["base"].'/users/'.$api[$env]["user"].'/login');
	curl_setopt($session, CURLOPT_HEADER, TRUE);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($session, CURLOPT_POST, 1);
	curl_setopt($session, CURLOPT_POSTFIELDS, ['password'=>$api[$env]["password"]]);
	$response = curl_exec($session);
	if (curl_errno($session)) {
		echo "cUrl POST request failed. Please check cUrl is installed on the server.\n";
		echo 'Error number: ' . curl_errno($session) . "\n";
		echo 'Error: ' . curl_error($session) . "\n";
		echo "Server response ";
		echo $response;
		exit(0);
	}
	curl_close($session);
	$response = explode("\r\n\r\n", $response);
	// echo "Reponse:\n" . print_r($response = json_decode($response[1]), true);
	$apiSession = json_decode($response[count($response)-1])->session;
}

function getApi($conn, $endpoint) {
	global $api;
	global $env;
	global $apiSession;

	$start = date("H:i:s");
	// echo "Getting " . $api[$env]["base"].$endpoint . "\n";
	$session = curl_init($api[$env]["base"].$endpoint);
	curl_setopt($session, CURLOPT_HEADER, TRUE);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
	$httpHeader = [];
    $httpHeader[] = 'X-ArchivesSpace-Session: '.$apiSession;
	curl_setopt($session, CURLOPT_HTTPHEADER, $httpHeader);

	$response = curl_exec($session);
	if (curl_errno($session)) {
		echo "cUrl GET request failed. Please check cUrl is installed on the server.\n";
		echo 'Error number: ' . curl_errno($session) . "\n";
		echo "Server response ";
		echo $response;
		exit(0);
	}
	curl_close($session);
	$response2 = explode("\r\n\r\n", $response);
	$response2 = json_decode($response2[count($response2)-1]);
	if (isset($response2->error)) {
		echo $response;
		exit(0);
	}
	// echo "API Get ".$start."->".date("H:i:s")."\n";
	return $response2;
}

function saveApi($conn, $obj, $endpoint, $migrationTable, $tableColumn, $tableRemoteColumn, $localId, $update) {
	global $api;
	global $env;
	global $apiSession;
	global $verbose;
	global $limit;
	
	if ($verbose)
		echo 'Sending ' . print_r($obj, true) . ' to ' . $api[$env]["base"].$endpoint . PHP_EOL;
	echo "API Save ".date("H:i:s");
	$session = curl_init($api[$env]["base"].$endpoint);
	curl_setopt($session, CURLOPT_HEADER, TRUE);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
	$httpHeader = [];
    $httpHeader[] = 'X-ArchivesSpace-Session: '.$apiSession;
    $httpHeader[] = 'application/json';
	curl_setopt($session, CURLOPT_HTTPHEADER, $httpHeader);
	curl_setopt($session, CURLOPT_POST, 1);
	curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($obj));
	// print_r($obj);
	print_r(" (length " . strlen(json_encode($obj)) .")");
	//print_r(PHP_EOL . json_encode($obj) .PHP_EOL);
	$response = curl_exec($session);
	// echo $response;
	if (curl_errno($session)) {
		echo "\n\ncUrl POST request failed.\n";
		echo 'Error number: ' . curl_errno($session) . "\n";
		echo "Server response ";
		echo $response;
		exit(0);
	}
	curl_close($session);
	$response2 = explode("\r\n\r\n", $response);
	$response2 = json_decode($response2[count($response2)-1]);
	if (isset($response2->error)) {
		echo "\n\n";
		echo $response;
		exit(0);
	}
	// echo $response;
	echo "->".date("H:i:s")." Record ID " . $response2->id . "\n";
	if (!$update) {
		if (!$limit && $localId > $response2->id) {
			echo "Resaving to pad IDs : bringing " . $response2->id . " up to " . $localId . "\n";
			deleteApi($endpoint.'/'.$response2->id);
			return saveApi($conn, $obj, $endpoint, $migrationTable, $tableColumn, $tableRemoteColumn, $localId, $update);
		} else {
			$query = 'INSERT INTO ' . $migrationTable . ' SELECT ' . $localId . ' as ' . $tableColumn . ' WHERE ' . $localId . ' NOT IN (SELECT ' . $tableColumn . ' from ' . $migrationTable . ');';
			// echo $query . PHP_EOL;
			$conn->exec($query);
			$query = 'UPDATE ' . $migrationTable . ' SET ' . $tableRemoteColumn . ' = ' . $response2->id . ' WHERE ' . $tableColumn . ' = ' . $localId . ';';
			// echo $query. PHP_EOL;
			$conn->exec($query);
			// exit(0);
		}
	}
	return $response2->id;
}

function deleteApi($endpoint) {
	global $api;
	global $env;
	global $apiSession;
	global $verbose;
	
	if ($verbose)
		echo 'DELETING ' . $api[$env]["base"].$endpoint . PHP_EOL;
	echo "API DELETE ".date("H:i:s");
		
	$session = curl_init($api[$env]["base"].$endpoint);
	curl_setopt($session, CURLOPT_HEADER, TRUE);
	curl_setopt($session, CURLOPT_RETURNTRANSFER, TRUE);
	$httpHeader = [];
    $httpHeader[] = 'X-ArchivesSpace-Session: '.$apiSession;
    $httpHeader[] = 'application/json';
	curl_setopt($session, CURLOPT_HTTPHEADER, $httpHeader);
    curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");

	$response = curl_exec($session);
	// echo $response;
	if (curl_errno($session)) {
		echo "\n\ncUrl DELETE request failed.\n";
		echo 'Error number: ' . curl_errno($session) . "\n";
		echo "Server response ";
		echo $response;
		exit(0);
	}
	curl_close($session);
	$response2 = explode("\r\n\r\n", $response);
	$response2 = json_decode($response2[count($response2)-1]);
	if (isset($response2->error)) {
		echo "\n\n";
		echo $response;
		exit(0);
	}
	// echo $response;
	echo "->".date("H:i:s")."\n";
}

//*************************************************************************************************
// 
//

function unsetNote(&$notes, $label)
{
	$found = FALSE;
	foreach($notes as $idx => $note) {
		if ($note->label === $label) {
			unset($notes[$idx]);
			$notes = array_values($notes);
			return;
		}
	}
}

function setSinglePartNote(&$notes, $label, $type, $content)
{
	$found = FALSE;
	foreach($notes as $idx=>$note) {
		if ($note->label === $label) {
			// move to end
			unset($notes[$idx]);
			$notes = array_values($notes);
			$found = count($notes);
			$notes[] = $note;
			break;
		}
	}
	if ($found === FALSE) {
		$found = count($notes);
		$notes[] = (object)[
			"jsonmodel_type" => "note_singlepart",
			"label" => $label
		];
	}
	$notes[$found]->type = $type;
	$notes[$found]->content = (is_array($content) ? $content : [$content]);
	foreach ($notes[$found]->content as $index => $value) {
		$notes[$found]->content[$index] = str_replace('%', "&percnt;", $value);
	}
}

function setSinglePartNoteCheckNull(&$notes, $label, $type, $content) {
	if (empty($content)) {
		unsetNote($notes, $label);
	} else {
		setSinglePartNote($notes, $label, $type, $content);
	}
}

function setMultiPartNote(&$notes, $label, $type, $content)
{
	$found = FALSE;
	foreach($notes as $idx=>$note) {
		if ($note->label === $label) {
			// move to end
			unset($notes[$idx]);
			$notes = array_values($notes);
			$found = count($notes);
			$notes[] = $note;
			break;
		}
	}
	if ($found === FALSE) {
		$found = count($notes);
		$notes[] = (object)[
			"jsonmodel_type" => "note_multipart",
			"label" => $label
		];
	}
	$notes[$found]->type = $type;
	if (is_array($content)) {
		$notes[$found]->subnotes = [];
		foreach($content as $entry) {
			$notes[$found]->subnotes[] = (object)["jsonmodel_type" => "note_text", "content" => $entry];
		}
	} else {
		$notes[$found]->subnotes = [(object)["jsonmodel_type" => "note_text", "content" => $content]];
	}
	foreach ($notes[$found]->subnotes as $index => $subnote) {
		$notes[$found]->subnotes[$index]->content = str_replace('%', "&percnt;", $subnote->content);
	}
}

function setMultiPartNoteCheckNull(&$notes, $label, $type, $content) {
	if (empty($content)) {
		unsetNote($notes, $label);
	} else {
		setMultiPartNote($notes, $label, $type, $content);
	}
}


//*************************************************************************************************
// 
//
function processTape($conn, $dbRow) {
	global $api;
	global $env;
	global $flag;
	global $lookUps;

	$notes = [];
	if (!empty($dbRow['remote_id'])) {
		// echo "Processing Tape ". $dbRow["ext_id"] . "\n";
		$apiObject = getApi($conn, '/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $dbRow['remote_id']);
		unset($apiObject->position);
	} else {
		// Using series for tape.
		$apiObject = (object)[
			"jsonmodel_type" => "archival_object",
			"level" => "series",
			"notes" => [],
			"resource" => (object)[
				"ref" => "/repositories/" . $api[$env]["repositoryId"] . '/resources/' . $api[$env]["resourceId"]
			]
		];
	}
	$apiObject->title = $dbRow["ext_id"] . ($flag ? " [Migration]" : "");
	if (empty($apiObject->title)) {
		$apiObject->title = "[Unknown title]";
	}
	if (empty($apiObject->extents)) {
		$apiObject->extents = [(object)[
			"jsonmodel_type" => "extent",
			"portion" => "whole",
			"number" => "1",
			"extent_type" => "Undefined"
		]];
	}
	if ($dbRow['ttype'] !== null && $dbRow['ttype'] !== "") {
		$apiObject->extents[0]->extent_type = $lookUps["ttype"][strval($dbRow['ttype'])];
	}
	// $apiObject->extents[0]->extent_type = "reels";
	$apiObject->extents[0]->physical_details =
		(!empty($dbRow['stereo']) ? 'Stereo' . "\n" : '') .
		($dbRow['tformat'] !== null && $dbRow['tformat'] !== "" ? 'Format : ' . $lookUps["tformat"][strval($dbRow['tformat'])] . "\n" : '') .
		($dbRow['manuf'] !== null && $dbRow['manuf'] !== "" ? 'Manufacturer : ' . $lookUps["manufacturer"][strval($dbRow['manuf'])] . "\n" : '') .
		(!empty($dbRow['speed']) ? 'Recording speed : ' . $dbRow['speed'] . "\n" : '') .
		(!empty($dbRow['reel_size']) ? 'Reel size : ' . $dbRow['reel_size'] . "\n" : '');

	unsetNote($apiObject->notes, "Note");
	unsetNote($apiObject->notes, "Tape");
	unsetNote($apiObject->notes, "Tape ID");
	unsetNote($apiObject->notes, "Catalogue ID");
	unsetNote($apiObject->notes, "Catalogue Note");
	unsetNote($apiObject->notes, "Digitiser Note");
	unsetNote($apiObject->notes, "Batch");
	unsetNote($apiObject->notes, "MNDX");

	setMultiPartNoteCheckNull($apiObject->notes, 'Digitiser Note', 'phystech', $dbRow["note"]);
	setSinglePartNoteCheckNull($apiObject->notes, 'Tape Duration', 'materialspec', $dbRow["duration"]);
	// setSinglePartNote($apiObject->notes, 'Tape ID', 'abstract', [strval($dbRow['id'])]);
	setMultiPartNoteCheckNull($apiObject->notes, 'Metadata', 'processinfo', array_values(array_filter([
		"Tape ID : " . $dbRow['id'],
		empty($dbRow['archive']) ? null : "Tape archive location : " . $dbRow['archive'],
		$dbRow['status'] === null || $dbRow['status'] === "" ? null : "Tape state : " . $lookUps["tape-state"][strval($dbRow['status'])],
		empty($dbRow['site']) ? null : "Site : " . $lookUps["site"][$dbRow['site']],
		empty($dbRow['cat_id']) ? null : "Catalogue ID : " . $dbRow['cat_id'],
		$dbRow['cat_status'] === null || $dbRow['cat_status'] === "" ? null : "Catalogue status : " . $lookUps["catalogue_status"][strval($dbRow['cat_status'])],
		$dbRow['catnote'],
		empty($dbRow['batch_id']) ? null : "Batch ID : " . $dbRow['batch_id'],
		empty($dbRow['batch_site']) ? null : "Batch site : " . $lookUps["site"][$dbRow['batch_site']],
//			empty($dbRow['mp3']) ? null : "Original MP3 file : " . $dbRow['mp3'],
//			empty($dbRow['wav']) ? null : "Original WAV file : " . $dbRow['wav'],
//			empty($dbRow['bitrate']) ? null : "Original bitrate : " . $dbRow['bitrate'],
		empty($dbRow['copy']) ? null : 'Copy/original : ' . $lookUps["copy"][$dbRow['copy']],
		empty($dbRow['delivery']) ? null : 'MP3 sent by : ' . $lookUps["delivery"][$dbRow['delivery']],
	])));

	$apiObject->external_ids = [(object)["jsonmodel_type" => "external_id", "external_id" => strval($dbRow['id']), "source" => "Rescue site tape id"]];

	$query = "select sum(CASE WHEN lang_en = TRUE THEN 1 ELSE 0 END) as en,
sum(CASE WHEN lang_gd = TRUE THEN 1 ELSE 0 END) as gd,
sum(CASE WHEN lang_sco = TRUE THEN 1 ELSE 0 END) as sco,
sum(CASE WHEN lang_oth = TRUE THEN 1 ELSE 0 END) as oth
from catalogue_item ci
JOIN catalogue_track ct ON ci.track_id = ct.id
WHERE ct.tape_id = ".$dbRow['id'].";";
	// echo $query;
	if ($api[$env]["languageMode"] == 'object') {
		$apiObject->lang_materials=[];
	}
	$languageCodes = [];
	$languageNote = [];
	$languages = 0;
	foreach ($conn->query($query) as $row) {
		if ($row['en'] > 0) {
			$languages++;
			if ($api[$env]["languageMode"] == 'object') {
				$apiObject->lang_materials[] = (object)[
					"jsonmodel_type" => "lang_material",
					"language_and_script" => (object)[
						"jsonmodel_type" => "language_and_script",
						"language" => "eng"
					]];
			} else {
				$languageCodes[] = "eng";
				$languageNote[] = "English";
			}
		}
		if ($row['gd'] > 0) {
			$languages++;
			if ($api[$env]["languageMode"] == 'object') {
				$apiObject->lang_materials[] = (object)[
					"jsonmodel_type" => "lang_material",
					"language_and_script" => (object)[
						"jsonmodel_type" => "language_and_script",
						"language" => "gla"
					]];
			} else {
				$languageCodes[] = "gla";
				$languageNote[] = "Gaelic";
			}
		}
		if ($row['sco'] > 0) {
			$languages++;
			if ($api[$env]["languageMode"] == 'object') {
				$apiObject->lang_materials[] = (object)[
					"jsonmodel_type" => "lang_material",
					"language_and_script" => (object)[
						"jsonmodel_type" => "language_and_script",
						"language" => "sco"
					]];
			} else {
				$languageCodes[] = "sco";
				$languageNote[] = "Scots";
			}
		}
		if ($row['oth'] > 0) {
			$languages++;
			if ($api[$env]["languageMode"] == 'object') {
			/*
			$apiObject->lang_materials[] = (object)[
						"jsonmodel_type" => "lang_material",
						"lang" => 'Other'];
						*/
			} else {
				// $languageCodes[] = "oth";
				$languageNote[] = "Other";
			}
		}
	}
	if ($api[$env]["languageMode"] == 'note') {
		if ($languages>1) {
			$apiObject->language="mul";
		} else if ($languages === 1 && count($languageCodes)>0) {
			$apiObject->language = $languageCodes[0];
		} else {
			unset($apiObject->language);
		}
		setSinglePartNoteCheckNull($apiObject->notes, 'Languages', 'langmaterial', empty($languageNote) ? null : implode(', ', $languageNote));
	} else {
		unsetNote($apiObject->notes, "Languages");
	}		
	// setMultiPartNoteCheckNull($apiObject->notes, 'MNDX', 'scopecontent', $dbRow["mndx"]);

	$apiObject->external_documents = [];
	if (!empty($dbRow["mndx"])) {
		$mndxList = array_unique(str_getcsv($dbRow["mndx"], "," , "'"));
		foreach ($mndxList as $mndx) {
			$apiObject->external_documents[] = (object)[
				"jsonmodel_type" => "external_document",
				"title" => "MNDX Link for '" . $mndx . "'",
				"location" => "http://www-test.sssa-search.is.ed.ac.uk/mndxexpd2.cfm?wheresql=" . urlencode(" Numb LIKE '%" . $mndx . "%'")
			];
			// echo $mndx."\n";
		}
	}

	// Can't create a child of a parent directly, as that returns the id of the parent, not the child.
	// Add the AO, then (but only if on creation), move to be a child of the parent. Then pull all the tracks under it.
	// print_r($dbRow);
	// print_r($apiObject);
	echo "\n" . $dbRow['id'] . '/' . $dbRow['remote_id'] . ' ' . $apiObject->title . "\n";
	$migratedTapeId = saveApi($conn, $apiObject,
		'/repositories/' . $api[$env]["repositoryId"] . '/archival_objects' . (empty($dbRow['remote_id']) ? "" : "/".$dbRow['remote_id']),
		'tapeMigration',
		'tape_id',
		$api[$env]["tapeColumn"],
		$dbRow['id'],
		!empty($dbRow['remote_id']));
	
	if (empty($dbRow['remote_id'])) {
		echo "New Tape created : AS ID " . $migratedTapeId . " - moving to source\n";
		saveApi($conn, $migratedTapeId,
			'/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $api[$env]["sources"][$dbRow["source"]] .
				'/accept_children?position=0&children[]=/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/'.$migratedTapeId,
			null, null, null, null, TRUE);
	}
	// TODO make conditional
		$trackPosition = 0;
		$query = "SELECT tM.". $api[$env]["trackColumn"] ." as remote_id, ct.*
FROM catalogue_track ct
JOIN trackMigration tM ON tM.track_id = ct.id
WHERE ct.tape_id = " . $dbRow['id'] . "
ORDER BY ct.start_time;
";
		// echo $query;
		foreach ($conn->query($query) as $row) {
			// print_r($row);
			echo "Moving Track " . $row['remote_id'] . " to parent Tape position " . $trackPosition ." " . $row['start_time'] . "\n";
			saveApi($conn, $row['remote_id'],
				'/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $migratedTapeId .
					'/accept_children?position=' . $trackPosition . '&children[]=/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/'.$row['remote_id'],
				null, null, null, null, TRUE);
			$trackPosition++;
		}
	// }
}

function processTrack($conn, $dbRow) {
	global $api;
	global $env;
	global $flag;
	global $lookUps;
	global $subjectGenres;
	global $verbose;
	global $stage5;
	global $tags;
	global $tacl;
	global $qualifyIA;
	global $qualifyRA;
	
	$title = (empty($dbRow["title"]) ?
		(empty($dbRow['status']) ? '[Untitled]' : $lookUps["track-status"][$dbRow['status']]) :
		$dbRow["title"]
	);
	$position = "";
	if (!empty($dbRow['remote_id'])) {
		//echo "Processing Track ". $dbRow["id"] . "\n";
		$apiObject = getApi($conn, '/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $dbRow['remote_id']);
		$position = $apiObject->position;
		unset($apiObject->position);
		//echo print_r(json_encode($apiObject), true) . "\n";
	} else {
		// Using series for tape.
		$apiObject = (object)[
			"jsonmodel_type" => "archival_object",
			"level" => "item",
			"notes" => [],
			"lang_materials" => [],
			"resource" => (object)[
				"ref" => "/repositories/" . $api[$env]["repositoryId"] . '/resources/' . $api[$env]["resourceId"]
			]
		];
	}
	
	unsetNote($apiObject->notes, "First Line");
	unsetNote($apiObject->notes, "First Line Of Song");

	$apiObject->title = $title;
	echo "\n". $dbRow["tape_id"] . ' ' . $dbRow["id"] . '/' . $dbRow["remote_id"] . ' ' . $apiObject->title . ' ' . $dbRow["start_time"] . "\n";
	// print_r($dbRow);
	$apiObject->external_ids = [(object)["jsonmodel_type" => "external_id", "external_id" => strval($dbRow['id']), "source" => "Rescue site track id"]];

    $apiObject->component_id = strval($dbRow['id']);
    $apiObject->publish = $dbRow['audio_public'];
	
	if (empty($apiObject->extents)) {
		$apiObject->extents = [(object)[
            "jsonmodel_type" => "extent",
            "portion" => "whole",
            "number" => "1",
            "extent_type" => "digital file",
            "physical_details" => ""
		]];
	}

	$dates = [];
	$parts = [];
	// Recording date
	if (!empty($dbRow['rdate'])) {
		$date = date_create();
		$parts = explode('-', $dbRow['rdate']); // Check for YYYY-YY
		if (count($parts) > 1) {
			$parts2 = explode('.', $parts[0]);
			switch (count($parts2)) {
				case 1: // year only
					$expression = "c. " . floor(((int)$parts[0] + (int)(substr($parts[0], 0, 2) . $parts[1]))/2);
					date_date_set($date, $parts[0], 1, 1);
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "creation",
						"expression" => $expression,
						"begin" => $parts[0],
						"date_type" => "inclusive",
						"certainty" => "approximate"
					];
					break;
				case 2: // year and month only
					date_date_set($date, $parts2[0], floor(((int)$parts2[1] + (int)$parts[1])/2), 1);
					$expression = "c. " . date_format($date, 'F Y');
					date_date_set($date, $parts2[0], $parts2[1], 1);
					// echo date_format($date, 'Y-m-d') . "\n";
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "creation",
						"expression" => $expression,
						"begin" => $parts2[0].'-'.$parts2[1],
						"date_type" => "inclusive",
						"certainty" => "approximate"
					];
					break;
				default:
					echo "DATE ISSUE 01\n";
					exit(0);
			}
		} else {
			$parts = explode('.', $dbRow['rdate']);
			switch (count($parts)) {
				case 1: // year only
					// discard any season
					$parts[0] = trim(str_replace(['Spring', 'spring', 'Summer', 'summer', 'Autumn', 'autumn', 'Winter', 'winter'],
						['', '', '', '', '', '', '', ''], $parts[0]));
					date_date_set($date, $parts[0], 1, 1);
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "creation",
						"expression" => $parts[0],
						"begin" => $parts[0],
						"date_type" => "inclusive",
						"certainty" => "approximate"
					];
					break;
				case 2: // year and month only
					date_date_set($date, $parts[0], $parts[1], 1);
					// echo date_format($date, 'Y-m-d') . "\n";
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "creation",
						"expression" => date_format($date, 'F Y'),
						"begin" => $parts[0].'-'.$parts[1],
						"date_type" => "inclusive",
						"certainty" => "approximate"
					];
					break;
				case 3:
					date_date_set($date, $parts[0], $parts[1], $parts[2]);
					// echo date_format($date, 'Y-m-d') . "\n";
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "creation",
						"expression" => date_format($date, 'd F Y'),
						"begin" => $parts[0].'-'.$parts[1].'-'.$parts[2],
						"date_type" => "single",
						// "certainty" => ($env !== 'dev' ? 'certain' : "inferred")
					];
					break;
			}
		}
	}
	// Transmission date
	if (!empty($dbRow['tdate'])) {
		$date = date_create();
		$parts = explode('-', $dbRow['tdate']); // Check for YYYY-YY
		if (count($parts) > 1) {
			$parts2 = explode('.', $parts[0]);
			switch (count($parts2)) {
				case 1: // year only
					$expression = "c. " . floor(((int)$parts[0] + (int)(substr($parts[0], 0, 2) . $parts[1]))/2);
					date_date_set($date, $parts[0], 1, 1);
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "broadcast",
						"expression" => $expression,
						"begin" => $parts[0],
						"date_type" => "inclusive",
						"certainty" => "approximate"
					];
					break;
				case 2: // year and month only
					date_date_set($date, $parts2[0], floor(((int)$parts2[1] + (int)$parts[1])/2), 1);
					$expression = "c. " . date_format($date, 'F Y');
					date_date_set($date, $parts2[0], $parts2[1], 1);
					// echo date_format($date, 'Y-m-d') . "\n";
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "broadcast",
						"expression" => $expression,
						"begin" => $parts2[0].'-'.$parts2[1],
						"date_type" => "inclusive",
						"certainty" => "approximate"
					];
					break;
				default:
					echo "DATE ISSUE 02\n";
					exit(0);
			}
		} else {
			$parts = explode('.', $dbRow['tdate']);
			switch (count($parts)) {
				case 1: // year only
					// discard any season
					$parts[0] = trim(str_replace(['Spring', 'spring', 'Summer', 'summer', 'Autumn', 'autumn', 'Winter', 'winter'],
						['', '', '', '', '', '', '', ''], $parts[0]));
					date_date_set($date, $parts[0], 1, 1);
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "broadcast",
						"expression" => $parts[0],
						"begin" => $parts[0],
						"date_type" => "inclusive",
						"certainty" => "approximate"
					];
					break;
				case 2: // year and month only
					date_date_set($date, $parts[0], $parts[1], 1);
					// echo date_format($date, 'Y-m-d') . "\n";
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "broadcast",
						"expression" => date_format($date, 'F Y'),
						"begin" => $parts[0].'-'.$parts[1],
						"date_type" => "inclusive",
						"certainty" => "approximate"
					];
					break;
				case 3:
					date_date_set($date, $parts[0], $parts[1], $parts[2]);
					// echo date_format($date, 'Y-m-d') . "\n";
					$dates[] = (object)[
						"jsonmodel_type" => "date",
						"label" => "broadcast",
						"expression" => date_format($date, 'd F Y'),
						"begin" => $parts[0].'-'.$parts[1].'-'.$parts[2],
						"date_type" => "single",
						// "certainty" => ($env !== 'dev' ? 'certain' : "inferred")
					];
					break;
			}
		}
	}
	if (count($dates) > 0) {
		$apiObject->dates = $dates;
	}

	setSinglePartNoteCheckNull($apiObject->notes, 'Short Title', 'abstract', $dbRow['loc_title']);
	setSinglePartNoteCheckNull($apiObject->notes, 'Alternative Title', 'abstract', $dbRow['alt_title']);
	setSinglePartNoteCheckNull($apiObject->notes, 'First Line', 'abstract', $dbRow['first_line']);
	setMultiPartNoteCheckNull($apiObject->notes, 'Track Status', 'odd', empty($dbRow["status"]) ? null : $lookUps["track-status"][$dbRow['status']]);
	setMultiPartNoteCheckNull($apiObject->notes, 'Publication', 'accessrestrict', 
		array_values(array_filter([
			$dbRow["pub_restrict"] === null || $dbRow["pub_restrict"] === "" ? null : "Restriction : " . $lookUps["publication-restrictions"][strval($dbRow['pub_restrict'])],
			empty($dbRow["special_attn"]) ? null : "Special attention"
		])));
	$apiObject->restrictions_apply = !($dbRow["pub_restrict"] === null || $dbRow["pub_restrict"] === "");
	setMultiPartNoteCheckNull($apiObject->notes, 'Audio Quality', 'phystech', empty($dbRow["audio_q"]) ? null : $lookUps["audio-quality"][$dbRow['audio_q']]);
	setMultiPartNoteCheckNull($apiObject->notes, 'Original Track ID', 'custodhist', $dbRow["orig_id"]);
	setSinglePartNoteCheckNull($apiObject->notes, 'Start Time', 'materialspec', $dbRow["start_time"]);
	setSinglePartNoteCheckNull($apiObject->notes, 'End Time', 'materialspec', $dbRow["end_time"]);
	
	setMultiPartNoteCheckNull($apiObject->notes, 'Summary - English', 'scopecontent', (empty($dbRow["summary_en"]) ? null : $dbRow["summary_en"]));
	setMultiPartNoteCheckNull($apiObject->notes, 'Summary - Gaelic', 'scopecontent', (empty($dbRow["summary_gd"]) ? null : $dbRow["summary_gd"]));
	setMultiPartNoteCheckNull($apiObject->notes, 'Summary - Scots', 'scopecontent', (empty($dbRow["summary_sco"]) ? null : $dbRow["summary_sco"]));
	setMultiPartNoteCheckNull($apiObject->notes, 'Subject/Person', 'odd', $dbRow["person"]);
	setMultiPartNoteCheckNull($apiObject->notes, 'Note', 'odd', $dbRow["note"]);
	setMultiPartNoteCheckNull($apiObject->notes, 'Unusable Note', 'odd', $dbRow["un_note"]);
	setMultiPartNoteCheckNull($apiObject->notes, 'Item Time Period', 'odd', 
		array_values(array_filter([
			$dbRow["itime"],
			empty($dbRow["datestart"]) ? null : "Start : " . $dbRow['datestart'],
			empty($dbRow["dateend"]) ? null : "Start : " . $dbRow['dateend']
		])));
	setMultiPartNoteCheckNull($apiObject->notes, 'Language Level', 'odd', empty($dbRow["lang_level"]) ? null : $lookUps["language-level"][$dbRow['lang_level']]);
	setMultiPartNoteCheckNull($apiObject->notes, 'Item Note', 'odd', $dbRow["item_note"]);
	setMultiPartNoteCheckNull($apiObject->notes, 'Publication Note', 'odd', $dbRow["item_pub_note"]);
 	setMultiPartNoteCheckNull($apiObject->notes, 'Classification', 'relatedmaterial', $dbRow["classification"]);
	if($verbose && !empty($dbRow["classification"])) {
		echo "Classification set\n";
	}
	setMultiPartNoteCheckNull($apiObject->notes, 'Metadata', 'processinfo', array_values(array_filter([
			// "Track ID : " . $dbRow['id'], held in the component_id
			empty($dbRow['cat_id']) ? null : "Catalogue ID : " . $dbRow['cat_id'],
//			empty($dbRow['mp3']) ? null : "Original Media file : " . $dbRow['mp3'],
	])));


	unsetNote($apiObject->notes, "Computed Copyright");
	$rights = [];
	if ($dbRow["statement"] !== null && $dbRow["statement"] !== "") {
		$rights[] = (object)[
            "jsonmodel_type" => "rights_statement",
            "start_date" => (empty($parts) ? '1900-01-01' : date_format($date, 'Y-m-d')),
            "rights_type" =>"copyright",
            "status" => "copyrighted",
            "jurisdiction" => "GB",
			"notes" => [(object)[
                "jsonmodel_type" => "note_rights_statement",
                "label" => "Computed Copyright",
                "type" => "additional_information",
                "content" => [$lookUps["computed-copyright-statement"][strval($dbRow['statement'])]]
			]]
		];
	}
	$apiObject->linked_agents = [];

	$query = "SELECT ctpl.person_id, aM.". $api[$env]["agentColumn"] ." as remote_id, ctpl.role, ctpl.statement
FROM catalogue_trackpersonlink ctpl
JOIN agentMigration aM ON aM.person_id = ctpl.person_id
WHERE ctpl.track_id = " . $dbRow["id"] . " 
AND aM.". $api[$env]["agentColumn"] ." IS NOT NULL
ORDER BY remote_id;
";
	foreach ($conn->query($query) as $row) {
		// echo "Adding Agent ". $row["person_id"] . " Remote ". $row["remote_id"] . " " . $row["role"] . "\n";
		// print_r($row);
		// $dbRow["source"] sources
		$apiObject->linked_agents[] = (object)[
			"role" => "creator",
			"relator" => ($row["role"] === "c" ? "ctb" : (in_array($dbRow["source"], array("c", "s")) ? "Fieldworker" : "ivr")),
			"terms" => [],
			"ref" => "/agents/people/".$row["remote_id"]
		];
		/*
		if($tacl && $env != 'dev' && $row["statement"] !== null && $row["statement"] !== "") {
//			echo '[' . strval($row['statement']) . '] [' . $lookUps["copyright-statement"][strval($row['statement'])] . "]" . PHP_EOL;
			$rights[] = (object)[
				"jsonmodel_type" => "rights_statement",
				"start_date" => (empty($parts) ? '1900-01-01' : date_format($date, 'Y-m-d')),
				"rights_type" =>"copyright",
				"status" => "copyrighted",
				"jurisdiction" => "GB",
                "linked_agents" => [(object)[
					// "role" => ($row["role"] === "c" ? "source" : "creator"),
					"ref" => "/agents/people/".$row["remote_id"]
				]],
				"notes" => [(object)[
					"jsonmodel_type" => "note_rights_statement",
					"type" => "additional_information",
					"label" => "Agent track copyright status",
					"content" => [$lookUps["copyright-statement"][strval($row['statement'])]]
				]]
			];
		};
*/
	}

	$apiObject->rights_statements = $rights;

	$apiObject->subjects = array_values(array_map(function($ref) { return (object)["ref" => $ref]; },
		array_filter([
			(!empty($dbRow["genre"]) && !empty($subjectGenres[$dbRow["genre"]]) ? $subjectGenres[$dbRow["genre"]] : null),
			handleLocationSubject($conn, $dbRow, 'rec', 'en', $env, $qualifyRA),
			handleLocationSubject($conn, $dbRow, 'rec', 'gd', $env, $qualifyRA),
			handleLocationSubject($conn, $dbRow, 'rec', 'nonuk', $env, $qualifyRA),
			handleLocationSubject($conn, $dbRow, 'item', 'en', $env, $qualifyIA),
			handleLocationSubject($conn, $dbRow, 'item', 'gd', $env, $qualifyIA),
			handleLocationSubject($conn, $dbRow, 'item', 'nonuk', $env, $qualifyIA)
		])));
	if ($api[$env]["languageMode"] == 'object') {
		$apiObject->lang_materials=[];
	}
	$languageNote = [];
	$languageCodes = [];
	$languages = 0;
	if (!empty($dbRow['lang_en'])) {
		$languages++;
		if ($api[$env]["languageMode"] == 'object') {
			$apiObject->lang_materials[] = (object)[
				"jsonmodel_type" => "lang_material",
				"language_and_script" => (object)[
					"jsonmodel_type" => "language_and_script",
					"language" => "eng"
				]];
		} else {
			$languageCodes[] = "eng";
			$languageNote[] = "English";
		}
 	}
	if (!empty($dbRow['lang_gd'])) {
		$languages++;
		if ($api[$env]["languageMode"] == 'object') {
			$apiObject->lang_materials[] = (object)[
				"jsonmodel_type" => "lang_material",
				"language_and_script" => (object)[
					"jsonmodel_type" => "language_and_script",
					"language" => "gla"
				]];
		} else {
			$languageCodes[] = "gla";
			$languageNote[] = "Gaelic";
		}
	}
	if (!empty($dbRow['lang_sco'])) {
		$languages++;
		if ($api[$env]["languageMode"] == 'object') {
			$apiObject->lang_materials[] = (object)[
				"jsonmodel_type" => "lang_material",
				"language_and_script" => (object)[
					"jsonmodel_type" => "language_and_script",
					"language" => "sco"
				]];
		} else {
			$languageCodes[] = "sco";
			$languageNote[] = "Scots";
		}
	}
	if (!empty($dbRow['lang_oth'])) {
		$languages++;
		if ($api[$env]["languageMode"] == 'object') {
		/*
		$apiObject->lang_materials[] = (object)[
					"jsonmodel_type" => "lang_material",
					"lang" => 'Other'];
					*/
		} else {
			// $languageCodes[] = "oth";
			$languageNote[] = "Other";
		}
	}
	if ($api[$env]["languageMode"] == 'note') {
		if ($languages>1) {
			$apiObject->language="mul";
		} else if ($languages === 1 && count($languageCodes)>0) {
			$apiObject->language = $languageCodes[0];
		} else {
			unset($apiObject->language);
		}
		setSinglePartNoteCheckNull($apiObject->notes, 'Languages', 'langmaterial', empty($languageNote) ? null : implode(', ', $languageNote));
	}

	// print_r($apiObject);
	$migratedTrackId = saveApi($conn, $apiObject,
		'/repositories/' . $api[$env]["repositoryId"] . '/archival_objects' . (empty($dbRow['remote_id']) ? "" : "/".$dbRow['remote_id']),
		'trackMigration',
		'track_id',
		$api[$env]["trackColumn"],
		$dbRow['id'],
		!empty($dbRow['remote_id']));
		
}

function processTrackLinks($conn, $dbRow) {
	global $api;
	global $env;
	
	if (!empty($dbRow['remote_id'])) {
		$apiObject = getApi($conn, '/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $dbRow['remote_id']);
		$position = $apiObject->position;
		unset($apiObject->position);
	} else {
		// for stage 5 we must have an existing track.
		return;
	}
	if (empty($dbRow["parent_id"]) && empty($dbRow["next_id"])) {
		echo 'Stage 5 : Ignoring ' . $dbRow["id"] . '/' . $dbRow["remote_id"] . ' ' . $apiObject->title . ' ' . $dbRow["start_time"] . "\n";
		return;
	}
	// Only data we change is the links between the tracks.
	echo $dbRow["tape_id"] . '/' . $dbRow["id"] . '/' . $dbRow["remote_id"] . ' ' . $apiObject->title . ' ' . $dbRow["start_time"] . "\n";
	
 	setMultiPartNoteCheckNull($apiObject->notes, 'Previous track in chain', 'relatedmaterial', empty($dbRow["previous_remote_id"]) ?
			(empty($dbRow["parent_id"]) ? null : strval($dbRow["parent_id"]))  :
			'<ref href="/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $dbRow['previous_remote_id'] . '">Track ID '.$dbRow["parent_id"].'</ref>');
 	setMultiPartNoteCheckNull($apiObject->notes, 'Next track in chain', 'relatedmaterial', empty($dbRow["next_remote_id"]) ?
			(empty($dbRow["next_id"]) ? null : strval($dbRow["next_id"]))  :
			'<ref href="/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $dbRow['next_remote_id'] . '">Track ID '.$dbRow['next_id'] . '</ref>');
	if(!empty($dbRow["parent_id"])) {
		echo "Parent_id set " . $dbRow["parent_id"]."/" . $dbRow["previous_remote_id"]."\n";
	}
	if(!empty($dbRow["next_id"])) {
		echo "Next_id set " . $dbRow["next_id"]."/" . $dbRow["next_remote_id"]."\n";
	}

	// print_r($apiObject);
	$migratedTrackId = saveApi($conn, $apiObject,
		'/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $dbRow['remote_id'],
		'trackMigration',
		'track_id',
		$api[$env]["trackColumn"],
		$dbRow['id'],
		TRUE);
}

//*************************************************************************************************
// 
//
function setBiogNote(&$notes, $label, $type, $content, $publish) {
	$found = FALSE;
	foreach($notes as $idx=>$note) {
		if ($note->label === $label) {
			// move to end
			unset($notes[$idx]);
			$notes = array_values($notes);
			$found = count($notes);
			$notes[] = $note;
			break;
		}
	}
	if ($found === FALSE) {
		$found = count($notes);
		$notes[] = (object)[
			"jsonmodel_type" => "note_bioghist",
			"label" => $label
		];
	}
	$notes[$found]->type = $type;
	if (is_array($content)) {
		$notes[$found]->subnotes = [];
		foreach($content as $entry) {
			$notes[$found]->subnotes[] = (object)["jsonmodel_type" => "note_text", "content" => $entry, "publish"=>$publish];
		}
	} else {
		$notes[$found]->subnotes = [(object)["jsonmodel_type" => "note_text", "content" => $content, "publish"=>$publish]];
	}
	foreach ($notes[$found]->subnotes as $index => $subnote) {
		$notes[$found]->subnotes[$index]->content = str_replace('%', "&percnt;", $subnote->content);
	}
}

function setBiogNoteCheckNull(&$notes, $label, $type, $content, $publish) {
	if (empty($content)) {
		unsetNote($notes, $label);
	} else {
		setBiogNote($notes, $label, $type, $content, $publish);
	}
}

function generateName(&$names, $dbRow, $title, $firstname, $surname, $source) {

	// surname is mandatory: TODO default to english if not provided in Gaelic
	if (trim($dbRow[$surname]) == '') {
		return;
	}
	$name = (object)[
		"jsonmodel_type" => "name_person",
		"primary_type" => "agent_person",
		"agent_type" => "agent_person",
		"authorized" => FALSE,
		"is_display_name" => FALSE,
		"primary_name" => trim($dbRow[$surname]),
		//"fuller_form" => "",
		//"title" => "",
		//"name_prefix" => "",
		"rest_of_name" => trim($dbRow[$title] . ' ' . $dbRow[$firstname]),
		"sort_name_auto_generate" => true,
		"name_order" => "inverted",
		"source" => $source,
		"rules" => "local",
		"qualifier" => strval($dbRow['id'])
	];
	// $name->use_dates":[],
	echo $dbRow['id'] . ' [' . $dbRow[$title].'] ['.$dbRow[$firstname].'] ['.$dbRow[$surname]."]\n";
	$names[] = $name;
}

function processAgent($conn, $dbRow) {
	global $api;
	global $env;
	global $flag;
	global $lookUps;
	global $tags;
	
	if (!empty($dbRow['remote_id'])) {
		$apiObject = getApi($conn, '/agents/people/'.$dbRow['remote_id']);
	} else {
		$apiObject = (object)[
			"jsonmodel_type" => "agent_person",
			"notes" => []
		];
	}
	echo "Processing Agent ". $dbRow["id"] . '/' . $dbRow["remote_id"] . "\n";

	$apiObject->external_ids = [(object)["jsonmodel_type" => "external_id", "external_id" => strval($dbRow['id']), "source" => "Rescue site person id"]];

	unsetNote($apiObject->notes, "Copyright note");

	$names = [];
	if (!empty($dbRow['firstname_gd']) && empty($dbRow['surname_gd'])) {
		$dbRow['surname_gd'] = $dbRow['surname_en'];
	}
	generateName($names, $dbRow, 'title_en', 'firstname_en', 'surname_en', ($env === 'dev' ? 'local' : 'TaD English'));
	generateName($names, $dbRow, 'title_gd', 'firstname_gd', 'surname_gd', ($env === 'dev' ? 'local' : 'TaD Gaelic'));
	// generateName($names, $dbRow, 'title_alt', 'firstname_alt', 'surname_alt', 'local');
	if(count($names) == 0) {
		echo "Names Error\n";
		exit(0);
	}
	$names[0]->primary_name .= ($flag ? " [Migration]" : "");
	$names[0]->is_display_name=true;
	$names[0]->authorized=true;
	$apiObject->names = $names;

	// Patronymic name is special case.
	// Previously set up a jsonmodel_type="name_person", with primary name = $dbRow['pidentifier'], and suitable Qualifier
	setBiogNoteCheckNull($apiObject->notes, "Alternative name", "note", trim(implode(' ', array_filter([$dbRow['title_alt'], $dbRow['firstname_alt'], $dbRow['surname_alt']]))), FALSE);
	setBiogNoteCheckNull($apiObject->notes, "Patronymic/Sloinneadh", "note", trim($dbRow['pidentifier']), FALSE);
	setBiogNoteCheckNull($apiObject->notes, "Nicknames", "note", array_values(array_filter([$dbRow['nickname_en'], $dbRow['nickname_gd'], $dbRow['nickname_alt']])), false);

	$dates = [];
	if (!empty($dbRow['birth_date_text']) || !empty($dbRow['death_date_text'])) {
		$range = (object)["label" => "existence", "date_type" => "range"];
		$birth = $byear = "?";
		$death = $dyear = ($dbRow['deceased'] ? '?' : '');
		if (!empty($dbRow['birth_date_text'])) {
			$date = date_create();
			$parts = explode('-', $dbRow['birth_date_text']); // Check for YYYY-YY
			if (count($parts) > 1) {
				$range->begin = $parts[0];
				$birth = $byear = "c. " . floor(((int)$parts[0] + (int)(substr($parts[0], 0, 2) . $parts[1]))/2);
			} else {
				$range->begin = str_replace('/', '-', $dbRow['birth_date_text']);
				$parts = explode('/', $dbRow['birth_date_text']); // YYYY[/MM[/DD]]
				$byear = $parts[0];
				switch (count($parts)) {
					case 1: // year only
						$birth = $parts[0];
						break;
					case 2: // year and month only
						date_date_set($date, $parts[0], $parts[1], 1);
						$birth = date_format($date, 'F Y');
						break;
					case 3:
						date_date_set($date, $parts[0], $parts[1], $parts[2]);
						$birth = date_format($date, 'd F Y');
						break;
				}
			}
		}
		if (!empty($dbRow['death_date_text'])) {
			$date = date_create();
			$parts = explode('-', $dbRow['death_date_text']); // Check for YYYY-YY
			if (count($parts) > 1) {
				$range->end = substr($parts[0], 0, 2) . $parts[1];
				$death = $dyear = "c. " . floor(((int)$parts[0] + (int)(substr($parts[0], 0, 2) . $parts[1]))/2);
			} else {
				$range->end = str_replace('/', '-', $dbRow['death_date_text']);
				$parts = explode('/', $dbRow['death_date_text']); // YYYY[/MM[/DD]]
				$dyear = $parts[0];
				switch (count($parts)) {
					case 1: // year only
						$death = $parts[0];
						break;
					case 2: // year and month only
						date_date_set($date, $parts[0], $parts[1], 1);
						$death = date_format($date, 'F Y');
						break;
					case 3:
						date_date_set($date, $parts[0], $parts[1], $parts[2]);
						$death = date_format($date, 'd F Y');
						break;
				}
			}
		}
		$range->expression = trim(implode('-', [$birth, $death]));
		foreach($names as $index=>$name) {
			$apiObject->names[$index]->dates = trim(implode('-', [$byear, $dyear]));
		}
		$dates[] = $range;
		echo $range->expression . "\n";
	}
	$apiObject->dates_of_existence = $dates;
	
	$links = [];
	$matches = [];
	if (!empty($dbRow['text_en'])) {
		$text_en = $dbRow['text_en'];
		preg_match_all("/\[\[([^\]]+)\]\]/", $text_en, $matches);
		foreach ($matches[0] as $idx => $full) {
			$text_en = str_replace($full , '<extref href="' . $matches[1][$idx] . '">' . $matches[1][$idx] . '</extref>', $text_en);
			$links[] = $matches[1][$idx];
		}
		/* Status code:
			0 = None
			1 = "WIP"
			2 = "Publish"
		*/
		setBiogNoteCheckNull($apiObject->notes, "Biography - English", "note", $text_en, ($dbRow['status_en'] == 2));
	}
	if (!empty($dbRow['text_gd'])) {
		$text_gd = $dbRow['text_gd'];
		preg_match_all("/\[\[([^\]]+)\]\]/", $text_gd, $matches);
		foreach ($matches[0] as $idx => $full) {
			$text_gd = str_replace($full , '<extref href="' . $matches[1][$idx] . '">' . $matches[1][$idx] . '</extref>', $text_gd);
			$links[] = $matches[1][$idx];
		}
		setBiogNoteCheckNull($apiObject->notes, "Biography - Gaelic", "note", $text_gd, ($dbRow['status_gd'] == 2));
	}
	setBiogNoteCheckNull($apiObject->notes, "Note", "note", $dbRow['note'], false);
	
	$apiObject->external_documents = [];
	foreach (array_unique($links) as $link) {
		$apiObject->external_documents[] = (object)[
            "jsonmodel_type" => "external_document",
            "title" => "Link within Biographic notes to '" . $link . "'",
            "location" => $link
		];
	}

	$subnotes = [];
	if (!empty($dbRow['cnote'])) {
		$subnotes[] = $dbRow['cnote'];
	}
	$query = "SELECT * FROM catalogue_copyright WHERE person_id = " . $dbRow['id'] . " ORDER BY id;";
	foreach ($conn->query($query) as $copyrightRow) {
		$subnotes[] = $lookUps["copyright-source"][$copyrightRow['source']] . ' : ' . $lookUps["copyright-statement"][strval($copyrightRow['statement'])];
	}
	setBiogNoteCheckNull($apiObject->notes, "Copyright note", "note", $subnotes, false);
	
	$location = implode("\n", array_filter(array_map(function ($title, $column) use ($dbRow, $tags) {
		if (empty($dbRow[$column])) return null;
		return (empty($tags) ? ($title . ' : ' . trim($dbRow[$column])) : ('<emph>' . $title . '</emph> : <geogname>' . trim($dbRow[$column]) . '</geogname>'));
	}, ["County", 'Parish', 'Island', 'Village'], ['county_en', 'parish_en', 'island_en', 'village_en'])));
	setBiogNoteCheckNull($apiObject->notes, "Native Area - English", "note", $location, false);
	$location = implode("\n", array_filter(array_map(function ($title, $column) use ($dbRow, $tags) {
		if (empty($dbRow[$column])) return null;
		return (empty($tags) ? ($title . ' : ' . trim($dbRow[$column])) : ('<emph>' . $title . '</emph> : <geogname>' . trim($dbRow[$column]) . '</geogname>'));
	}, ["Siorrachd", 'Paraiste', 'Eilean', 'Baile/Àite'], ['county_gd', 'parish_gd', 'island_gd', 'village_gd'])));
	setBiogNoteCheckNull($apiObject->notes, "Native Area - Gaelic", "note", $location, false);
	setBiogNoteCheckNull($apiObject->notes, "Native Area", "note", (empty($tags) || empty(trim($dbRow['nonuk'])) ? trim($dbRow['nonuk']) : '<geogname>' . trim($dbRow['nonuk']) . '</geogname>'), false);
	setBiogNoteCheckNull($apiObject->notes, "Additional Notes", "note", array_values(array_filter([
			"Person ID : ".strval($dbRow['id']),
			(empty($dbRow['deceased']) ? null : "Deceased"),
			(empty($dbRow['gender']) ? null : "Gender : " . $lookUps["gender"][strtoupper($dbRow['gender'])]),
			($dbRow['trace_status'] === null || $dbRow['trace_status'] === "" ? null : "Trace status : " . $lookUps["trace_status"][$dbRow['trace_status']])
		])), false);

	$migratedPersonId = saveApi($conn, $apiObject,
		'/agents/people' . (empty($dbRow['remote_id']) ? "" : "/".$dbRow['remote_id']),
		'agentMigration',
		'person_id',
		$api[$env]["agentColumn"],
		$dbRow['id'],
		!empty($dbRow['remote_id'])
		);
	if (empty($dbRow['remote_id'])) {
		echo "New Person created : AS ID " . $migratedPersonId . "\n";
	}
}

//*************************************************************************************************
// Genre Subjects
//
$genres = [
	"7" => ["caption" => "Song"],
	"8" => ["caption" => "Story"],
	"9" => ["caption" => "Information"],
	"10" => ["caption" => "Verse"],
	"11" => ["caption" => "Music"],
	"12" => ["caption" => "Radio programme"],
	"13" => ["caption" => "Other"]
];

function readGenreTerms($conn) {
	global $api;
	global $env;
	global $genres;
	global $subjectGenres;
	
	echo "Reading genres\n";
	// Match list of terms to our genres: store URI.
	foreach ($genres as $code => $details) {
		$found = FALSE;
		$terms = getApi($conn, '/terms?q=' . urlencode($details["caption"]));
		if($terms->last_page !== 1) {
			echo "Term search returned too many results : ".$terms->total;
			exit(0);
		}
		foreach ($terms->results as $term) {
			if (!strcasecmp($term->term,$details["caption"]) &&
					$term->term_type === "genre_form" &&
					$term->vocabulary === "/vocabularies/" . $api[$env]["vocabularies"]["genre"]) {
				$found = TRUE;
				$genres[$code]['uri'] = $term->uri;
				$genres[$code]['vocabulary'] = $term->vocabulary;
				// echo "Found genre ".$details["caption"]. ' '.$term->uri."\n";
				break;
			}
		}
		// For any missing terms, create a new subject/term combination
		if (!$found) {
			echo "Creating new genre ".$details["caption"]."\n";
			// term not found so subject won't exist either.
			$apiObject = (object)[
				"jsonmodel_type" => "subject",
				"title" => $details["caption"],
				"scope_note" => "Genre",
				"source" => "local",
				"publish" => 1,
				"terms" => [(object)[
                    "jsonmodel_type" => "term",
                    "term" => $details["caption"],
                    "term_type" => "genre_form",
                    "vocabulary" => "/vocabularies/" . $api[$env]["vocabularies"]["genre"]
				]],
                "vocabulary" => "/vocabularies/" . $api[$env]["vocabularies"]["genre"]
			];
			$subjectId = saveApi($conn, $apiObject, '/subjects', null, null, null, null, TRUE);
			// Read back the new subject: store the term URI.
			$subject = getApi($conn, '/subjects/'.$subjectId);
			$genres[$code]['uri'] = $subject->terms[0]->uri;
			$genres[$code]['vocabulary'] = $subject->terms[0]->vocabulary; 
		}
	}
	echo "\nReading subjects\n";
	$query = "SELECT genre, count(*)
FROM catalogue_track
WHERE genre is not null AND genre != '{}' AND genre != '{NULL}'
GROUP BY genre
ORDER by genre;";
	$lastSearch = "";
	foreach ($conn->query($query) as $row) {
		$trackGenres = explode(',', trim($row["genre"], " {}"));
		// Search the subjects API based on the first genre entry, then scan manually.
		if ($lastSearch !== $trackGenres[0]) {
			$apiSubjects = getApi($conn, '/search/subjects?page=1&page_size=50&q=' . urlencode('title:"'.$genres[$trackGenres[0]]["caption"].'"'));
			$lastSearch = $trackGenres[0];
			if($apiSubjects->last_page > 1) {
				echo "Subjects search returned too many results : ".$apiSubjects->total_hits;
				exit(0);
			}
		}
		$trackGenreTermUris = array_values(array_filter(array_map(function($trackGenre) use ($genres) { return (isset($genres[$trackGenre]["uri"]) ? $genres[$trackGenre]["uri"] : "XXXX"); }, $trackGenres)));
		// search the results from the API to find an exact match for the trackGenres stored in the tracks, by comparing the terms.
		$found = FALSE;
		foreach ($apiSubjects->results as $apiSubject) {
			$apiSubjectStruct = json_decode($apiSubject->json);
			//echo "Term API\n";
			//print_r($apiSubjectStruct);
			//echo PHP_EOL;
			// check that (a) that all $subjectGenres are in $apiSubjectStruct, and that no extra $apiSubjectStruct over and above $subjectGenres
			$apiSubjectTermUris = array_map(function($apiSubjectTerm) { return $apiSubjectTerm->uri; }, $apiSubjectStruct->terms);
			if (empty(array_diff($apiSubjectTermUris, $trackGenreTermUris)) && empty(array_diff($trackGenreTermUris, $apiSubjectTermUris))) {
				// echo "Match subject for genre ".$row["genre"]." for ".$apiSubject->title." ".$apiSubject->uri."\n";
				$subjectGenres[$row["genre"]] = $apiSubject->uri;
				$found = TRUE;
				break;
			}
		}
		if (!$found) {
			echo "Creating new genre Subject for ".$row["genre"]."\n";
			$apiObject = (object)[
				"jsonmodel_type" => "subject",
				"scope_note" => "Genre",
				"source" => "local",
				"publish" => 1,
				"terms" => [],
                "vocabulary" => "/vocabularies/" . $api[$env]["vocabularies"]["genre"]
			];
			foreach ($trackGenres as $trackGenre) {
				$apiObject->terms[] = (object)[
                    "jsonmodel_type" => "term",
                    "term" => $genres[$trackGenre]["caption"],
                    "term_type" => "genre_form",
                    "vocabulary" => "/vocabularies/" . $api[$env]["vocabularies"]["genre"]
				];
			}
			$subjectId = saveApi($conn, $apiObject, '/subjects', null, null, null, null, TRUE);
			$subjectGenres[$row["genre"]] = '/subjects/'.$subjectId;
		}
	}
}

//*************************************************************************************************
// Location Subjects
//
$locationQualifiers = [];

// Because of possibility the we need to tag the front of the location subjects to differentiate
// The recording area points to the track: maximum of 1 RA record per track
// The item area points to the item, which points to the track: maximum of 1 IA record per track
// Dont gain anything doing in bulk

function prepLocationSubject($conn, $env) {
	// Check if the "Recording Area" term exists: if so, note its id.
	// Check if the Gaelic equivalent of "Recording Area" term exists: if so, note its id.
	// Check if the "Item Area" term exists: if so, note its id.
	// Check if the Gaelic equivalent of "Item Area" term exists: if so, note its id.
	global $locationQualifiers;
	global $api;
	global $env;
	
	$locationQualifiers = ["rec" => ["en" => ["term" => "Recording Location"], "gd" => ["term" => "Àite Clàraidh"], "nonuk" => ["term" => "Non Scottish Recording Location"]],
		"item" => ["en" => ["term" => "Item Location"], "gd" => ["term" => "Àite a' Chuspair"], "nonuk" => ["term" => "Non Scottish Item Location"]]];
	foreach($locationQualifiers as $qualifier => $qualifierSpec) {
		foreach($qualifierSpec as $variant => $defn) {
			if (empty($defn["term"])) {
				continue;
			}
			echo $qualifier." ".$variant." ".$defn["term"]."\n";
			$endpoint = '/terms?q=' . urlencode($defn["term"]);
			echo $endpoint . "\n";
			$terms = getApi($conn, $endpoint);
			// print_r($terms);

			if($terms->last_page !== 1) {
				echo "Term search returned too many results : ".$terms->total;
				exit(0);
			}
			foreach ($terms->results as $term) {
				if (!strcasecmp($term->term, $defn["term"]) &&
						$term->term_type === "function" &&
						$term->vocabulary === "/vocabularies/" . $api[$env]["vocabularies"]["location"]) {
					$locationQualifiers[$qualifier][$variant]["uri"] = $term->uri;
					echo "Found qualifier term ".$defn["term"]." ".$term->uri."\n";
					break;
				}
			}
		}
	}

}

// Function called once per person/area type
// Qualifier = "Recording Area", "Item Area": "rec", "item"
// Variant = en "English", gd "Gaelic", "nonuk"
function handleLocationSubject($conn, $dbRow, $qualifier, $variant, $env, $qualifierRequired) {
	global $api;
	global $locationQualifiers;
	// Prepare exact spec, without qualifier
	switch ($variant) {
		case "en":
		case "gd":
			$exactSpec = array_values(array_filter([
					(empty(trim($dbRow[$qualifier.'_county_'.$variant])) ? null : $dbRow[$qualifier.'_county_id']),
					(empty(trim($dbRow[$qualifier.'_parish_'.$variant])) ? null : $dbRow[$qualifier.'_parish_id']),
					(empty(trim($dbRow[$qualifier.'_island_'.$variant])) ? null : $dbRow[$qualifier.'_island_id']),
					(empty(trim($dbRow[$qualifier.'_village_'.$variant])) ? null : $dbRow[$qualifier.'_village_id'])
				]));
			sort($exactSpec);
			$exactSpec = implode(',', $exactSpec);
			$terms = array_values(array_filter([
					(empty(trim($dbRow[$qualifier.'_county_'.$variant])) ? null : ($variant == 'en' ? "County - " : "Siorrachd - ").trim($dbRow[$qualifier.'_county_'.$variant])),
					(empty(trim($dbRow[$qualifier.'_parish_'.$variant])) ? null : ($variant == 'en' ? "Parish - " : "Paraiste - ").trim($dbRow[$qualifier.'_parish_'.$variant])),
					(empty(trim($dbRow[$qualifier.'_island_'.$variant])) ? null : ($variant == 'en' ? "Island - " : "Eilean - ").trim($dbRow[$qualifier.'_island_'.$variant])),
					(empty(trim($dbRow[$qualifier.'_village_'.$variant])) ? null : ($variant == 'en' ? "Village - " : "Baile/Àite - ").trim($dbRow[$qualifier.'_village_'.$variant]))
				]));
			if (empty($terms)) {
				return null;
			}
			break;
		case "nonuk":
			if (empty(trim($dbRow[$qualifier.'_nonuk']))) {
				return null;
			}
			$exactSpec = trim($dbRow[$qualifier.'_nonuk']);
			$terms = [trim($dbRow[$qualifier.'_nonuk'])];
			break;
	}
	// Prepare qualified spec, (RA vs IA) if required.
	if ($qualifierRequired) {
		$qualifiedTerms = array_merge([$locationQualifiers[$qualifier][$variant]["term"]], $terms);
	}
	//echo "\n";
	//	print_r($exactSpec);
	//	echo "\n";
	//  print_r($terms);
	$query = "SELECT key, ".$env."_exact_id as exact_id,
	".$env."_existing as existing,
	".$env."_rec_id as rec_id,
	".$env."_item_id as item_id
FROM locationMigration
WHERE key = '".$variant.":".urlencode($exactSpec)."';";
	// echo $query."\n";
	$found = FALSE;
	foreach ($conn->query($query) as $row) {
		$found = $row;
		// print_r($row);
		// if relevant field (depending on qualifier and if required) filled in, return that subject uri.
		$field = (!$qualifierRequired ? "exact_id" : $qualifier."_id");
		if (!empty($row[$field])) {
			return '/subjects/'.$row[$field];
		}
	}
	if (!$found) {
		echo "Create a locationMigration record for " . $variant.":".urlencode($exactSpec) . PHP_EOL;
		// else database record does not exist
		//   Create a database record for this location combination, key = string version of exact spec e.g. "{id1,id2,id3,id4}":
		$query = "INSERT INTO locationMigration (key) VALUES ('" . $variant.":".urlencode($exactSpec)."');";
		$conn->exec($query);
	}
	if ($variant === "nonuk") {
		$search = trim($dbRow[$qualifier.'_nonuk']);
	} else {
		// Identify highest granularity field that is filled in (county, parish, village, island)
		$search = (!empty($dbRow[$qualifier.'_village_'.$variant]) ? trim($dbRow[$qualifier.'_village_'.$variant]) : 
					(!empty($dbRow[$qualifier.'_island_'.$variant]) ? trim($dbRow[$qualifier.'_island_'.$variant]) : 
						(!empty($dbRow[$qualifier.'_parish_'.$variant]) ? trim($dbRow[$qualifier.'_parish_'.$variant]) : trim($dbRow[$qualifier.'_county_'.$variant]))));
	}
	$search = $terms[count($terms)-1];
	$lim = 1000;
	$apiSubjects = getApi($conn, '/search/subjects?page=1&page_size=' . $lim . '&q=' . urlencode('title:"'.$search.'"'));
	if (count($apiSubjects->results) >= $lim) {
		echo "Search subjects limit too small\n";
		exit(0);
	}
	//echo "\nAPI SUBJECTS RESULTS\n".urlencode('title:"'.$search.'"')."\n\nCount : ";
	//echo count($apiSubjects->results) . "\n\n";
	//print_r($apiSubjects->results);
	if (!$found || empty($found['exact_id'])) {
		// If DB exact is not filled in
		//   Search through  all subjects with that term:
		$match = FALSE;
		foreach ($apiSubjects->results as $apiSubject) {
			$apiSubjectStruct = json_decode($apiSubject->json);
			$apiSubjectTermTerms = array_map(function($apiSubjectTerm) { return $apiSubjectTerm->term; }, $apiSubjectStruct->terms);
			// If there is a existing perfect match to spec without qualifier:
			// echo "Comparing\n";
			// print_r($terms);
			// print_r($apiSubjectTermTerms);
			
			if (empty(array_diff($apiSubjectTermTerms, $terms)) && empty(array_diff($terms, $apiSubjectTermTerms))) {
				echo "Match subject for location ".implode(', ', $terms)." for ".$apiSubject->title." ".$apiSubject->uri."\n";
				// Record it in database, flag as previously existing.
				$query = "UPDATE locationMigration SET ".$env."_exact_id = ".substr($apiSubject->uri, 10).", ".$env."_existing = TRUE WHERE key = '" . $variant.":".urlencode($exactSpec)."';";
				// echo $query . PHP_EOL;
				$conn->exec($query);
				// If there is no qualifier required, return that subject uri.
				if (!$qualifierRequired) {
					return $apiSubject->uri;
				}
				$match = TRUE;
				break;
			}
		}
		// If there is no match and no qualifier required, create a new subject, update the DB (not previously existing), return that subject uri.
		if (!$match && !$qualifierRequired) {
			echo "Creating new location Subject for exact ".implode(', ', $terms)."\n";
			$apiObject = (object)[
				"jsonmodel_type" => "subject",
				"scope_note" => "Location",
				"source" => "local",
				"publish" => 1,
				"terms" => [],
                "vocabulary" => "/vocabularies/" . $api[$env]["vocabularies"]["location"]
			];
			foreach ($terms as $term) {
				$apiObject->terms[] = (object)[
                    "jsonmodel_type" => "term",
                    "term" => $term,
                    "term_type" => "geographic",
                    "vocabulary" => "/vocabularies/" . $api[$env]["vocabularies"]["location"]
				];
			}
			$subjectId = saveApi($conn, $apiObject, '/subjects', null, null, null, null, TRUE);
			$query = "UPDATE locationMigration SET ".$env."_exact_id = ".$subjectId.", ".$env."_existing = FALSE WHERE key = '" . $variant.":".urlencode($exactSpec)."';";
			// echo $query . PHP_EOL;
			$conn->exec($query);
			return '/subjects/'.$subjectId;
		}
	} // Else exact is filled in, but if we would have wanted that we would have already returned.
	// At this point, we have a database record, but we want a qualified name that is not currently created.
	// If DB qualified field is not filled in
	//   Search for all subjects with that term:
	//     Confirm there is no existing perfect match to spec with qualifier
	// Create a new subject
	// update the DB
	// return that subject uri.
	
	// Check if it already exists
	foreach ($apiSubjects->results as $apiSubject) {
		$apiSubjectStruct = json_decode($apiSubject->json);
		$apiSubjectTermTerms = array_map(function($apiSubjectTerm) { return trim($apiSubjectTerm->term); }, $apiSubjectStruct->terms);
		//	echo "Comparing\n";
		//	print_r(array_map(function ($x) { return urlencode($x); }, $qualifiedTerms));
		//	print_r(array_map(function ($x) { return urlencode($x); }, $apiSubjectTermTerms));
		//	echo "\n";
		//	print_r(array_diff($apiSubjectTermTerms, $qualifiedTerms));
		//	print_r(array_diff($qualifiedTerms, $apiSubjectTermTerms));
		
		// If there is a existing perfect match to qualified spec:
		if (empty(array_diff($apiSubjectTermTerms, $qualifiedTerms)) && empty(array_diff($qualifiedTerms, $apiSubjectTermTerms))) {
			echo "Match subject for location ".implode(', ', $qualifiedTerms)." for ".$apiSubject->title." ".$apiSubject->uri."\n";
			// Record it in database
			$query = "UPDATE locationMigration SET ".$env."_".$qualifier."_id = ".substr($apiSubject->uri, 10)." WHERE key = '" . $variant.":".urlencode($exactSpec)."';";
			echo $query . PHP_EOL;
			$conn->exec($query);
			return $apiSubject->uri;
		}
	}
	// There is no match, create a new subject, update the DB, return that subject uri.
	echo "Creating new location Subject for qualified ".implode(', ', $qualifiedTerms)."\n";
	$apiObject = (object)[
		"jsonmodel_type" => "subject",
		"scope_note" => "Location",
		"source" => "local",
		"publish" => 1,
		"terms" => [],
		"vocabulary" => "/vocabularies/" . $api[$env]["vocabularies"]["location"]
	];
	foreach (array_values($qualifiedTerms) as $idx=>$term) {
		$apiObject->terms[] = (object)[
			"jsonmodel_type" => "term",
			"term" => $term,
			"term_type" => ($idx ? "geographic" : "function"),
			"vocabulary" => "/vocabularies/" . $api[$env]["vocabularies"]["location"]
		];
	}
	$subjectId = saveApi($conn, $apiObject, '/subjects', null, null, null, null, TRUE);
	$query = "UPDATE locationMigration SET ".$env."_".$qualifier."_id = ".$subjectId." WHERE key = '" . $variant.":".urlencode($exactSpec)."';";
	echo $query . PHP_EOL;
	$conn->exec($query);
	return '/subjects/'.$subjectId;

}


//*************************************************************************************************
// 
//

echo print_r($argv, true);
$flag = (count($argv) > 0 && in_array('--flag', $argv));
$help = (count($argv) > 0 && (in_array('--help', $argv) || in_array('-h', $argv)));
$verbose = (count($argv) > 0 && (in_array('--verbose', $argv) || in_array('-v', $argv)));
$stage1 = (count($argv) > 0 && (in_array('--1', $argv) || in_array('-1', $argv) || in_array('--init', $argv)));
$stage2 = (count($argv) > 0 && (in_array('--2', $argv) || in_array('-2', $argv) || in_array('--agents', $argv)));
$stage3 = (count($argv) > 0 && (in_array('--3', $argv) || in_array('-3', $argv) || in_array('--tracks', $argv)));
$stage4 = (count($argv) > 0 && (in_array('--4', $argv) || in_array('-4', $argv) || in_array('--tapes', $argv)));
$stage5 = (count($argv) > 0 && (in_array('--5', $argv) || in_array('-5', $argv) || in_array('--trackLinks', $argv)));
$limit = (count($argv) > 0 && in_array('--limit', $argv));
$tags = (count($argv) > 0 && in_array('--tags', $argv));
$tacl = (count($argv) > 0 && in_array('--tacl', $argv));
$qualifyIA = (count($argv) > 0 && in_array('--qualifyIA', $argv));
$qualifyRA = (count($argv) > 0 && in_array('--qualifyRA', $argv));

echo "Limit : ".($limit ? "TRUE" : "FALSE").PHP_EOL;
// Tapes
//$limitIds = "(3, 12, 1931, 6717, 8070, 8215, 8267)";
//$limitIds = "(3, 12, 1931, 6717, 8070, 8215, 8267, 3904, 5441, 87, 7702)";
$limitIds = "(915, 1744, 4148, 4149, 4190, 4225)";

if (empty($stage1) && empty($stage2) && empty($stage3) && empty($stage4) && empty($stage5)) {
	$stage1 = $stage2 = $stage3 = $stage4 = $stage5 = TRUE;
}

if ($help || $verbose) {
	echo "
--1, -1, --init        Stage 1 migration: Create the required migration tables in the local Postgres database.
--2, -2, --agents      Stage 2 migration: Process Agents only
--3, -3, --tracks      Stage 3 migration: No tape or agent updates, tracks only updated if there are forward or backward links in a continuation chain
--4, -4, --tapes       Stage 4 migration: Process Tapes only
--5, -5, --trackLinks  Stage 5 migration: No tape or agent updates, tracks only updated if there are forward or backward links in a continuation chain
--dev           Process the local dev environment. Takes Prioriy over --test and --live. Default.
--flag          Tag Agents primary surnames and Tape titles with [Migration]
--help, -h      Display this help message. Does not carry out migration tasks.
--limit         Restrict migration to data relevant to the following tape ids : ".$limitIds."
--live          Process the live environment. Not currently configured.
--objects       Dump the archival_objects for this environment. Does not carry out migration tasks.
--qualifyIA     Not implemented yet.
--qualifyRA     Qualify Recording Area locations on Tracks.
--tacl          Add Track Agent Copyright Links (not dev environment as not compatible with v2.7.1)
--tags          Include tags like <geogname>, <title> on appropriate notes.
--test          Process the test environment. Takes Prioriy over --live.
--update        Update any existing records. Omitting will cause only records which have previously not been uploaded to be processed. 
--verbose, -v

Pre-requisites:
The resource is manually set up, as is the Fonds, and the 3 sub-fonds.
The Fonds etc must be set up between Stages 3 and 4.
The Extents extent type controlled list has the entry \"digital file\" added.
The Date certainty controlled list has the entry \"certain\" added (Can't add in my local AS).
Live is v2.7.1 (change to handling of object languages): Test has been updraded to a July build.
Agent name sources to include custom options \"TAD English\" and \"TAD Gaelic\"
The user used to upload the data must have the ability to Delete Agents and Archival Objects.

Notes and Restrictions
There doesn't seem to be an \"Other\" language to pick on my local AS.
I can't delete objects in the test system: \"[Gap]\" tracks, \"SA1979.011 IGNORE Failed Migration - DELETE\"
Additional Tapes in DEV, not Test: SA1953.038
Additional Object \"Ruidhle nan Cailleach, 03 August 1950\"
If we need to revert the Gap tracks, need to remove records from the trackMigration table.
10 track records where tape cat_id <> track cat_id : so it is no longer the link joining them: don't migrate as will confuse.
Tape cataloguer_id, editor_id always null.
We have had to discard the season when used in dates (e.g. \"Summer\").

";
	if ($help)
		exit(0);
}

if (count($argv) > 0 && in_array('--dev', $argv)) {
  $env = 'dev';
} else if (count($argv) > 0 && in_array('--test', $argv)) {
  $env = 'test';
} else if (count($argv) > 0 && in_array('--live', $argv)) {
  $env = 'live';
}

echo "Using ".strtoupper($env)."\n"; 

try{
  // creates the PostgreSQL database connection
  $conn = new PDO($dsn);
} catch (PDOException $e){
  // should there be an error lets get that and show it to the user.
  echo "Error during connection - " . $e->getMessage() . "\n";
  exit(0);
}

if (count($argv) > 0 && in_array('--objects', $argv)) {
  $sessionTime = time();
  getApiSession();
  $archObjIds = getApi($conn, '/repositories/' . $api[$env]["repositoryId"] . '/archival_objects?all_ids=true');
  foreach ($archObjIds as $archObjId) {
	echo json_encode(getApi($conn, '/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $archObjId)) . PHP_EOL . PHP_EOL;
//	print_r(getApi($conn, '/repositories/' . $api[$env]["repositoryId"] . '/archival_objects/' . $archObjId));
  }
  exit(0);
}


//*************************************************************************************************
// Initialisation
//*************************************************************************************************
if ($stage1) {
	echo "\n\nSTAGE 1 Initialisation\n";
	echo "Creating table agentMigration\n";
	$sqlList = "CREATE TABLE IF NOT EXISTS agentMigration (person_id serial PRIMARY KEY, dev_remote_agent_id integer, test_remote_agent_id integer, live_remote_agent_id integer);";
	echo $sqlList."\n";
	$conn->exec($sqlList);
	
	echo "Creating table tapeMigration\n";
	$sqlList = "CREATE TABLE IF NOT EXISTS tapeMigration (tape_id serial PRIMARY KEY, dev_remote_resource_id integer, test_remote_resource_id integer, live_remote_resource_id integer);";
	echo $sqlList."\n";
	$conn->exec($sqlList);

	echo "Creating table trackMigration\n";
	$sqlList = "CREATE TABLE IF NOT EXISTS trackMigration (track_id serial PRIMARY KEY, dev_remote_object_id integer, test_remote_object_id integer, live_remote_object_id integer);";
	echo $sqlList."\n";
	$conn->exec($sqlList);

	echo "Creating table locationMigration\n";
	$sqlList = "CREATE TABLE IF NOT EXISTS locationMigration (
	key TEXT PRIMARY KEY,
	dev_exact_id integer,
	dev_existing boolean,
	dev_rec_id integer,
	dev_item_id integer,
	test_exact_id integer,
	test_existing boolean,
	test_rec_id integer,
	test_item_id integer,
	live_exact_id integer,
	live_existing boolean,
	live_rec_id integer,
	live_item_id integer
);";
	echo $sqlList."\n";
	$conn->exec($sqlList);
	echo "Database initialisation complete\n";
}

$sessionTime = time();
getApiSession();

//*************************************************************************************************
// Agents
//*************************************************************************************************
if ($stage2) {
	echo "\n\nSTAGE 2 Agents\n";
	$query = "SELECT aM.". $api[$env]["agentColumn"] ." as remote_id, cp.*,
cn.ntext as note, cn2.ntext as cnote,
cb.status_en, cb.text_en, cb.status_gd, cb.text_gd,
cna.nonuk,
cl1.name_en as county_en, cl1.name_gd as county_gd,
cl2.name_en as island_en, cl2.name_gd as island_gd,
cl3.name_en as parish_en, cl3.name_gd as parish_gd,
cl4.name_en as village_en, cl4.name_gd as village_gd
FROM catalogue_person cp
LEFT JOIN agentMigration aM ON aM.person_id = cp.id
LEFT JOIN catalogue_note cn ON cn.person_id = cp.id
LEFT JOIN catalogue_note cn2 ON cn2.person_c_id = cp.id
LEFT JOIN catalogue_bio cb ON cb.person_id = cp.id
LEFT JOIN catalogue_nativearea cna ON cna.person_id = cp.id
LEFT JOIN catalogue_location cl1 ON cl1.id = cna.county_id
LEFT JOIN catalogue_location cl2 ON cl2.id = cna.island_id
LEFT JOIN catalogue_location cl3 ON cl3.id = cna.parish_id
LEFT JOIN catalogue_location cl4 ON cl4.id = cna.village_id
WHERE cp.id in 
(SELECT ctpl.person_id from catalogue_trackpersonlink ctpl
JOIN catalogue_track ctr ON ctr.id = ctpl.track_id
JOIN catalogue_tape cta ON cta.id = ctr.tape_id
" . ($limit ? "WHERE cta.id IN ".$limitIds : "") . ")
-- AND cp.id in (4776, 9516, 9541, 9542, 9719, 9731, 9732, 10750)
ORDER BY cp.id
;";
	echo $query;
	foreach ($conn->query($query) as $row) {
		echo "\n";
		if ((time()-$sessionTime) > 30*60 /* 30 minutes */) {
			echo "Resetting API Session\n";
			$sessionTime = time();
			getApiSession();
		}
		processAgent($conn, $row);
	}
}

//*************************************************************************************************
// Tracks
//*************************************************************************************************
if ($stage3) {
	echo "\n\nSTAGE 3 Tracks\n";
	readGenreTerms($conn);
	prepLocationSubject($conn, $env);

	$query = "SELECT tM.". $api[$env]["trackColumn"] ." as remote_id, ct.*,
	cn.ntext as note, cn2.ntext as un_note,
	cn3.ntext as item_note, cn4.ntext as item_pub_note, ccc.statement,
	cra.nonuk as rec_nonuk,
	ci.summary_en, ci.summary_gd, ci.summary_sco, ci.itime, ci.datestart, ci.dateend, ci.classification, ci.person,
	clr1.id AS rec_county_id, clr1.name_en as rec_county_en, clr1.name_gd as rec_county_gd,
	clr2.id AS rec_parish_id, clr2.name_en as rec_parish_en, clr2.name_gd as rec_parish_gd,
	clr3.id AS rec_island_id, clr3.name_en as rec_island_en, clr3.name_gd as rec_island_gd,
	clr4.id AS rec_village_id, clr4.name_en as rec_village_en, clr4.name_gd as rec_village_gd,
	cia.nonuk as item_nonuk,
	cli1.id AS item_county_id, cli1.name_en as item_county_en, cli1.name_gd as item_county_gd,
	cli2.id AS item_parish_id, cli2.name_en as item_parish_en, cli2.name_gd as item_parish_gd,
	cli3.id AS item_island_id, cli3.name_en as item_island_en, cli3.name_gd as item_island_gd,
	cli4.id AS item_village_id, cli4.name_en as item_village_en, cli4.name_gd as item_village_gd,
	ci.lang_en, ci.lang_gd, ci.lang_sco, ci.lang_oth,
	cta.source
FROM catalogue_track ct
JOIN catalogue_tape cta ON cta.id = ct.tape_id " . ($limit ? "AND cta.id IN ".$limitIds : "") . "
LEFT JOIN catalogue_computedcopyright ccc ON ccc.track_id = ct.id
LEFT JOIN catalogue_note cn ON cn.track_id = ct.id
LEFT JOIN catalogue_note cn2 ON cn2.track_un_id = ct.id
LEFT JOIN catalogue_recordingarea cra ON cra.track_id = ct.id
LEFT JOIN catalogue_location clr1 ON clr1.id = cra.county_id
LEFT JOIN catalogue_location clr2 ON clr2.id = cra.parish_id
LEFT JOIN catalogue_location clr3 ON clr3.id = cra.island_id
LEFT JOIN catalogue_location clr4 ON clr4.id = cra.village_id
LEFT JOIN catalogue_item ci ON ci.track_id = ct.id
LEFT JOIN catalogue_itemarea cia ON cia.item_id = ci.id
LEFT JOIN catalogue_location cli1 ON cli1.id = cia.county_id
LEFT JOIN catalogue_location cli2 ON cli2.id = cia.parish_id
LEFT JOIN catalogue_location cli3 ON cli3.id = cia.island_id
LEFT JOIN catalogue_location cli4 ON cli4.id = cia.village_id
LEFT JOIN catalogue_note cn3 ON cn3.item_id = ci.id
LEFT JOIN catalogue_note cn4 ON cn4.item_pub_id = ci.id
LEFT JOIN trackMigration tM ON tM.track_id = ct.id
WHERE ct.id = 100804
ORDER BY ct.id;
";
	// echo $query;
	foreach ($conn->query($query) as $row) {
		if ((time()-$sessionTime) > 30*60 /* 30 minutes */) {
			echo "Resetting API Session\n";
			$sessionTime = time();
			getApiSession();
		}
		// print_r($row);
		processTrack($conn, $row);
	}
}

//*************************************************************************************************
// Tapes
// All the tracks are pulled under the tape when a tape is created.
//*************************************************************************************************
if ($stage4) {
	echo "\n\nSTAGE 4 Tapes\n";
	$query = "SELECT tM.". $api[$env]["tapeColumn"] ." as remote_id, ct.*,
cn.ntext as note, cn2.ntext as catnote, cb.site as batch_site
FROM catalogue_tape ct
LEFT JOIN catalogue_note cn ON cn.tape_id = ct.id
LEFT JOIN catalogue_note cn2 ON cn2.tape_cat_id = ct.id
LEFT JOIN catalogue_batch cb ON cb.id = ct.batch_id 
LEFT JOIN tapeMigration tM ON tM.tape_id = ct.id " .
($limit ? "WHERE ct.id IN ".$limitIds : "") . 
"
-- WHERE ct.id >= 17840
ORDER BY ct.id " .
// ($limit ? "LIMIT 10" : "") . 
";";
	echo $query;
	foreach ($conn->query($query) as $row) {
		if ((time()-$sessionTime) > 30*60 /* 30 minutes */) {
			echo "Resetting API Session\n";
			$sessionTime = time();
			getApiSession();
		}
		processTape($conn, $row);
	}
}

//*************************************************************************************************
// Track Links
//*************************************************************************************************
if ($stage5) {
	echo "\n\nSTAGE 5 Track links\n";
	$query = "SELECT tM.". $api[$env]["trackColumn"] ." as remote_id,
	ct.*,
	ct_next.id as next_id,
	tM_next.". $api[$env]["trackColumn"] ." as next_remote_id,
	tM_previous.". $api[$env]["trackColumn"] ." as previous_remote_id
FROM catalogue_track ct
JOIN trackMigration tM ON tM.track_id = ct.id
LEFT JOIN catalogue_track ct_next ON ct_next.parent_id = ct.id 
LEFT JOIN trackMigration tM_next ON ct_next.id = tM_next.track_id
LEFT JOIN trackMigration tM_previous ON ct.parent_id = tM_previous.track_id
WHERE (ct.parent_id IS NOT NULL OR ct_next.id IS NOT NULL)
AND ct.id = 100804
" .
($limit ? "AND ct.tape_id IN ".$limitIds : "") . 
"
ORDER BY ct.tape_id, ct.start_time;
";
	// echo $query;
	foreach ($conn->query($query) as $row) {
		// print_r($row);
		if ((time()-$sessionTime) > 30*60 /* 30 minutes */) {
			echo "Resetting API Session\n";
			$sessionTime = time();
			getApiSession();
		}
		processTrackLinks($conn, $row);
	}
}

/* API Notes

Repositories: We have a single top level repository for TOBAR: this will be created manually. The accession record will similarly dealt with manually.
Repository Resource records: These are the top level under the Repository itself: we will have 3, one per collection, manually created.

People agents: will correspond to people. Created by my app.
Repository classifications: 
Repository archival objects: used to create series, sub-series, and items.
	Each has a title, a level (e.g. 'series') an array of subjects, an array of external ids, a lang materials array, rights statements array, linked_agents array
	Note sure how the ids are passed back when doing a batch create under a parent
Repository classification & their terms: will only create terms.
Subjects: used to store locations.

Not Sure
Enumerations
Repository events? Is the act of recording an event, or is it something that happens in the archive?
Vocabularies

Not used
Corporate entity agents
Family agents
Software agents.
Ark
Container Profles: used when describing what a physical material is stored in. CONFIRM we are not migrating any data related to the physical storage of the tapes.
Locations and location profiles: Ditto
Digital object: I am not doing this aspect.
Accessions
Repository archival contexts.
Repository assessments
Repository groups: I think this is like user roles.
Repository Jobs: is this batch propcessing?
Repository preferences, rde_templates, required_fields, top_containers

Routes by URI

*/
