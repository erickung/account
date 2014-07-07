<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $customer_id
 * @property string $user_id
 * @property string $mobile_num
 * @property string $name
 * @property integer $type
 * @property integer $status
 * @property string $address
 * @property integer $sex
 * @property string $birthday
 *
 * The followings are the available model relations:
 * @property User $user
 * @property CustomerPurchase[] $customerPurchases
 */
class Customer extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'customerPurchases' => array(self::HAS_MANY, 'CustomerPurchase', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'customer_id' => 'Customer',
			'user_id' => '销售',
			'mobile_num' => '电话号码',
			'name' => '客户名',
			'type' => '客户类型',
			'status' => '客户状态',
			'address' => '地址',
			'sex' => '性别',
			'birthday' => '生日',
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

		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('mobile_num',$this->mobile_num,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('status',$this->status);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('birthday',$this->birthday,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
