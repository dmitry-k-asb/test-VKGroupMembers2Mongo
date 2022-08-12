<?php
require_once('vkapiquery.php');

class VKAllMembersQuery extends VKAPIquery
{
	private const FIELDS = 'first_name, last_name, bdate, country, city';
	private const V      = '5.131';
	private $token;
	private $group_id;
	private $total;
	private $code;
	private $collected;
	
	public function query($token, $group_id)
	{
		$this->total = 0;
		$this->collected = null;
		
		$this->token = $token;
		$this->group_id = $group_id;
		
		$this->queryTotalCount();
		$this->loadExecuteCode();
		$this->queryItems();
		return true;
	}
	
	private function loadExecuteCode()
	{
		$this->code = @file_get_contents('execute_code.txt', true);
		if (empty($this->code))
		{
			exit('Проверьте файл ./execute_code.txt');
		}
		$this->code = str_replace('BIND_group_id', $this->group_id, $this->code);
		$this->code = str_replace('BIND_total',    $this->total,    $this->code);
		$this->code = str_replace('BIND_fields',   self::FIELDS,    $this->code);
		$this->code = str_replace('BIND_v',        self::V,         $this->code);
		return true;
	}
	
	private function queryTotalCount()
	{
		$params =
		[
			'group_id'		=> $this->group_id,
			'access_token'	=> $this->token,
			'v'				=> self::V,
			'count'			=> 0
		];
		$response = $this->vkQuery('groups.getMembers', $params); 
		$this->total = $response['count'];
	}
	private function queryItems()
	{
		$collected = array();
				
		$outer_loop = 0;
		$outer_loop_count = ceil($this->total / 25000);
		
		while ( $outer_loop < $outer_loop_count )
		{
			$items = $this->outerLoop( $outer_loop );
			$collected = array_merge( $collected, $items );
			$outer_loop++;
		}
		$this->collected = $collected;
	}
	
	private function outerLoop($outer_loop)
	{
		$code = str_replace('BIND_outer_loop', $outer_loop, $this->code);
		$params =
		[
			'code'			=> $code,
			'access_token'	=> $this->token,
			'v'				=> self::V
		];
		$response = $this->vkQuery('execute', $params);
		usleep(333333);
		return $response;
	}


	public function getCount()
	{
		return count($this->collected);
	}

	private function calcAge($arg)
	{
		$exploded = explode('.', $arg);
		if (empty($exploded[2]))
		{
			return null;
		}
		$dd = str_pad($exploded[0], 2, '0', STR_PAD_LEFT);
		$mm = str_pad($exploded[1], 2, '0', STR_PAD_LEFT);
		$YY = $exploded[2];
		
		$bdate_str = $YY . '-' . $mm . '-' . $dd;
		$today_str = date('Y-m-d');
		
		$bdate_timestamp = strtotime($bdate_str);
		$today_timestamp = strtotime($today_str);
		
		return (int) ($today_timestamp - $bdate_timestamp) / (60*60*24*365);
	}
	
	public function getCollectedItems()
	{
		$ret = array();
		foreach ($this->collected as $item)
		{
			$city    = null;
			$country = null;
			$bdate   = null;
			$age     = null;
			
			if (array_key_exists('bdate', $item))
			{
				$bdate = $item['bdate'];
				$age   = $this->calcAge($bdate);
			}
			if (array_key_exists('city', $item))
			{
				$city = $item['city']['title'];
			}
			if (array_key_exists('country', $item))
			{
				$country = $item['country']['title'];
			}
			$user =
			[
				'VK ID'         => $item['id'],
				'Имя'           => $item['first_name'],
				'Фамилия'       => $item['last_name'],
				'Дата рождения' => $bdate,
				'Возраст'       => $age,
				'Страна'        => $country,
				'Город'         => $city,
			];
			array_push($ret, $user);
		}
		return $ret;
	}

}
?>