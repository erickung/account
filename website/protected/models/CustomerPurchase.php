<?php

/**
 * This is the model class for table "customer_purchase".
 *
 * The followings are the available columns in table 'customer_purchase':
 * @property integer $ps_id
 * @property integer $product_id
 * @property integer $customer_id
 * @property integer $appoint_account
 * @property integer $real_account
 * @property integer $status
 * @property string $note
 * @property integer $account_status
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property ProductInfo $product
 * @property Customer $customer
 */
class CustomerPurchase extends RootActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'customer_purchase';
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'product' => array(self::BELONGS_TO, 'ProductInfo', 'product_id'),
			'customer' => array(self::BELONGS_TO, 'Customer', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ps_id' => 'Ps',
			'product_id' => 'Product',
			'customer_id' => 'Customer',
			'appoint_account' => '购买金额',
			'real_account' => 'Real Account',
			'status' => '状态',
			'note' => 'Note',
			'account_status' => '打款状态',
			'user_id' => 'User',
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

		$criteria->compare('ps_id',$this->ps_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('appoint_account',$this->appoint_account);
		$criteria->compare('real_account',$this->real_account);
		$criteria->compare('status',$this->status);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('account_status',$this->account_status);
		$criteria->compare('user_id',$this->user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CustomerPurchase the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
