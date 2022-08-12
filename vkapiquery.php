<?php

class VKAPIQuery
{
	protected function vkQuery($api_method, $params)
	{
		$msg = '';
		$url = 'https://api.vk.com/method/' . $api_method . '?' . http_build_query($params);
		$contents = @file_get_contents($url);
		if (empty($contents))
		{
			
			$error = error_get_last();
			if ($error['type'] == 2)
			{
				$msg = 'ОШИБКА: не получен ответ от api.vk.com, проверьте соединение. Текст ошибки:' . PHP_EOL;
			}
			$msg = $msg . $error['type'] . ': ' . $error['message'] . PHP_EOL;
			exit($msg);
		}
		
		$decoded = json_decode($contents, true);
		if ($decoded == null)
		{
			exit('ОШИБКА: ошибочный ответ от api.vk.com, проверьте соединение.' . PHP_EOL);
		}
		if (array_key_exists('error', $decoded))
		{
			$de = $decoded['error'];
			exit('ОШИБКА: api.vk.com вернул ошибку:' . PHP_EOL . $de['error_code'] . ': '  . $de['error_msg']);

		}
		return $decoded['response'];
	}
	
}

?>
 