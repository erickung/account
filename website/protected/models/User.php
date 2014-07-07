<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $user_id
 * @property string $user_email
 * @property string $user_name
 * @property integer $user_status
 * @property string $last_login_time
 * @property string $token
 * @property string $password
 *
 * The followings are the available model relations:
 * @property ProductRole[] $productRoles
 * @property Roles[] $roles
 */
class User extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'productRoles' => array(self::MANY_MANY, 'ProductRole', 'user_product_role(user_id, pr_id)'),
			'roles' => array(self::MANY_MANY, 'Roles', 'user_roles(user_id, role_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => 'User',
			'user_email' => 'User Email',
			'user_name' => '用户名称',
			'user_status' => '用户状态（1：有效；0：无效）',
			'last_login_time' => '最后登录时间',
			'token' => '登录token',
			'password' => '密码',
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

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('user_email',$this->user_email,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('user_status',$this->user_status);
		$criteria->compare('last_login_time',$this->last_login_time,true);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
