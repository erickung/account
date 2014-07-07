<?php
class RabbitMqServ
{
	private $conn;        //rabbitMq服务器连接
	private $channel;     //rabbitMq虚拟主机
	private $exchange;    //rabbitMq交换机
	private $queue;		  //rabbitMq队列
	
	/**
	* 创建队列需要用到的虚拟主机、交换机
	 */
	public function __construct($vhost = '/')
	{
		$conf = RunTime::getRabbitMqConf();
		$conf['vhost'] = $vhost;
		
		if ($this->conn !== null) 
			return $this;
		
		if (!class_exists('AMQPConnection'))
			CMS::loadFile('application.components.ext.AMQPConnection');
		$this->conn = new AMQPConnection($conf);
		
		try 
		{
			$this->conn->connect();
		}
		catch (CException $e)
		{
			CMS::error("cannot connect rabbitmq");
			return false;
		}
	
       return $this;
	}
	
	public function createChannel()
	{
		if ($this->channel !== null) return $this; 
		//创建channel
		$this->channel = new AMQPChannel($this->conn);
		return $this;
	}
	
	//创建exchange交换机
	public function createExchage($name)
	{
		try 
		{
			$this->exchange = new AMQPExchange($this->channel);
			$this->exchange->setName($name);//创建名字
			$this->exchange->setType(AMQP_EX_TYPE_DIRECT);
			$this->exchange->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
			$this->exchange->declare();
		}
		catch (CException $e) 
		{
			$this->error("bind exchange $name " . $e->getMessage());
		}
		
		return $this;
	}
	
	
	public function createQueue($name, $exchange, $route)
	{
		$this->queue = new AMQPQueue($this->channel);
		$this->queue->setName($name);
		$this->queue->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
		$this->queue->declare();
		$this->queue->bind($exchange, $route);
		
		return $this;
	}
	
	public function sendMessage($message, $route)
	{
		try
		{
			$this->channel->startTransaction();
			$this->exchange->publish($message, $route); //将你的消息通过制定routingKey发送
			$this->channel->commitTransaction();
			return true;
		}
		catch (CException $e)
		{
			$this->error("send message error " . $e->getMessage());
			return false;
		}
	}
	
	public function __destruct()
	{
		$this->conn->disconnect();
	}
	
	public function getMessage()
	{
		$messages = $this->queue->get(AMQP_AUTOACK) ;
		return ($messages instanceof  AMQPEnvelope) ? $messages->getBody() : '';
	}
	
	private function error($message)
	{
		CMS::error("RABBITMQ ERRORl: [$message]");
	}
}