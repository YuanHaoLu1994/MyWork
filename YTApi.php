<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class YTApi extends CI_Controller {

	public function index()
	{
		
		exit(1);
		if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php')) {
		  throw new Exception(sprintf('Please run "composer require google/apiclient:~2.0" in "%s"', __DIR__));
		}
		require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
		
		$client = new Google_Client();
		$client->setRedirectUri('http://naertest.proshine.com.tw/intra/YTApi/Callback');
		$client->setApplicationName('API code samples');
		$client->setScopes([
			'https://www.googleapis.com/auth/youtube.upload',
			'https://www.googleapis.com/auth/youtube',
			'https://www.googleapis.com/auth/youtubepartner'
		]);
		
		$client->setAuthConfig($_SERVER['DOCUMENT_ROOT'].'/client_secret_955184816048-no0skn5i5lmrfka1bv6idpel8303hhlr.apps.googleusercontent.com.json');
		$client->setAccessType('offline');
		$authUrl = $client->createAuthUrl();
		redirect($authUrl);
	}
	
	public function Callback()
	{
		if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php')) {
		  throw new Exception(sprintf('Please run "composer require google/apiclient:~2.0" in "%s"', __DIR__));
		}
		require_once $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';
		
		$client = new Google_Client();
		$client->setRedirectUri('http://naertest.proshine.com.tw/sample.php');
		$client->setApplicationName('API code samples');
		$client->setScopes([
			'https://www.googleapis.com/auth/youtube.upload',
			'https://www.googleapis.com/auth/youtube',
			'https://www.googleapis.com/auth/youtubepartner'
		]);
		
		$client->setAuthConfig($_SERVER['DOCUMENT_ROOT'].'/client_secret_955184816048-no0skn5i5lmrfka1bv6idpel8303hhlr.apps.googleusercontent.com.json');
		$client->setAccessType('offline');
		
		if (isset($_GET['code'])) {
			$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
		}
		$client->setAccessToken($token);
		
		$youtube = new Google_Service_YouTube($client);
		
		/*
		// Define service object for making API requests.
		$service = new Google_Service_YouTube($client);

		$queryParams=array("file"=>$_SERVER['DOCUMENT_ROOT']."\WIN_20200818_10_38_20_Pro.mp4","title"=>"TEST VIDEO","description"=>"test description"."category_id"=>"22","keywords"=>"","privacy_status"=>"private");

		$response = $service->channels->listChannels('snippet,contentDetails,statistics', $queryParams);
		print_r($response);
		*/
		
		// REPLACE this value with the path to the file you are uploading.
		$videoPath = $_SERVER['DOCUMENT_ROOT']."/WIN_20200818_10_38_20_Pro.mp4";

		// Create a snippet with title, description, tags and category ID
		// Create an asset resource and set its snippet metadata and type.
		// This example sets the video's title, description, keyword tags, and
		// video category.
		$snippet = new Google_Service_YouTube_VideoSnippet();
		$snippet->setTitle("Test title");
		$snippet->setDescription("Test description");
		$snippet->setTags(array("tag1", "tag2"));

		// Numeric video category. See
		// https://developers.google.com/youtube/v3/docs/videoCategories/list
		$snippet->setCategoryId("22");

		// Set the video's status to "public". Valid statuses are "public",
		// "private" and "unlisted".
		$status = new Google_Service_YouTube_VideoStatus();
		$status->privacyStatus = "private";

		// Associate the snippet and status objects with a new video resource.
		$video = new Google_Service_YouTube_Video();
		$video->setSnippet($snippet);
		$video->setStatus($status);

		// Specify the size of each chunk of data, in bytes. Set a higher value for
		// reliable connection as fewer chunks lead to faster uploads. Set a lower
		// value for better recovery on less reliable connections.
		$chunkSizeBytes = 1 * 1024 * 1024;

		// Setting the defer flag to true tells the client to return a request which can be called
		// with ->execute(); instead of making the API call immediately.
		$client->setDefer(true);

		// Create a request for the API's videos.insert method to create and upload the video.
		$insertRequest = $youtube->videos->insert("status,snippet", $video);

		// Create a MediaFileUpload object for resumable uploads.
		$media = new Google_Http_MediaFileUpload(
			$client,
			$insertRequest,
			'video/*',
			null,
			true,
			$chunkSizeBytes
		);
		$media->setFileSize(filesize($videoPath));


		// Read the media file and upload it chunk by chunk.
		$status = false;
		$handle = fopen($videoPath, "rb");
		while (!$status && !feof($handle)) {
		  $chunk = fread($handle, $chunkSizeBytes);
		  $status = $media->nextChunk($chunk);
		}

		fclose($handle);

		// If you want to make other calls after the file upload, set setDefer back to false
		$client->setDefer(false);

		$htmlBody="";
		$htmlBody .= "<h3>Video Uploaded</h3><ul>";
		$htmlBody .= sprintf('<li>%s (%s)</li>',
			$status['snippet']['title'],
			$status['id']);

		$htmlBody .= '</ul>';

	}
	
	
	
	public function testname()
	{
		$t1 = 1;
		$t2 = 16;
		$t4 = 16;
		
		for($i=1;$i<30;$i++){
			for($j=1;$j<30;$j++){
				$t3 = $i;
				$t4 = $j;
				$s1 = $t1+$t2;
				$s2 = $t2+$t3;
				$s3 = $t3+$t4;
				$sa = $t2+$t3+$t4;
				
				if($this->getnumtype($s2)=="土") continue;
				if($this->getnumtype($s3)=="土") continue;
				//if($this->getnumtype($s2)=="金") continue;
				if($this->getnumtype($s3)=="金") continue;
				if($this->isnicenum($s1)=="凶") continue;
				if($this->isnicenum($s2)=="凶") continue;
				if($this->isnicenum($s3)=="凶") continue;
				if($this->isnicenum($sa)=="凶") continue;
				if($this->isnicetype($this->getnumtype($s1).$this->getnumtype($s2).$this->getnumtype($s3))=="【凶】") continue;
				
				echo '</p>'.$t3.'+'.$t4.'=>'.$this->getnumtype($s1).$this->getnumtype($s2).$this->getnumtype($s3).
				" ==>".$s1.' '.$s2.' '.$s3.'='.$sa.
				" ==>".$this->isnicenum($s1).' '.$this->isnicenum($s2).' '.$this->isnicenum($s3).' '.$this->isnicenum($sa).
				" ==>".$this->isnicetype($this->getnumtype($s1).$this->getnumtype($s2).$this->getnumtype($s3)).'<br/>'.
				" ==>".$this->typedetail($this->getnumtype($s1).$this->getnumtype($s2).$this->getnumtype($s3)).'</p>';
			}
		}
	}
	
	public function getnumtype($n)
	{
		switch($n%10){
			case 1:case 2: return '木';break;
			case 3:case 4: return '火';break;
			case 5:case 6: return '土';break;
			case 7:case 8: return '金';break;
			case 9:case 0: return '水';break;
		}
	}
	
	public function isnicenum($n)
	{
		switch($n)
		{
			case 3: case 13: case 16: case 21: case 23: case 29: case 31: case 37: case 39: case 41: case 45: case 47:
			return '首領';
			break;
			case 15: case 16: case 24: case 29: case 32: case 33: case 41: case 52:
			return '財富';
			break;
			case 13: case 14: case 18: case 26: case 29: case 33: case 35: case 38: case 48:
			return '藝能';
			break;
			case 1: case 3: case 5: case 7: case 8: case 11: case 13: case 15: case 16: case 18: case 21: case 23: case 24: case 25: case 31: case 32: case 33: case 35: case 37: case 39: case 41: case 45: case 47: case 48: case 52: case 57: case 61: case 63: case 65: case 67: case 68: case 81:
			return '吉';
			break;
			case 6: case 17: case 26: case 27: case 29: case 30: case 38: case 49: case 51: case 55: case 58: case 71: case 73: case 75:
			return '次吉';
			break;
			case 2: case 4: case 9: case 10: case 12: case 14: case 19: case 20: case 22: case 28: case 34: case 36: case 40: case 42: case 43: case 44: case 46: case 50: case 53: case 54: case 56: case 59: case 60: case 62: case 64: case 66: case 69: case 70: case 72: case 74: case 76: case 77: case 78: case 79: case 80:
			return '凶';
			break;
			
		}
	}
	
	public function isnicetype($type)
	{
		switch($type)
		{
			case '水木木': case '水木火': case '水木土': case '水木水': case '水金土': case '水金水': case '水水木': case '水水金':
			case '金土火': case '金土土': case '金土金': case '金金土': case '金水木': case '金水金':
			return '【大吉】'; break;
			case '水火木': case '水土火': case '水木土': case '水土土': case '水土金': case '水水金': case '水水水':
			case '金土木': case '金水水': case '金金水': 
			return '【中吉】';break;
			default: return '【凶】';break;
		}
	}
	
	public function typedetail($type)
	{
		switch($type)
		{
			//金
			case '金土木':
			return '欣慶果能成功順調，容易發展達到目的，亦能成富、成貴，唯在幼少年期之境遇不穩安而較多變化、若為凶數尤其以幼少年期間，恐有胃腸疾患及遭崩塌或墜落物所傷之慮。 【中吉．＋８０分】';
			break;
			
			case '金土火':
			return '可獲得意外之大成功，名利雙收，且得大發展，諸事順利隆昌，大吉大利。但數理若凶則恐好景不長。若無凶數，則可免憂慮。 【大吉昌．＋９０分】';
			break;
			
			case '金土土':
			return '易達目的，輕易成功，名利雙收，一帆風順，福泰鴻量，萬事安寧，順利發展，生涯境遇安泰，即使數理有凶也可免於災禍。 【大吉昌．＋９０分】';
			break;
			
			case '金土金':
			return '基礎穩固，希望易達，順利成功發展，名譽與福份倆俱充足，隆昌威儀，大成功、大餘慶、繁華榮隆。 【大吉昌．＋９０分】';
			break;
			
			case '金土水':
			return '青年多勞，切莫悲觀則勞終有成，與人合夥須善處理，更勝獨營。於中年或壯年可得成功，名利雙收，並得大發展之慶，可惜因基礎運劣，使成功運受牽制，故突發之災遇或損失也不少。【吉多於凶．＋４０分】';
			break;
			
			case '金金土':
			return '容易成功，達到目的，境遇安固，身心健全，名利雙收，威權顯達，運勢昌隆。 【大吉昌．＋９０分】';
			break;
			
			case '金金水':
			return '以堅志毅力，克服艱難，達成功擴展，身心皆健，若生辰之原命喜金水者，得此名獲【＋９０分】。但人、地兩格其一是凶者，則雖也能成功發展於一時，但終因急變而逐漸的沒落崩敗或失和、孤立或遭遇危身災險。 【中吉．＋８０分】';
			break;
			
			case '金水木':
			return '境遇安全，長輩惠澤，承受父祖之餘德，前輩之提拔，而可獲得意外之成功發達。但數理若凶，或許陷於病弱。 【大吉昌．＋９０分】';
			break;
			
			case '金水土':
			return '得長輩或上司之惠助，再加上自身之勤勉，而於中年或壯年可獲得相當之發展，但因基礎運劣之故，於成功之後，又會有很多次之再成敗，生涯多勞，難亨安逸，幸而水在土上，池塘之家，亦順天然之景故，雖是相剋，凶意則微。 【吉多於凶．＋４０分】';
			break;
			
			case '金水金':
			return '基礎穩固安然，財源廣進，又有父祖之蔭益及上司之提拔，易得意外之助力，而可獲得大成功，大發展，名利豐收。威權、名望、地位俱皆興隆寬宏殊勝之配置。 【大吉昌．＋９０分】';
			break;
			
			case '金水水':
			return '承父祖之餘德，得長者之栽培，或用人得當，得大成功及發展，原命若喜水木者更佳【９０分】。若凶數者：成又轉敗，陷於離亂變動，至晚年終歸孤獨失敗，又早年有落水災遇，生涯九死一生之命格。又須戒色，以防色變及刀殺之危。 【中吉．＋８０分】';
			break;
		}
	}

	/*
	case '水木木':
			return '基礎安泰，長輩惠助，排除萬難，而順利成功及發展，繁榮隆昌，人緣殊勝，利蔭六親。 【大吉昌．＋９０分】';
			break;

			case '水木火':
			return '可得平安榮華之幸運，及能受父祖餘德或財力所蔭益，達到成功與大發展，但其過程伏有許多艱難，最怕人格與地格若凶數，終歸失敗，若無凶數，則可免憂。 【大吉．＋９０分】';
			break;

			case '水木土':
			return '基礎運乃木在上而土在下，順應天地自然之配置（不作木土相剋論），猶若立於磐石之上，相得益彰而毫無凶變，境遇安全而順利之安泰成功，並隆昌發達。 【大吉昌．＋９０分】';
			break;

			case '水木金':
			return '雖可獲得成功及發展於一時，亨受富貴於短暫，但因基礎運劣，以致境遇不穩，若忍耐力不夠，恐遭難受傷或傷人，且財利易生凶變，終再失敗，且有因他人之連累以致破財及受到武器之迫害殺傷流血之慮。 【凶多於吉．－１５分】';
			break;

			case '水木水':
			return '青年期甚勞苦，因勤奮求上進而在中年末，雖可很順利成功並發展隆昌長久。但人、地格，有凶數者：在晚年或許會再產生艱難、困苦、勞心，甚至遭致失敗之憂。此三才局，若數理無凶，即無病，有病吃藥便可速癒。 【大吉昌．＋９０分】';
			break;

			case '水火木':
			return '境遇堅固安泰，有下屬之助力，地位、財產均安全，以木解消水火之相剋，致成功，但若人地格有凶數，於成功後，難以伸展，且有突發之災禍、遭難等之慮，更容易發生因愛情上而產生之不測災難、凶變等。【中吉．＋６５分】';
			break;

			case '水火火':
			return '一時之盛運，如曇花一現而已，短暫而缺乏耐久力，容易樹敵惹禍而自陷於孤立苦鬥，成功運甚劣，多成多敗，縱使成功，旋即再敗，不能有所伸展，且有火災、水災等凶變急禍，諸不測之災慘，以傷人或自危或喪失配偶，或短命夭壽之凶配置也。如果人格或地格其一：出現２３數或１４數尤糟，不能免於色危厄致慘之運。 【大凶．－３０分】';
			break;

			case '水火土':
			return '基礎運堅實而可成功於一時，但因成功運被抑壓以致不能有所伸展，生涯殊多艱難、不幸、不滿、哀怨，中年後又有突發急變之不測災禍而危及生命之慮。 【凶多於吉．－１５分】';
			break;

			case '水火金':
			return '至劣之三才配置，決不能成功，亦不能伸展，常受上司壓追又屢受下屬陷害，很不安定，內外不和，進退兩難，身心過勞，作事極端偏激招災遭難變死或發狂傷人或失配偶、喪子等之兆。 【大凶．－３０分】';
			break;

			case '水火水':
			return '極凶之三才配置，百般阻礙與迫害殊多，無形之心病甚重，永不能成功，亦不能伸展，而且生涯絕對的不安定，大不祥，大災遇，有意外不測之急禍凶變而喪失生命或財產，死神常在其身邊，有的變成發狂、殺人或被殺、變死等。 【大凶．－３０分】';
			break;

			case '水土木':
			return '木在下而土在上：與自然狀態顛倒便是凶，此謂（木剋土）矣，基礎運劣，境遇不安定，以致變死或移動，仍是障害多端，困難及苦楚殊多，成功困難，無法發展，失意一世，遭崩物傷或意外不測災危以致短壽變死。 【大凶．３０分】';
			break;

			case '水土火':
			return '基礎安定，能逃災害，排除障礙而達到成功。不過卻因成功運不吉，不能再伸展。不能將天賦才能以完全發展，使其成就與精華俱皆受到打折，殊為可惜，又須深戒提防色難之憂。 【中吉．＋６５分】若人格或地格數理凶，則有病，導致頭腦神經症或心臟病。';
			break;

			case '水土土':
			return '境遇安定，平順幸福，能排除困難，廣得人助，而得到名利雙收之大成功，生活安逸，可惜因成功運不理想，是以向上伸展產生障礙多端，只能維持原有舊日之成就現狀而已。 【中吉．＋６５分】此三才局：人格地格之數理若無凶，則健康，無病，快樂的。';
			break;

			case '水土金':
			return '基礎運佳，故而可以安定發展，排除萬難而成功，但因成功運不吉，是以難於再伸展，或陷於不測之災難襲來之慮，若無凶數則可免憂，亦可康健無病。 【中吉．＋５分】';
			break;

			case '水土水':
			return '三才配置極劣，基礎不穩，凶運交加襲來，而又不能向上發展，生涯絕對不安定，被人所棄變為孤獨、無賴、遭難、病死等兆，又有不測之凶變災禍危身或變死之慮，易遭墜物所傷或趺落之災。【大凶．－３０分】';
			break;

			case '水金木':
			return '雖可順利成功發展如意，但因基礎運不安定之故，常有變動之凶，浮沈多端，風波不息，易變成剋妻子或遭難外傷、流血等厄之慮。 【凶多於吉．－１５分】';
			break;

			case '水金火':
			return '雖因勤奮爭進而有成功運，達成目的，但因基礎運不穩，常會再陷於不安定之境遇，而多成多敗，易受人迫害，且終因過勞而招致肺疾或遭難、凶變等。 【凶多於吉．－１５分】';
			break;

			case '水金土':
			return '學竟有成，凡事如意，順利成功，達成目的，名利雙收，境遇安固，優越發展，享盡幸福。 【大吉昌．＋９０分】';
			break;

			case '水金金':
			return '勤苦竟成之吉兆無疑，勤勉上進，堅志如鐵，個性頑剛，不肯屈服，具有深厚實力之才華，憑以創造錦繡而輝煌之前程，博得功成名就，並得到很大伸展，但唯憾的是與人不大融洽。 【中吉．＋８０分】';
			break;

			case '水金水':
			return '基礎運及成功運皆佳，且身心健全，而可穩達成功發展成富或揚名美譽。若地格凶數則成又轉敗，且遭溺水或水災之損。 【大吉昌．＋９０分】';
			break;

			case '水水木':
			return '基礎運佳，境遇安全，而可順利成功，成功運也不錯，因之亦可向上伸展發達，人格凶數，陷於行為不修，品性不端，恐過於放蕩不羈之境，易生破亂變動或荒亡流敗之慮，請好自為之，而得免於損折自福。若無凶數便無災禍之憂。 【大吉．＋９０分】';
			break;

			case '水水火':
			return '行為不修，放蕩成性，任性隨便，荒淫不修，無可救藥，正是十足浪子型之局勢，易生多次失敗困苦，生涯不安定，顛沛流離，荒亡流敗，風浪不息，落魄天涯，每因色情而生禍端災遇，否則常遭突發不測之災禍或變死短命。 【大凶．－３０分】';
			break;

			case '水水土':
			return '表面似乎安定，其實境遇不穩，終生非常苦勞，雖可得到小成之名利與成就，亦有小成之發展，卻是常遭不時之災難，或有小賊人之害，或病難或家庭之不幸，或破財倒霉多端，或不測喪生等慮。 【大凶．－３０分】';
			break;

			case '水水金':
			return '基礎健固，境遇安然，勤智交輝而能博得財利名譽以及名利雙收，大成功，大發展之兆，但若品行不修，不守正道，便會淪陷於刑牢獄之災，若多不平不滿則與人不和，荒亡流散或有害健康，若無凶數便無災。 【大吉．＋９０分】';
			break;

			case '水水水':
			return '唯獨若有連珠局者，論為大吉，原命喜水尤佳。有一時之大勢力，大發展而得名取利，但若品行不端，行為不修，勝與敗均極端而短暫終於變成荒亡流散，如泡沬夢幻而結果是悲運滅亡又孤獨伶仃人生。 【中吉．＋６５分】';
			break;
	
	*/
	
	
}
