<?php
class UpdateMongoBehavior extends CActiveRecordBehavior
{
	public function beforeSave($event)
	{
		if ($event->sender->isTableFiled(CMSMongoActiveRecord::MODIFY_TIME_FIELD))
			$event->sender->{CMSMongoActiveRecord::MODIFY_TIME_FIELD} = time();
		 
		//if ($event->sender->isTableFiled(CMSActiveRecord::MODIFY_USER_FIELD))
			//$event->sender->{CMSActiveRecord::MODIFY_USER_FIELD} = WebUser::Instance()->user->user_name;
	}
}
