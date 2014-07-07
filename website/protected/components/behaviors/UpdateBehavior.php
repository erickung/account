<?php
class UpdateBehavior extends CActiveRecordBehavior
{
        public function beforeSave($event)
        {
        	if ($event->sender->isTableFiled(RootActiveRecord::MODIFY_TIME_FIELD))
           		$event->sender->{RootActiveRecord::MODIFY_TIME_FIELD} = new CDbExpression('NOW()');
        	
        	if ($event->sender->isTableFiled(RootActiveRecord::MODIFY_USER_FIELD))
				$event->sender->{RootActiveRecord::MODIFY_USER_FIELD} = WebUser::Instance()->user->user_name;
        }
}