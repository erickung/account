<?php

/**
 * This is the model class for table "modules".
 *
 * The followings are the available columns in table 'modules':
 * @property string $module_id
 * @property string $module_name
 * @property string $parent_module_id
 * @property integer $is_action
 * @property string $controller
 * @property string $action
 * @property string $modify_username
 * @property string $modify_time
 * @property integer $ordering
 *
 * The followings are the available model relations:
 * @property Roles[] $roles
 */
class Modules extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'modules';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'roles' => array(self::MANY_MANY, 'Roles', 'role_module(module_id, role_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'module_id' => 'Module',
			'module_name' => '模块名称',
			'parent_module_id' => '父节点ID',
			'is_action' => '是否是操作节点（叶子节点）',
			'controller' => 'controller的ID',
			'action' => 'action的ID',
			'modify_username' => 'Modify Username',
			'modify_time' => 'Modify Time',
			'ordering' => 'Ordering',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('module_id',$this->module_id,true);
		$criteria->compare('module_name',$this->module_name,true);
		$criteria->compare('parent_module_id',$this->parent_module_id,true);
		$criteria->compare('is_action',$this->is_action);
		$criteria->compare('controller',$this->controller,true);
		$criteria->compare('action',$this->action,true);
		$criteria->compare('modify_username',$this->modify_username,true);
		$criteria->compare('modify_time',$this->modify_time,true);
		$criteria->compare('ordering',$this->ordering);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Modules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
