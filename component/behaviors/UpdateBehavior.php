<?php
class UpdateBehavior extends CActiveRecordBehavior
{
        public function beforeSave($event)
        {
        	if ($event->sender->isTableFiled(CMSActiveRecord::MODIFY_TIME_FIELD))
           		$event->sender->{CMSActiveRecord::MODIFY_TIME_FIELD} = new CDbExpression('NOW()');
        	
        	if ($event->sender->isTableFiled(CMSActiveRecord::MODIFY_USER_FIELD))
				$event->sender->{CMSActiveRecord::MODIFY_USER_FIELD} = WebUser::Instance()->user->user_name;
        }
}